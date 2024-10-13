@extends('admin._base')

@section('titulo')
    Vehículos
@endsection

@section('contenido')
    <div class="container">
        <div class="page-inner">
            <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
                <div>
                    <h3 class="fw-bold mb-3">Administración de vehículos, {{date('d/m/Y',strtotime($hoy))}}</h3>
                    <a href="{{ route('comercio.seleccionarVehiculo') }}" class="btn btn-primary">
                        <span class="btn-label"><i class="fa fa-plus"></i></span>
                        Adicionar
                    </a>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        @forelse ($vehiculos as $item)
                            <div class="col-sm-6 col-lg-3">
                                <div class="card p-3">
                                    <div class="d-flex align-items-center">
                                        <a href="{{ route('comercio.operacion', ['vehiculo'=>$item->id]) }}">
                                            <span class="stamp stamp-md bg-secondary me-3">
                                                <i class="fas fa-truck-moving"></i>
                                            </span>
                                        </a>
                                        <div>
                                            <h5 class="mb-1">
                                            <b><a href="{{ route('comercio.operacion', ['vehiculo'=>$item->id]) }}">{{ $item->marca}} -<small>{{ $item->placa }}</small></a></b>
                                            </h5>
                                            <small class="text-muted">Diesel disponible: <b>{{ '30' }} lt.</b></small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <tr>
                                <td colspan="5">sin registros de comercialización</td>
                            </tr>
                        @endforelse
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
@endsection