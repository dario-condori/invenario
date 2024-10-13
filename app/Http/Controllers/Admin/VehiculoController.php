<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Combustible;
use App\Models\Admin\Vehiculo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class VehiculoController extends Controller
{
    private $dias = array('Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab');
    private $meses = array('', 'Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic');
    //---vehiculos
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
            foreach($combustibles as $car){
                $costo += $car->costo;
                $volumen += $car->volumen;
                $facturas++;
            }
            $ve['total_costo'] = $costo;
            $ve['total_volumen'] = $volumen;
            $ve['total_fac'] = $facturas;
            $ve['total_vueltas'] = 0;
            $ve['disponibilidad'] = $volumen + (($volumen/$prom_vueltas) * $nro_vueltas);
        }
        $desde = $this->dias[date('w')].' '.$dia.', '.$this->meses[$mes*1].' '.$year;
        $hasta = $this->dias[date('w')].' '.$dia.', '.$this->meses[$mes*1].' '.$year;
        return view('admin.vehiculos', compact('vehiculos', 'primerDia', 'ultimoDia', 'desde'));
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
            'precio_unitario' => 'required|decimal:1,10',
            'costo' => 'required|integer',
        ]);

        $combustible = new Combustible();
        $combustible->vehiculo_id = $request->vehiculo_id;
        $combustible->fecha = $request->fecha;
        $combustible->precio_unitario = $request->precio_unitario;
        $combustible->costo = $request->costo;
        $combustible->volumen = number_format($request->costo/$request->precio_unitario,2);
        $combustible->usuario_id = Auth::user()->id;
        $combustible->save();

        return to_route('admin.vehiculos');
    }
}
