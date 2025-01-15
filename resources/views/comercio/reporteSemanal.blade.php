@extends('admin._base-sm')

@section('titulo')
    Reporte semanal
@endsection

@section('contenido')
    <div class="container mt-0">
        <div class="page-inner">
            <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
                <div>
                    <h3 class="fw-bold mb-3">
                        REPORTE SEMANAL, desde {{date('d/m/Y',strtotime($primerDia))}} a {{date('d/m/Y',strtotime($ultimoDia))}}
                        <a href="{{route('comercio.reporte.semanal',['fecha_comercio'=>date('Y-m-d', strtotime($fanterior))])}}" class="btn btn-secondary btn-sm" >
                            <span class="btn-label"><i class="fas fa-angle-double-left"></i></span>
                            Anterior semana
                        </a>
                        <a href="{{route('comercio.reporte.semanal',['fecha_comercio'=>date('Y-m-d', strtotime($fsiguiente))])}}" class="btn btn-secondary btn-sm">
                            <span class="btn-label"><i class="fas fa-angle-double-right"></i></span>
                            Siguiente semana
                        </a>
                    </h3>

                    <input type="hidden" name="fecha_comercio" id="fecha_comercio" value="{{$fecha_comercio}}">

                    <a href="{{ route('comercio.listado',['fecha_comercio'=>date('Y-m-d')]) }}" class="btn btn-success">
                        <i class="fas fa-dollar-sign"></i>
                        Comercialización
                    </a>
                    <a href="{{ route('comercio.operacion.pdf',['fecha_comercio'=>date('Y-m-d', strtotime($fecha_comercio))]) }}" target="_blank" class="btn btn-danger">
                        <span class="btn-label"><i class="fas fa-file-pdf"></i></span>
                        PDF
                    </a>
                    {{-- <button class="btn btn-default">
                        <span class="btn-label"><i class="fa fa-truck"></i></span>
                        @if($combustible)
                            Diesel: {{ number_format($combustible->costo,1) }}_Bs. ({{ $combustible->volumen }}_lt)
                        @else
                        Diesel: {{ number_format(0,1) }}_Bs. ({{ 0 }}_lt)
                        @endif
                    </button> --}}
                </div>
            </div>
            {{-- Estado de vueltas --}}
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="table-responsive">
                            <table class="table table-bordered table-head-bg-info table-bordered-bd-info mt-4 table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col" class="text-center">Vuelta</th>
                                        <th scope="col" class="text-center">Fecha</th>
                                        <th scope="col" class="text-center">Producto</th>
                                        <th scope="col" class="text-center">Cantidad<br>Comprada</th>
                                        <th scope="col" class="text-center">Precio<br>Compra Bs.</th>
                                        <th scope="col" class="text-center">Total<br>compra Bs.</th>
                                        <th scope="col" class="text-center">Cantidad<br>Vendida</th>
                                        <th scope="col" class="text-center">Precio<br>Venta Bs.</th>
                                        <th scope="col" class="text-center">Total<br>Venta Bs.</th>
                                        <th scope="col" class="text-center">Cantidad<br>Sobrante</th>
                                        <th scope="col" class="text-center">Saldo_a<br>Cobrar Bs</th>
                                        <th scope="col" class="text-center">Lugar<br>cliente</th>
                                        <th scope="col" class="text-center">Transporte</th>
                                        <th scope="col" class="text-center">Otros gastos</th>
                                        <th scope="col" class="text-center">Vendedor</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php($cant_compra=0)
                                    @php($compra_total=0)
                                    @php($cant_venta=0)
                                    @php($venta_total=0)
                                    @php($cant_saldo=0)
                                    @php($saldo_total=0)
                                    @php($transporte=0)
                                    @php($refresco=0)
                                    @php($peaje=0)
                                    @php($viatico=0)
                                    @php($costo_combustible=0)
                                    @php($nro=0)
                                    @forelse ($vueltas as $item)
                                        @php($transporte = $transporte + $item->transporte)
                                        @php($refresco = $refresco + $item->refresco)
                                        @php($peaje = $peaje + $item->peaje)
                                        @php($viatico = $viatico + $item->viatico)
                                        @php($costo_combustible = $costo_combustible + $item->costo_combustible)
                                        @php($nro++)
                                        @php($filas = count($item->comercioProductos) )
                                        @php($nf=0)
                                        @forelse ($item->comercioProductos as $comProd)
                                            @php($nf++)
                                            @php($cant_compra += $comProd->cantidad_compra)
                                            @php($compra_total += $comProd->precio_compra_total)
                                            @php($cant_venta += $comProd->cantidad_venta)
                                            @php($venta_total += $comProd->precio_venta_total)
                                            <tr>
                                                @if($nf==1)
                                                    <td rowspan="{{$filas}}">{{ $item->vuelta }}</td>
                                                    <td rowspan="{{$filas}}">{{date('d/m/Y',strtotime($item->fecha))}}</td>
                                                @endif
                                                <td>{{$comProd->producto->descripcion}}</td>
                                                <td>{{number_format($comProd->cantidad_compra,0)}}</td>
                                                <td>{{number_format($comProd->precio_compra,2)}}</td>
                                                <td>{{number_format($comProd->precio_compra_total,2)}}</td>
                                                <td>{{number_format($comProd->cantidad_venta,0)}}</td>
                                                <td>{{number_format($comProd->precio_venta,2)}}</td>
                                                <td>{{number_format($comProd->precio_venta_total,2)}}</td>
                                                    @php($cant_saldo = $cant_saldo + ($comProd->cantidad_compra-$comProd->cantidad_venta))
                                                    @php($saldo_total = $saldo_total + ($comProd->precio_compra/1000)*($comProd->cantidad_compra-$comProd->cantidad_venta))
                                                <td>{{number_format($comProd->cantidad_compra-$comProd->cantidad_venta,0)}}</td>
                                                <td>{{number_format(($comProd->precio_compra/1000)*($comProd->cantidad_compra-$comProd->cantidad_venta),2)}}</td>
                                                @if($nf==1)
                                                    <td rowspan="{{$filas}}">
                                                        {{ $item->lugar_venta }} <br>
                                                        {{ $item->cliente }} ({{ $item->cliente_celular }}) <br>
                                                    </td>
                                                    <td rowspan="{{$filas}}">{{ $item->transporte }}</td>
                                                    <td rowspan="{{$filas}}">
                                                        @if($item->refresco != 0)
                                                            Refresco:{{ number_format($item->refresco,0) }} <br>
                                                        @endif
                                                        @if($item->peaje != 0)
                                                            Peaje:{{ number_format($item->peaje,0) }} <br>
                                                        @endif
                                                        @if($item->viatico != 0)
                                                            Viatico:{{ number_format($item->viatico,0) }} <br>
                                                        @endif
                                                        @if($item->corte_mitad != 0)
                                                            Mitades:{{ number_format($item->corte_mitad,0) }} <br>
                                                        @endif
                                                    </td>
                                                    <td rowspan="{{$filas}}">{{ $item->personal->nombres }} {{ $item->personal->apellido_1 }} {{ $item->personal->apellido_1 }}</td>
                                                @endif
                                            </tr>
                                        @empty
                                            Sin productos
                                        @endforelse
                                        {{-- <tr>
                                            <td rowspan="{{$filas}}">{{ $item->vuelta }}</td>
                                            <td rowspan="{{$filas}}">{{date('d/m/Y',strtotime($item->fecha))}}</td>
                                            <td>
                                                @forelse ($item->comercioProductos as $comProd)
                                                    **{{$comProd->producto->descripcion}}<br>
                                                @empty
                                                    Sin productos
                                                @endforelse
                                            </td>
                                            <td>
                                                @forelse ($item->comercioProductos as $comProd)
                                                    **({{number_format($comProd->cantidad_compra,0)}}x{{number_format($comProd->precio_compra,2)}}_Bs) ={{number_format($comProd->precio_compra_total,2)}}_Bs<br>
                                                @empty
                                                    0_Bs
                                                @endforelse
                                            </td>
                                            <td>
                                                @forelse ($item->comercioProductos as $comProd)
                                                    **({{number_format($comProd->cantidad_venta,0)}}x{{number_format($comProd->precio_venta,2)}}_Bs) ={{number_format($comProd->precio_venta_total,2)}}_Bs<br>
                                                @empty
                                                    0_Bs
                                                @endforelse
                                            </td>
                                            <td>{{ number_format($item->transporte,2) }}</td>
                                            <td>
                                                {{ $item->lugar_venta }}
                                                {{- <br>{{ $item->personal->nombres }} {{ $item->personal->apellido_1 }} {{ $item->personal->apellido_2 }} -}}
                                            </td>
                                            <td>
                                                -
                                            </td>
                                        </tr> --}}
                                    @empty
                                    <tr>
                                        <td colspan="9">sin registros de comercialización</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="3"></td>
                                        <td><b>{{ number_format($cant_compra, 2) }}</b></td>
                                        <td>-</td>
                                        <td><b>{{ number_format($compra_total, 2) }}</b></td>
                                        <td><b>{{ number_format($cant_venta, 2) }}</b></td>
                                        <td>-</td>
                                        <td><b>{{ number_format($venta_total, 2) }}</b></td>
                                        <td><b>{{ number_format($cant_saldo, 2) }}</b></td>
                                        <td><b>{{ number_format($saldo_total, 2) }}</b></td>
                                        <td>-</td>
                                        <td><b>{{ number_format($transporte, 2) }}</b></td>
                                        <td>-</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row">
                {{-- Estado combustible --}}
                <div class="col-md-6">
                    <div class="table-responsive">
                        <table class="table table-bordered table-head-bg-warning table-bordered-bd-warning mt-4 table-hover">
                            <thead>
                                <tr>
                                    <th colspan="6" scope="col" class="text-center">COMPRA DE COMBUSTIBLE (Diesel)</th>
                                </tr>
                                <tr>
                                    <th scope="col">Nro.</th>
                                    <th scope="col">Vehículo</th>
                                    <th scope="col">Fecha</th>
                                    <th scope="col">Precio lt</th>
                                    <th scope="col">Costo</th>
                                    <th scope="col">Litros</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php($costo=0)
                                @php($volumen=0)
                                @php($nro=0)
                                @forelse ($combustible as $item)
                                    @php($costo += $item->costo)
                                    @php($volumen += $item->volumen)
                                    @php($nro++)
                                    <tr>
                                        <td>{{ $nro }}.-</td>
                                        <td>{{ $item->vehiculo->marca }} ({{ $item->vehiculo->placa }})</td>
                                        <td>{{date('d/m/Y',strtotime($item->fecha))}}</td>
                                        <td>
                                            {{ number_format($item->precio_unitario, 2) }}
                                        </td>
                                        <td>
                                            {{ number_format($item->costo, 2) }}
                                        </td>
                                        <td>
                                            {{ number_format($item->volumen, 2) }}
                                        </td>
                                    </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center">Sin registros de carga de combustible..!!</td>
                                </tr>
                                @endforelse
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="4"></td>
                                    <td>
                                        {{ number_format($costo, 2) }}
                                    </td>
                                    <td>
                                        {{ number_format($volumen, 2) }}
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                {{-- Estado Final --}}
                <div class="col-md-6">
                    <div class="table-responsive">
                        <table class="table table-bordered table-head-bg-secondary table-bordered-bd-secondary mt-4 table-hover">
                            <thead>
                                <tr>
                                    <th colspan="5" scope="col" class="text-center">ESTADO FINAL</th>
                                </tr>
                                <tr>
                                    <th scope="col">Nro.</th>
                                    <th scope="col">Detalle</th>
                                    <th scope="col">Cantidad</th>
                                    <th scope="col">Monto Total</th>
                                    <th scope="col"> </th>
                                </tr>
                            </thead>
                            @php($fila=1)
                            <tbody>
                                <tr>
                                    <td>{{$fila++}}.-</td>
                                    <td>Compras</td>
                                    <td>{{ number_format($cant_compra, 0) }} unidades</td>
                                    <td>{{ number_format($compra_total, 2) }}</td>
                                    <td>-</td>
                                </tr>
                                <tr>
                                    <td>{{$fila++}}.-</td>
                                    <td>Ventas</td>
                                    <td>{{ number_format($cant_venta, 0) }} unidades</td>
                                    <td>{{ number_format($venta_total, 2) }}</td>
                                    <td>{{ number_format($venta_total-$compra_total, 2) }}</td>
                                </tr>
                                <tr>
                                    <td>{{$fila++}}.-</td>
                                    <td>Saldo</td>
                                    <td>{{ number_format($cant_compra-$cant_venta, 0) }} unidades</td>
                                    <td>{{ number_format(0, 2) }}</td>
                                    <td>-</td>
                                </tr>
                                <tr>
                                    <td>{{$fila++}}.-</td>
                                    <td>Transporte</td>
                                    <td>{{ number_format(count($vueltas), 0) }} vueltas</td>
                                    <td>{{ number_format($transporte, 2) }}</td>
                                    <td>-</td>
                                </tr>
                                <tr>
                                    <td>{{$fila++}}.-</td>
                                    <td>Costo combustible</td>
                                    <td>{{ number_format(count($vueltas), 0) }} vueltas</td>
                                    <td>{{ number_format($costo_combustible, 2) }}</td>
                                    <td>-</td>
                                </tr>
                                <tr>
                                    <td>{{$fila++}}.-</td>
                                    <td>Refresco</td>
                                    <td>{{ number_format(count($vueltas), 0) }} vueltas</td>
                                    <td>{{ number_format($refresco, 2) }}</td>
                                    <td>-</td>
                                </tr>
                                <tr>
                                    <td>{{$fila++}}.-</td>
                                    <td>Peaje</td>
                                    <td>{{ number_format(count($vueltas), 0) }} vueltas</td>
                                    <td>{{ number_format($peaje, 2) }}</td>
                                    <td>-</td>
                                </tr>
                                <tr>
                                    <td>{{$fila++}}.-</td>
                                    <td>Chofer</td>
                                    <td>{{ number_format(count($vueltas), 0) }} vueltas + {{$viatico}} Bs</td>
                                    <td>{{ number_format((count($vueltas)*120)+$viatico, 2) }}</td>
                                    <td>-</td>
                                </tr>
                                <tr>
                                    <td>{{$fila++}}.-</td>
                                    <td>Combustible</td>
                                    <td>{{ number_format(count($combustible), 0) }} facturas</td>
                                    <td>{{ number_format($costo, 2) }}</td>
                                    <td>{{ number_format($costo-$costo_combustible, 2)}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('javascripts')
    <script>
        document.getElementById('mReporteSemanal').classList.add('active');
        //---Validacion del formulario
        (function () {
            'use strict'
            var forms = document.querySelectorAll('.needs-validation')
            Array.prototype.slice.call(forms)
                .forEach(function (form) {
                    form.addEventListener('submit', function (event) {
                        if (!form.checkValidity()) {
                            event.preventDefault()
                            event.stopPropagation()
                        }
                        form.classList.add('was-validated')
                    }, false)
                })
        })()

        function semana()
        {
            var f = $('#fecha_comercio').val();
            alert(f);
            const redirect1 = () => location.href = 'https://pablomonteserin.com';
        }

        function tieneCombustible(id_vehiculo)
        {
            $('#combustible').html('Buscando');
            $('#combustible_id').val('');
            var id_vehiculo = $("#vehiculo_id").val();
            $.ajax({
                url : "{{route('comercio.operacion.combustible')}}",
                data : { 'id_vehiculo':id_vehiculo, 'fecha_comercio':$('#fecha_comercio').val(), "_token": "{{ csrf_token() }}", },
                type : 'POST',
                dataType : 'json',
                success : function(resp) {
                    if(resp.estado == true){
                        $('#combustible').html(resp.mensaje);
                        $('#combustible_id').val(resp.combustible);
                    }else{
                        $('#combustible').html(resp.mensaje);
                        swal("Advertencia", resp.alerta, {
                            buttons: {
                                confirm: {
                                    className: "btn btn-primary",
                                },
                            },
                        });
                    }
                },
                error : function(xhr, status) {
                    $('#estadoFirmador').html('<span class="badge badge-phoenix badge-phoenix-warning">El firmador no esta activo en su equipo.</span>');
                }
            });
        }

        //--verificar combustible antes de guardar
        $('.form-nuevo-comercio').submit(function(e){
            e.preventDefault();
            var id_combustible = $("#combustible_id").val();
            if(id_combustible == ''){
                swal("Advertencia", "El vehículo elegido no tiene combustible cargado", {
                    icon: "error",
                    buttons: {
                        confirm: {
                            className: "btn btn-danger",
                        },
                    },
                });
            }else{
                this.submit();
            }
        });
    </script>

    @if(session('estadoComercio'))
        <script>
            swal("{{session('estadoComercio')}}", {
                buttons: {
                    confirm: {
                        className: "btn btn-success",
                    },
                },
            });
        </script>
    @endif
@endsection