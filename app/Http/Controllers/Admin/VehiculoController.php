<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Combustible;
use App\Models\Admin\Mantenimiento;
use App\Models\Admin\TanqueCombustible;
use App\Models\Admin\TipoServicio;
use App\Models\Admin\Vehiculo;
use App\Models\Comercio\Comercio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Traits\PeriodicidadTrait;

class VehiculoController extends Controller
{
    use PeriodicidadTrait;

    private $dias = array('Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab');
    private $meses = array('', 'Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic');
    //---listado de vehiculos
    public function vehiculos()
    {
        
        $hoy = Carbon::now();

        $mes = date('m');
        $dia = date('d');
        $year = date('Y');

        $semana=date("W",mktime(0,0,0, $mes, $dia, $year)); // Día de la semana de la fecha dada
        $diaSemana=date("w",mktime(0,0,0, $mes, $dia, $year)); // 0 es el domingo
        if($diaSemana==0){ $diaSemana=7; } // A la fecha recibida, le restamos el dia de la semana y obtendremos el lunes
        $primerDia= date("Y-m-d",mktime(0,0,0, $mes, $dia-$diaSemana+1, $year));

        $semana=date("W",mktime(0,0,0, $mes, $dia, $year)); // Día de la semana de la fecha dada 
        $diaSemana=date("w",mktime(0,0,0, $mes, $dia, $year)); // 0 es domingo
        if($diaSemana==0){ $diaSemana=7; } // A la fecha recibida, le sumamos el dia de la semana menos siete y obtendremos el domingo
        $ultimoDia=date("Y-m-d",mktime(0,0,0, $mes, $dia+(7-$diaSemana), $year));

        $vehiculos = Vehiculo::all();
        $prom_vueltas = 10;
        $costo = 0;
        $volumen = 0;
        $facturas = 0;
        $nro_vueltas = 0;
        foreach($vehiculos as &$ve){
            $costo = 0;
            $volumen = 0;
            $facturas = 0;
            $combustibles = Combustible::where('vehiculo_id', $ve->id)
                            ->where('fecha','>=',$primerDia)
                            ->where('fecha','<=',$ultimoDia)
                            ->get();
                            // dd($combustibles);
            //---combustible cargado al vehiculo
            foreach($combustibles as $car){
                $costo += $car->costo;
                $volumen += $car->volumen;
                $facturas++;
                //---cuantas vueltas dio
                // $vueltas = Comercio::where('combustible_id', $car->id)
                //             ->where('fecha','>=',$primerDia)
                //             ->where('fecha','<=',$ultimoDia)
                //             ->get();
                // $comb_gastado = 0;
                // $giros = 0;
                // foreach($vueltas as $vue){
                //     $comb_gastado += $vue->costo_combustible;
                //     $giros++;
                // }
            }
            //---disponibilidad de combustible en el tanque
            $disponibilidad = 0;
            $tanque = TanqueCombustible::where('vehiculo_id', $ve->id)->first();
            if($tanque) $disponibilidad = $tanque->costo;

            $ve['total_costo'] = $costo;
            $ve['total_volumen'] = $volumen;
            $ve['total_fac'] = $facturas;
            $ve['total_vueltas'] = 0;
            $ve['disponibilidad'] = $disponibilidad;
            // $ve['comb_gastado'] = $comb_gastado;
            // $ve['giros'] = $giros;
            
        }
        $desde = $this->dias[date('w')].' '.$dia.', '.$this->meses[$mes*1].' '.$year;
        $hasta = $this->dias[date('w')].' '.$dia.', '.$this->meses[$mes*1].' '.$year;
        $tipoMantenimiento= TipoServicio::all();
        
        return view('admin.vehiculos', compact('vehiculos', 'primerDia', 'ultimoDia', 'desde', 'tipoMantenimiento'));
    }
    //---vehiculos Nuevo
    public function vehiculosNuevo()
    {
        return view('admin.vehiculoNuevo');
    }
    //---vehiculos guardar
    public function vehiculosGuardar(Request $request)
    {
        $request->validate([
            'marca' => 'required|string',
            'color' => 'required|string',
            'modelo' => 'required|integer',
            'placa' => 'required|string|unique:vehiculos,placa',
        ]);

        $vehiculo = new Vehiculo();
        $vehiculo->marca = $request->marca;
        $vehiculo->color = $request->color;
        $vehiculo->modelo = $request->modelo;
        $vehiculo->placa = $request->placa;
        $vehiculo->usuario_id = Auth::user()->id;
        $vehiculo->save();

        return to_route('admin.vehiculos');
    }

