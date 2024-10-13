@extends('admin._base')

@section('titulo')
    Vehículos
@endsection

@section('contenido')
    <div class="container">
        <div class="page-inner">
            <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
                <div>
                    <h3 class="fw-bold mb-3">Administración de vehículos, desde {{date('d/m/Y',strtotime($primerDia))}} a {{date('d/m/Y',strtotime($ultimoDia))}}</h3>
                    <a href="{{ route('comercio.seleccionarVehiculo') }}" class="btn btn-primary">
                        <span class="btn-label"><i class="fa fa-plus"></i></span>
                        Adicionar vuelta
                    </a>
                    <a href="{{ route('comercio.seleccionarVehiculo') }}" class="btn btn-warning">
                        <span class="btn-label"><i class="fa fa-print"></i></span>
                        Imprimir
                    </a>
                    <button class="btn btn-default">
                        <span class="btn-label"><i class="fa fa-truck"></i></span>
                        Diesel: {{ number_format($combustible->costo,1) }}_Bs. ({{ $combustible->volumen }}_lt)
                    </button>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="table-responsive">
                            <table class="table table-bordered table-head-bg-info table-bordered-bd-info mt-4 table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">Vuelta</th>
                                        <th scope="col">Fecha</th>
                                        <th scope="col">Producto</th>
                                        <th scope="col">Compra</th>
                                        <th scope="col">Venta</th>
                                        <th scope="col">Saldo</th>
                                        <th scope="col">Transporte</th>
                                        <th scope="col">Lugar</th>
                                        <th scope="col">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php($compra=0)
                                    @php($venta=0)
                                    @php($saldo=0)
                                    @php($transporte=0)
                                    @forelse ($vueltas as $item)
                                    @php($compra = $compra + ($item->precio_compra / 1000) * $item->cantidad_compra)
                                    @php($venta = $venta + ($item->precio_venta / 1000) * $item->cantidad_venta)
                                    @php($saldo = $saldo + ($item->precio_saldo / 1000))
                                    @php($transporte = $transporte + $item->transporte)
                                    <tr>
                                        <td>{{ $item->vuelta }}</td>
                                        <td>{{date('d/m/Y',strtotime($item->fecha))}}</td>
                                        <td>{{ $item->producto->descripcion }}</td>
                                        <td>
                                            {{ number_format($item->cantidad_compra, 0) }}_Unid.<br>
                                            {{ number_format($item->precio_compra, 0) }}_Bs.<br>
                                            ={{ number_format(($item->precio_compra / 1000) * $item->cantidad_compra) }}_Bs.
                                        </td>
                                        <td>
                                            {{ number_format($item->cantidad_venta, 0) }}_Unid.<br>
                                            {{ number_format($item->precio_venta, 0) }}_Bs.<br>
                                            ={{ number_format(($item->precio_venta / 1000) * $item->cantidad_venta) }}_Bs.
                                        </td>
                                        <td>
                                            {{ number_format($item->cantidad_saldo, 0) }}_Unid.<br>
                                            {{ number_format($item->precio_saldo, 0) }}_Bs.
                                        </td>
                                        <td>{{ number_format($item->transporte,2) }}</td>
                                        <td>
                                            {{ $item->lugar_venta }}
                                            {{-- <br>{{ $item->personal->nombres }} {{ $item->personal->apellido_1 }} {{ $item->personal->apellido_2 }} --}}
                                        </td>
                                        <td>
                                            {{-- @if($total) --}}
                                            <a href="{{ route('proforma.generar.pdf', ['id'=>$item->id]) }}" title="Imprimir proforma" target="_blank" class="btn btn-warning btn-round btn-icon" data-bs-toggle="tooltip" data-bs-placement="top" >
                                                <span class="btn-label"><i class="fa fa-print"></i></span>
                                            </a>
                                            {{-- @endif --}}
                                            <a href="{{ route('proforma.generar', ['id'=>$item->id]) }}" title="Editar productos de la proforma" class="btn btn-success btn-round btn-icon" data-bs-toggle="tooltip" data-bs-placement="top" >
                                                <span class="btn-label"><i class="fa fa-pen"></i></span>
                                            </a>
                                            <a href="{{ route('proforma.generar', ['id'=>$item->id]) }}" title="Eliminar proforma" class="btn btn-danger btn-round btn-icon" data-bs-toggle="tooltip" data-bs-placement="top" >
                                                <span class="btn-label"><i class="fa fa-trash"></i></span>
                                            </a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="9">sin registros de comercialización</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="3"></td>
                                        <td>
                                            {{ number_format($compra, 2) }}
                                        </td>
                                        <td>
                                            {{ number_format($venta, 2) }}
                                        </td>
                                        <td>
                                            {{ number_format($saldo, 2) }}
                                        </td>
                                        <td>
                                            {{ number_format($transporte, 2) }}
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('javascripts')
    <script>
        document.getElementById('mComercializacion').classList.add('active');
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
        
            /*Swal.fire({
                title: "Alerta para solicitud !!",
                text: "{{session('estadoComercio')}}.",
                icon: "success",
                showConfirmButton: true,
                timer: 4500
            });*/
        </script>
    @endif
@endsection