<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Combustible;
use App\Models\Admin\Personal;
use App\Models\Comercio\Proforma;
use App\Models\Admin\Vehiculo;
use App\Models\Comercio\Comercio;
use App\Models\Comercio\Producto;
use App\Models\Comercio\ProformaProductos;
use DragonCode\Support\Facades\Helpers\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ComercioController extends Controller
{
    //---
    public function listado()
    {
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

        $vueltas = Comercio::all();
        $combustible = Combustible::orderBy('id', 'DESC')->first();

        return view('comercio.listado', compact('primerDia', 'ultimoDia', 'vueltas', 'combustible'));
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
        //dd($request->all());
        $request->validate([
            'vehiculo_id' => 'required|integer',
            'producto_id' => 'required',
            //'proforma_id' => 'required',
            'combustible_id' => 'required',
            'vuelta' => 'required|integer',
            'fecha' => 'required|date',
            'cantidad_compra' => 'required|numeric',
            'precio_compra' => 'required|numeric',
            'cantidad_venta' => 'required|numeric',
            'precio_venta' => 'required|numeric',
            'cantidad_saldo' => 'required|numeric',
            'precio_saldo' => 'required|numeric',
            'personal_id' => 'required|integer',
        ]);
        
        if(isset($request->proforma_id) && !empty($request->proforma_id)){
            $proforma_id = $request->proforma_id;
        }else{
            $proforma = new Proforma();
            $proforma->gestion = date('Y');
            $proforma->fecha_registro = date('Y-m-d');
            $proforma->cliente_ci = 0;
            $proforma->cliente_nombre = 'SN';
            $proforma->usuario_id = Auth::id();
            $proforma->save();
            $proforma_id = $proforma->id;

            $prodPro = new ProformaProductos();
            $prodPro->proforma_id = $proforma_id;
            $prodPro->producto_id = $request->producto_id;
            $prodPro->cantidad = $request->cantidad_venta;
            if(!$request->cantidad_venta) $prodPro->precio_unitario = 0;
            else $prodPro->precio_unitario = $request->precio_venta / $request->cantidad_venta;
            $prodPro->precio_total = $request->precio_venta;
            $prodPro->save();
        }

        $comercio = new Comercio();
        $comercio->vehiculo_id = $request->vehiculo_id;
        $comercio->combustible_id = $request->combustible_id;
        $comercio->vuelta = $request->vuelta;
        $comercio->fecha = $request->fecha;
        $comercio->producto_id = $request->producto_id;
        $comercio->cantidad_compra = $request->cantidad_compra;
        $comercio->precio_compra = $request->precio_compra;
        $comercio->cantidad_venta = $request->cantidad_venta;
        $comercio->precio_venta = $request->precio_venta;
        $comercio->cantidad_saldo = $request->cantidad_saldo;
        $comercio->precio_saldo = $request->precio_saldo;
        $comercio->lugar_venta = $request->lugar_venta;
        $comercio->personal_id = $request->personal_id;
        $comercio->usuario_id = Auth::user()->id;
        $comercio->proforma_id = $proforma_id;
        $comercio->save();

        return to_route('comercio.listado');
    }
}