    //---cargado de combustible
    public function vehiculosCombustible(Vehiculo $vehiculo)
    {
        return view('admin.cargarCombustible', compact('vehiculo'));
    }
    public function combustibleCargar(Request $request)
    {
        $request->validate([
            'vehiculo_id' => 'required|integer',
            'fecha' => 'required|date',
            'factura' => 'required|string',
            'precio_unitario' => 'required|decimal:1,10',
            'costo' => 'required|integer',
        ]);

        $combustible = new Combustible();
        $combustible->vehiculo_id = $request->vehiculo_id;
        $combustible->fecha = $request->fecha;
        $combustible->factura = $request->factura;
        $combustible->precio_unitario = $request->precio_unitario;
        $combustible->costo = $request->costo;
        $combustible->volumen = number_format($request->costo/$request->precio_unitario,2);
        $combustible->usuario_id = Auth::user()->id;
        $combustible->save();

        $tanque = TanqueCombustible::where('vehiculo_id', $request->vehiculo_id)->first();
        if(!$tanque){
            $tanque = new TanqueCombustible();
            $tanque->vehiculo_id = $request->vehiculo_id;
            $tanque->fecha = date('Y-m-d h:i:s');
            $tanque->precio_unitario = 0;
            $tanque->costo = 0;
            $tanque->usuario_id = Auth::user()->id;
            $tanque->save();
        }
        $tanque->vehiculo_id = $request->vehiculo_id;
        $tanque->fecha = $request->fecha;
        $tanque->precio_unitario = $request->precio_unitario;
        $tanque->costo = $tanque->costo + $request->costo;
        $tanque->usuario_id = Auth::user()->id;
        $tanque->save();

        return to_route('admin.vehiculos');
    }

    //---despliegue del historial de cargado de combustible
    public function vehiculosCombustibleHistorial(Request $request)
    {
        $request->validate([
            'vehiculo_id' => 'required|integer',
            'fecha_comercio' => 'required',
        ]);
        $fecha_comercio=$request->fecha_comercio;
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
        
        $combustibles = Combustible::where('fecha', '>=', $primerDia)
                            ->where('fecha', '<=', $ultimoDia)
                            ->where('vehiculo_id', $request->vehiculo_id)
                            ->orderBy('id', 'ASC')->get();

        $mantenimiento = Mantenimiento::where('fecha', '>=', $primerDia)
                            ->where('fecha', '<=', $ultimoDia)
                            ->where('vehiculo_id', $request->vehiculo_id)
                            ->orderBy('id', 'ASC')->get();

        $vehiculo = Vehiculo::find($request->vehiculo_id);
        
        $historial = view('admin.vehiculoHistorialCombustible',compact('combustibles', 'mantenimiento'))->render();
        return response()->json([
            'estado' => true,
            'tabla_historial' => $historial,
            'vehiculo' => $vehiculo->marca.' '.$vehiculo->placa,
        ], 200);
    }

    //---
    public function vehiculoMantenimiento(Vehiculo $vehiculo)
    {
        $tipoMantenimiento= TipoServicio::all();
        return view('admin.mantenimientoVehiculo', compact('vehiculo', 'tipoMantenimiento'));
    }

    //---recuparacion de datos de un vehiculo
    public function datosVehiculo(Request $request)
    {
        $vehiculo = Vehiculo::find($request->vehiculo_id);
        return response()->json([
            'estado' => true,
            'vehiculo' => $vehiculo
        ], 200);
    }

    //---guardar mantenimiento
    public function mantenimientoGuardar(Request $request)
    {
        $request->validate([
            'vehiculo_id' => 'required|integer',
            'tipo_servicio_id' => 'required|integer',
            'fecha' => 'required|date',
            'costo_servicio' => 'required|numeric',
            'costo_material' => 'required|numeric',
        ]);

        $mantenimiento = new Mantenimiento();
        $mantenimiento->vehiculo_id = $request->vehiculo_id;
        $mantenimiento->tipo_servicio_id = $request->tipo_servicio_id;
        $mantenimiento->fecha = $request->fecha;
        $mantenimiento->costo_servicio = $request->costo_servicio;
        $mantenimiento->costo_material = $request->costo_material;
        $mantenimiento->usuario_id = Auth::user()->id;
        $mantenimiento->save();

        return to_route('admin.vehiculos');
    }
}
