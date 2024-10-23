<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comercio\Comercio;
use App\Traits\PeriodicidadTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;

class InicioController extends Controller
{
    use PeriodicidadTrait;
    //---pantalla resumen
    public function dashboard($fecha_comercio)
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
            return to_route('admin.dashboard',['fecha_comercio'=>date('Y-m-d')])->with('estadoResumen', 'La fecha solicitada no es válido, verifique por favor..!!');
        }

        $vueltas = Comercio::where('fecha', '>=', $primerDia)
                    ->where('fecha', '<=', $ultimoDia)
                    ->get();
        $cantidad_compra=0;
        $precio_compra_total=0;
        $cantidad_venta=0;
        $precio_venta_total=0;

        foreach($vueltas as $vue){
            foreach($vue->comercioProductos as $cp){
                if($cp->tipo_origen_id == 1){
                    $cantidad_compra += $cp->cantidad_compra;
                    $precio_compra_total += $cp->precio_compra_total;
                }

                $cantidad_venta += $cp->cantidad_venta;
                $precio_venta_total += $cp->precio_venta_total;
            }
        }
        $saldo = $cantidad_compra - $cantidad_venta;
        //dd($vueltas);
        return view('admin.dashboard', compact('fecha','fanterior','fsiguiente',
            'cantidad_compra','precio_compra_total','cantidad_venta','precio_venta_total', 'saldo'));
    }
}
