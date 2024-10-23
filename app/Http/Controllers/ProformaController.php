<?php

namespace App\Http\Controllers;

use App\Models\Admin\Personal;
use App\Models\Comercio\ComercioProductos;
use App\Models\Comercio\Proforma;
use App\Models\Comercio\ProformaProductos;
use App\Models\Comercio\Producto;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProformaController extends Controller
{
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

        $proformas = Proforma::all();

        return view('proforma.listado', compact('primerDia', 'ultimoDia', 'proformas'));
    }

    public function guardarCliente(Request $request)
    {
        $request->validate([
            'fecha_registro' => 'required|date',
            'cliente_nombre' => 'required|string|min:2|max:150'
        ]);

        $proforma = new Proforma();
        $proforma->gestion = date('Y');
        $proforma->fecha_registro = $request->fecha_registro;
        $proforma->cliente_ci = $request->cliente_ci;
        $proforma->cliente_nombre = $request->cliente_nombre;
        $proforma->usuario_id = Auth::id();
        $proforma->save();
        
        return redirect()->route('proforma.generar', ['id'=>$proforma]);
    }

    public function generar($id)
    {
        $personal = Personal::all();
        $proforma = Proforma::find($id);
        //if(!$proforma)return to_route('proforma.listado')->with('estadoProforma', 'La proforma solicitada no esta en el sistema.');
        $productosProforma = ProformaProductos::where('proforma_id', $proforma->id)->get();
        $productos = Producto::all();

        return view('proforma.generar', compact('personal', 'proforma', 'productosProforma', 'productos'));
    }

    public function generarPdf($id)
    {
        $proforma = Proforma::find($id);
        $productosProforma = ProformaProductos::where('proforma_id', $proforma->id)->get();
        if(!count($productosProforma)){
            $comercio_id = $proforma->comercios[0]->id;
            $comProductos = ComercioProductos::where('comercio_id', $comercio_id)->get();
            foreach($comProductos as $item){
                $prod = new ProformaProductos();
                $prod->proforma_id = $proforma->id;
                $prod->producto_id = $item->producto_id;
                $prod->cantidad = $item->cantidad_venta;
                $prod->precio_unitario = $item->precio_venta;
                $prod->precio_total = $item->precio_venta_total;
                $prod->save();
            }
            $productosProforma = ProformaProductos::where('proforma_id', $proforma->id)->get();
        }
        $pdf = PDF::loadView('proforma.pdf',[
            'proforma' => $proforma,
            'productosProforma' => $productosProforma,
        ]);

        $pdf->setPaper('a6', 'landscape');//--horizontal
        //$pdf->setPaper('a6', 'portrait');
        //return $pdf->render(); //--en memoria
        return $pdf->stream(); //--en pantalla
    }

    public function guardarProducto(Request $request)
    {
        $request->validate([
            'proforma_id' => 'required|integer',
            'producto_id' => 'required|integer',
            'cantidad' => 'required|integer',
            'precio_unitario' => 'required|numeric',
            'precio_total' => 'required|numeric',
        ]);

        $prodProforma = new ProformaProductos();
        $prodProforma->proforma_id = $request->proforma_id;
        $prodProforma->producto_id = $request->producto_id;
        $prodProforma->cantidad = $request->cantidad;
        $prodProforma->precio_unitario = $request->precio_unitario;
        $prodProforma->precio_total = $request->precio_total;
        $prodProforma->save();
        //dd($prodProforma);
        
        return redirect()->route('proforma.generar', ['id'=>$request->proforma_id]);
    }
}
