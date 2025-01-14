<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Combustible;
use App\Models\Admin\Personal;
use App\Models\Admin\TanqueCombustible;
use App\Models\Admin\TipoAlmacen;
use App\Models\Admin\TipoOrigen;
use App\Models\Comercio\Proforma;
use App\Models\Admin\Vehiculo;
use App\Models\Comercio\Almacen;
use App\Models\Comercio\Comercio;
use App\Models\Comercio\ComercioProductos;
use App\Models\Comercio\Producto;
use App\Models\Comercio\ProformaProductos;
use App\Traits\PeriodicidadTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class ComercioController extends Controller
{
    use PeriodicidadTrait;
    //---
    public function listado($fecha_comercio)
    {
        $fanterior = new Carbon($fecha_comercio);
        $fsiguiente = new Carbon($fecha_comercio);
        $fanterior->add(-1, 'week');
        $fsiguiente->add(1, 'week');
        
        $fecha = $this->semana(date('d',strtotime($fecha_comercio)), date('m',strtotime($fecha_comercio)), date('Y',strtotime($fecha_comercio)));
        $semana = $fecha['semana'];
        $primerDia = $fecha['ini'];
        $ultimoDia = $fecha['fin'];
        if(!$semana){
            return to_route('admin.dashboard', ['fecha_comercio'=>date('Y-m-d')])->with('estadoResumen', 'La fecha solicitada no es válido, verifique por favor..!!');
        }
        
        $vueltas = Comercio::where('fecha', '>=', $primerDia)
                            ->where('fecha', '<=', $ultimoDia)
                            ->get();
        
        $combustible = Combustible::where('fecha', '>=', $primerDia)
                            ->where('fecha', '<=', $ultimoDia)
                            ->orderBy('id', 'DESC')->first();

        $vehiculos = Vehiculo::orderBy('id', 'DESC')->get();
        $personal = Personal::where('activo', true)->get();
        $proformasLibres = Proforma::select('proformas.id', 'proformas.gestion', 'proformas.fecha_registro', 'proformas.cliente_ci', 'proformas.cliente_nombre', 'comercio.proforma_id')
                        ->leftJoin('comercio', 'comercio.proforma_id', '=', 'proformas.id')
                        ->where('comercio.proforma_id', null)
                        ->orderBy('proformas.id', 'ASC')
                        ->get();

        return view('comercio.listado', compact('primerDia', 'ultimoDia', 'vueltas', 'combustible', 'vehiculos', 'personal','proformasLibres', 
                'fanterior', 'fsiguiente','fecha_comercio'));
    }

    //---seleccionar el vehiculo a registra comercializacion
    public function seleccionarVehiculo()
    {
        $hoy = date('d/m/Y');
        $vehiculos = Vehiculo::all();
        return view('comercio.seleccionarVehiculo', compact('hoy', 'vehiculos'));
    }

    public function operacion(Vehiculo $vehiculo)
    {
        $personal = Personal::all();
        $productos = Producto::all();
        $proformas = Proforma::all();
        $combustible = Combustible::where('vehiculo_id', $vehiculo->id)
                        ->orderBy('id', 'DESC')
                        ->first();
        if(!$combustible){
            return to_route('comercio.listado')->with('estadoComercio','El vehiculo: '.$vehiculo->marca.', no tiene combustible cargado.');
        }
        $ultima_vuelta = Comercio::where('vehiculo_id', $vehiculo->id)
                        ->where('combustible_id', $combustible->id)
                        ->orderBy('vuelta', 'DESC')
                        ->first();
        if($ultima_vuelta){
            $nro_vuelta = $ultima_vuelta->vuelta + 1;
        }else{
            $nro_vuelta = 1;
        }
        
        return view('comercio.operacionNuevo', compact('nro_vuelta', 'vehiculo', 'personal', 'productos','combustible', 'proformas'));
    }

    public function operacionGuardar(Request $request)
    {
        // dd($request->input());
        $request->validate([
            'cliente' => 'required|string|max:75',
            'cliente_celular' => 'required|string|max:20|min:8',
            'vehiculo_id' => 'required|integer',
            'combustible_id' => 'required|integer',
            'vuelta' => 'required|integer',
            'fecha' => 'required|date',
            'transporte' => 'required|integer',
            'lugar_venta' => 'required',
            'personal_id' => 'required|integer',
            'proforma_id' => 'required',
            'refresco' => 'required|numeric',
            'peaje' => 'required|numeric',
            'viatico' => 'required|numeric',
            'corte_mitad' => 'required|numeric',
            'costo_combustible' => 'required|numeric',
        ],[
            'combustible_id.required' => 'Sin combustible'
        ]);
        
        //---verifica si es venta a una proforma
        if($request->proforma_id == 0){
            //---si no hay proforma, entonces se crea
            $proforma = new Proforma();
            $proforma->gestion = date('Y');
            $proforma->fecha_registro = date('Y-m-d');
            $proforma->cliente_ci = $request->cliente_celular;
            $proforma->cliente_nombre = $request->cliente;
            $proforma->usuario_id = Auth::id();
            $proforma->save();
            $proforma_id = $proforma->id;
        }else{
            $proforma_id = $request->proforma_id;
        }

        $comercio = new Comercio();
        $comercio->cliente = $request->cliente;
        $comercio->cliente_celular = $request->cliente_celular;
        $comercio->vehiculo_id = $request->vehiculo_id;
        $comercio->combustible_id = $request->combustible_id;
        $comercio->vuelta = $request->vuelta;
        $comercio->fecha = $request->fecha;
        $comercio->transporte = $request->transporte;
        $comercio->lugar_venta = $request->lugar_venta;
        $comercio->observacion = $request->observacion;
        $comercio->refresco = $request->refresco;
        $comercio->peaje = $request->peaje;
        $comercio->viatico = $request->viatico;
        $comercio->corte_mitad = $request->corte_mitad;
        $comercio->costo_combustible = $request->costo_combustible;
        $comercio->personal_id = $request->personal_id;
        $comercio->proforma_id = $proforma_id;
        $comercio->usuario_id = Auth::user()->id;
        $comercio->save();

        //---actualizando tanque combustible
        $tanque = TanqueCombustible::where('vehiculo_id', $request->vehiculo_id)->first();
        // $tanque->vehiculo_id = $request->vehiculo_id;
        $tanque->fecha = $request->fecha;
        // $tanque->precio_unitario = $request->precio_unitario;
        $tanque->costo = $tanque->costo - $request->costo_combustible;
        $tanque->usuario_id = Auth::user()->id;
        $tanque->save();
        
        //---se recupera los producto de la proforma para adicionar al comercio
        $profProductos = ProformaProductos::where('proforma_id', $proforma_id)->get();
        if(count($profProductos)){
            foreach($profProductos as $item){
                $comProd = new ComercioProductos();
                $comProd->comercio_id = $comercio->id;
                $comProd->producto_id = $item->producto_id;
                $comProd->tipo_origen_id = 1; //---por defecto fabrica
                $comProd->cantidad_compra = $item->cantidad;
                $comProd->precio_compra = 0;
                $comProd->precio_compra_total = 0;
                $comProd->cantidad_venta = $item->cantidad;
                $comProd->precio_venta = $item->precio_unitario;
                $comProd->precio_venta_total = $item->precio_total;
                $comProd->save();
            }
        }

        return to_route('comercio.operacion.productos',['comercio'=>$comercio]);
    }

    public function combustibleVehiculo(Request $request)
    {
        $fecha = $this->semana(date('d', strtotime($request->fecha_comercio)), date('m', strtotime($request->fecha_comercio)), date('Y', strtotime($request->fecha_comercio)));

        $primerDia = $fecha['ini'];
        $ultimoDia = $fecha['fin'];

        if(isset($request->id_vehiculo) && !empty($request->id_vehiculo) && is_numeric($request->id_vehiculo)){
            $vehiculo = Vehiculo::find($request->id_vehiculo);
            $combustible = Combustible::where('vehiculo_id', $vehiculo->id)
                            ->where('fecha', '>=', $primerDia)
                            ->where('fecha', '<=', $ultimoDia)
                            ->orderBy('id', 'DESC')
                            ->first();
            if($combustible){
                return response()->json([
                    'estado' => true,
                    'combustible' => $combustible->id,
                    'mensaje' => '<label class="text-success"><i class="fas fa-truck-moving"></i> Tiene diesel</label>',
                ]);
            }else{
                return response()->json([
                    'estado' => false,
                    'mensaje' => '<label class="text-danger"><i class="fas fa-truck-moving"></i> Sin diesel</label>',
                    'alerta' => 'El vehículo seleccionado no tiene Combustible',
                ]);
            }
        }

        return response()->json([
            'estado' => false,
            'mensaje' => '<label class="text-warning">..Seleccione..</label>',
            'alerta' => 'Seleccione un vehículo para verificar su Combustible',
        ]);
    }

    public function comercioProductos(Comercio $comercio)
    {
        $productos = Producto::all();
        $productosComercio = ComercioProductos::where('comercio_id', $comercio->id)->get();
        $tipoOrigen = TipoOrigen::all();
        $tipoAlmacen = TipoAlmacen::all();
        return view('comercio.operacionProductos', compact('comercio', 'productos', 'productosComercio', 'tipoOrigen', 'tipoAlmacen'));
    }

    public function comercioProductoGuardar(Request $request)
    {
        $request->validate([
            'comercio_id' => 'required|integer',
            'producto_id' => 'required|integer',
            'tipo_origen_id' => 'required|integer',
            'cantidad_compra' => 'required|numeric',
            'precio_compra' => 'required|numeric',
            'precio_compra_total' => 'required|numeric',
            'cantidad_venta' => 'required|numeric',
            'precio_venta' => 'required|numeric',
            'precio_venta_total' => 'required|numeric',
            'cantidad_saldo' => 'required|numeric',
            'precio_saldo' => 'required|numeric',
            'tipo_almacen_id' => 'required|integer',
        ]);
        
        $comProd = new ComercioProductos();
        $comProd->comercio_id = $request->comercio_id;
        $comProd->producto_id = $request->producto_id;
        $comProd->tipo_origen_id = $request->tipo_origen_id;
        $comProd->cantidad_compra = $request->cantidad_compra;
        $comProd->precio_compra = $request->precio_compra;
        $comProd->precio_compra_total = $request->precio_compra_total;
        $comProd->cantidad_venta = $request->cantidad_venta;
        $comProd->precio_venta = $request->precio_venta;
        $comProd->precio_venta_total = $request->precio_venta_total;
        $comProd->save();

        if($request->cantidad_saldo){
            $almacen = new Almacen();
            $almacen->comercio_productos_id = $comProd->id;
            $almacen->producto_id = $comProd->producto_id;
            $almacen->tipo_almacen_id = $request->tipo_almacen_id;
            $almacen->cantidad = $request->cantidad_saldo;
            $almacen->precio = $request->precio_saldo;
            $almacen->save();
        }
        //dd($almacen);

        $comercio = Comercio::find($request->comercio_id);

        return to_route('comercio.operacion.productos',['comercio'=>$comercio]);
    }

    public function comercioProductoEliminar(Request $request)
    {
        $request->validate([
            'comercio_productos_id' => 'required|integer',
        ]);
        $comProd = ComercioProductos::find($request->comercio_productos_id);
        $comProd->delete();

        $comercio = Comercio::find($comProd->comercio_id);
        return to_route('comercio.operacion.productos',['comercio'=>$comercio]);
    }

    public function comercioProductoEdit(Request $request)
    {
        $id = $request->comercio_productos_id;
        $prod = ComercioProductos::find($id);
        if($prod){
            return response()->json([
                'estado' =>true,
                'mensaje' => 'Producto recuperado',
                'comProducto' => $prod,
            ], 200);
        }else{
            return response()->json([
                'estado' =>false,
                'mensaje' => 'ERROR: Producto no encontrado',
            ], 200);
        }
    }

    public function comercioProductoActualizar(Request $request)
    {
        $request->validate([
            'com_prod_id' => 'required|integer',
            'comercio_id' => 'required|integer',
            'producto_id' => 'required|integer',
            'tipo_origen_id' => 'required|integer',
            'cantidad_compra_e' => 'required|numeric',
            'precio_compra_e' => 'required|numeric',
            'precio_compra_total_e' => 'required|numeric',
            'cantidad_venta_e' => 'required|numeric',
            'precio_venta_e' => 'required|numeric',
            'precio_venta_total_e' => 'required|numeric',
            'cantidad_saldo_e' => 'required|numeric',
            'precio_saldo_e' => 'required|numeric',
            'tipo_almacen_id' => 'required|integer',
        ]);
        
        $comProd = ComercioProductos::find($request->com_prod_id);
        $comProd->comercio_id = $request->comercio_id;
        $comProd->producto_id = $request->producto_id;
        $comProd->tipo_origen_id = $request->tipo_origen_id;
        $comProd->cantidad_compra = $request->cantidad_compra_e;
        $comProd->precio_compra = $request->precio_compra_e;
        $comProd->precio_compra_total = $request->precio_compra_total_e;
        $comProd->cantidad_venta = $request->cantidad_venta_e;
        $comProd->precio_venta = $request->precio_venta_e;
        $comProd->precio_venta_total = $request->precio_venta_total_e;
        $comProd->save();

        if($request->cantidad_saldo_e){
            $almacen = new Almacen();
            $almacen->comercio_productos_id = $comProd->id;
            $almacen->producto_id = $comProd->producto_id;
            $almacen->tipo_almacen_id = $request->tipo_almacen_id;
            $almacen->cantidad = $request->cantidad_saldo_e;
            $almacen->precio = $request->precio_saldo_e;
            $almacen->save();
        }
        //dd($almacen);

        $comercio = Comercio::find($request->comercio_id);

        return to_route('comercio.operacion.productos',['comercio'=>$comercio]);
    }

    public function comercioPdf($fecha_comercio)
    {
        $fecha = $this->semana(date('d',strtotime($fecha_comercio)), date('m',strtotime($fecha_comercio)), date('Y',strtotime($fecha_comercio)));
        $semana = $fecha['semana'];
        $primerDia = $fecha['ini'];
        $ultimoDia = $fecha['fin'];
        if(!$semana){
            return to_route('admin.dashboard', ['fecha_comercio'=>date('Y-m-d')])->with('estadoResumen', 'La fecha solicitada no es válido, verifique por favor..!!');
        }
        
        $vueltas = Comercio::where('fecha', '>=', $primerDia)
                            ->where('fecha', '<=', $ultimoDia)
                            ->get();

        $pdf = PDF::loadView('comercio.pdf',[
            'vueltas' => $vueltas,
            'fecha' => $fecha,
            //'productosProforma' => $productosProforma,
        ]);

        $pdf->setPaper('legal', 'landscape');//--horizontal
        //$pdf->setPaper('a6', 'portrait');
        //return $pdf->render(); //--en memoria
        return $pdf->stream(); //--en pantalla
    }

    public function reporteSemanal($fecha_comercio)
    {
        $fanterior = new Carbon($fecha_comercio);
        $fsiguiente = new Carbon($fecha_comercio);
        $fanterior->add(-1, 'week');
        $fsiguiente->add(1, 'week');
        
        $fecha = $this->semana(date('d',strtotime($fecha_comercio)), date('m',strtotime($fecha_comercio)), date('Y',strtotime($fecha_comercio)));
        $semana = $fecha['semana'];
        $primerDia = $fecha['ini'];
        $ultimoDia = $fecha['fin'];
        if(!$semana){
            return to_route('admin.dashboard', ['fecha_comercio'=>date('Y-m-d')])->with('estadoResumen', 'La fecha solicitada no es válido, verifique por favor..!!');
        }
        
        $vueltas = Comercio::where('fecha', '>=', $primerDia)
                            ->where('fecha', '<=', $ultimoDia)
                            ->get();
        
        $combustible = Combustible::where('fecha', '>=', $primerDia)
                            ->where('fecha', '<=', $ultimoDia)
                            ->orderBy('fecha', 'ASC')->get();

        $vehiculos = Vehiculo::orderBy('id', 'DESC')->get();
        $personal = Personal::where('activo', true)->get();
        $proformasLibres = Proforma::select('proformas.id', 'proformas.gestion', 'proformas.fecha_registro', 'proformas.cliente_ci', 'proformas.cliente_nombre', 'comercio.proforma_id')
                        ->leftJoin('comercio', 'comercio.proforma_id', '=', 'proformas.id')
                        ->where('comercio.proforma_id', null)
                        ->orderBy('proformas.id', 'ASC')
                        ->get();

        return view('comercio.reporteSemanal', compact('primerDia', 'ultimoDia', 'vueltas', 'combustible', 'vehiculos', 'personal','proformasLibres', 
                'fanterior', 'fsiguiente','fecha_comercio'));
    }
    
    public function comercioOperacionEliminar(Request $request)
    {
        $request->validate([
            'comercio_id' => 'required|integer',
            'fecha_comercio' => 'required',
        ]);
        $comercio = Comercio::find($request->comercio_id);
        $comercio->delete();

        return to_route('comercio.listado',['fecha_comercio'=>$request->fecha_comercio]);
    }
}
