<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Proforma {{$proforma->id}}-{{$proforma->gestion}}</title>

    <style>
        @font-face{
            font-family: "Dosis";
            src: url("{{ storage_path('fonts/Dosis-Light.ttf') }}") format('truetype');
            font-weight: 100;
            font-style: normal;
        }

        @font-face{
            font-family: "Dosis";
            src: url("{{storage_path('fonts/Dosis-Regular.ttf')}}") format('truetype');
            font-weight: 400;
            font-style: normal;
        }

        @font-face{
            font-family: "Dosis";
            src: url("{{storage_path('fonts/Dosis-Bold.ttf')}}") format('truetype');
            font-weight: 700;
            font-style: normal;
        }
    </style>
    
    <style>
        @page{
            margin: 0.3cm 0.3cm;
        }
        body {
            background-image: url("{{asset('plantilla/img/ladrillos.jpg')}}");
            background-size: 100%;
            background-repeat: no-repeat;
        }
        #header{
            position: fixed;
            top: 0cm;
            left: 0cm;
        }
        .imgHeader{
            float: left;
            width: 3cm;
        }
        .imgHeader2{
            float: left;
            width: 10cm;
        }
        #footer{
            position: fixed;
            bottom: 0cm;
            left: 0cm;
            width: 100%;
        }
        .textFooter{
            text-align: center;
            width: 100%;
        }
        .contenido{
            /* Top Right Bottom Left*/
            margin: 1cm 1.2cm 1.5cm 1.2cm;
        }
        .contenido2{
            /* Top Right Bottom Left*/
            margin: -1.5cm 0cm 1.5cm 0cm;
        }
        .nota{
            font-family: Verdana, Geneva, Tahoma, sans-serif;
            font-size: 10px;
            text-align: justify;
        }
        table {
            /*border: #b2b2b2 1px solid;*/
            width: 100%;
            font-family: Verdana, Geneva, Tahoma, sans-serif;
            font-size: 13px;
        }
        .celda{
            border-bottom: #b2b2b2 1px solid; 
            border-right: #b2b2b2 1px solid;
            font-family: Verdana, Geneva, Tahoma, sans-serif;
            font-size: 12px;
        }
        .celda_ii{
            border-top: #b2b2b2 1px solid; 
            border-bottom: #b2b2b2 1px solid; 
            border-right: #b2b2b2 1px solid;
            font-family: Verdana, Geneva, Tahoma, sans-serif;
            font-size: 12px;
        }
        .celda_ff{
            border-bottom: #b2b2b2 1px solid;
            font-family: Verdana, Geneva, Tahoma, sans-serif;
            font-size: 12px;
        }
        .text-center{
            text-align: center;
        }
        .text-numero{
            text-align:right;
        }
        .seccion{
            font-weight: bold;
            font-size: 17px;
        }
        .dato{
            /*font-weight: bold;*/
            font-size: 16px;
        }
        .fecha{
            font-family: Verdana, Geneva, Tahoma, sans-serif;
            font-size: 12px;
        }
        .titulo{
            font-family: Verdana, Geneva, Tahoma, sans-serif;
            font-size: 14px;
        }
    </style>
</head>
<body>
    {{-- contenido del pdf --}}
    <div class="contenido">
        <h3 class="titulo" align="center"> PROFORMA {{ sprintf('%04d', $proforma->id) }}/{{$proforma->gestion }}<br>
            DISTRIBUIDORA DE LADRILLOS<br>
            FERRETERIA - "SARZURI" JDA
        </h3>
        <table class="">
            <tr>
                <td>
                    <label>Nombre cliente: {{ $proforma->cliente_nombre }} - (CI: {{ $proforma->cliente_ci }})</label>
                </td>
            </tr>
        </table>
        <br>
        <table>
            <thead>
                <tr>
                    <th scope="col" class="celda_ii">Nro</th>
                    <th scope="col" class="celda_ii">Producto</th>
                    <th scope="col" class="celda_ii">Cantidad</th>
                    <th scope="col" class="celda_ii">Precio unitario</th>
                    <th scope="col" class="celda_ii">Total</th>
                </tr>
            </thead>
            <tbody>
                @php($cantidad_total=0)
                @php($precio_total=0)
                @php($i=0)
                @forelse ($productosProforma as $item)
                @php($cantidad_total = $cantidad_total + $item->cantidad)
                @php($precio_total = $precio_total + $item->precio_total)
                @php($i++)
                    <tr>
                        <td class="celda">{{ $i }}</td>
                        <td class="celda">{{ $item->producto->descripcion }} ({{ $item->producto->sigla }})</td>
                        <td class="celda">{{ number_format($item->cantidad,0) }}</td>
                        <td class="celda">{{ number_format($item->precio_unitario,2) }}</td>
                        <td class="celda">{{ number_format($item->precio_total,2) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td class="celda" colspan="6" align="center">Sin productos ...!!!</td>
                    </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr>
                    @php($formatterES = new NumberFormatter("es", NumberFormatter::SPELLOUT) )
                    <td class="celda" colspan="4">Son: {{ $formatterES->format($precio_total) }} 00/100 bolivianos</td>
                    <td class="celda"><b>{{ number_format($precio_total,2) }}<b></td>
                </tr>
            </tfoot>
        </table>
        <p class="nota">* Esta cotización tiene vigencia de 5 días.</p>
        <p align="center" class="fecha">Fecha: {{ date('d/m/Y',strtotime($proforma->fecha_registro)) }}</p>
    </div>
    
    {{-- pie de pagina --}}
    <div id="footer">
        <p class="textFooter"> {{ date('Y') }} </p>
</body>
</html>