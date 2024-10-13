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
                    <a href="{{ route('admin.vehiculos.nuevo') }}" class="btn btn-primary">
                        <span class="btn-label"><i class="fa fa-plus"></i></span>
                        Adicionar
                    </a>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        @forelse ($vehiculos as $item)
                            <div class="col-sm-4">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <h5><b>{{ $item->marca }}</b></h5>
                                                <p class="text-muted">Total: {{ $item->total_costo }}Bs. {{ $item->total_fac==1? '1 fact.':$item->total_fac.' facts.' }}</p>
                                            </div>
                                            <h6 class="text-info fw-bold">{{ $item->placa }}</h6>
                                        </div>
                                        <div class="progress progress-sm">
                                            <div class="progress-bar bg-info w-25" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <div class="d-flex justify-content-between mt-2">
                                            <p class="text-muted mb-0">Diesel cargado: {{$item->total_volumen}} lt.</p>
                                            <p class="text-muted mb-0">hay: {{$item->disponibilidad}} lt.</p>
                                        </div>
                                        <div>
                                            <a href="{{ route('admin.vehiculos.combustible', ['vehiculo'=>$item]) }}" class="btn btn-success">+ Combustible</a>
                                            <a href="{{ route('admin.vehiculos.combustible', ['vehiculo'=>$item]) }}" class="btn btn-secondary">Historial</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-sm-4">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <h5><b>Sin vehículos</b></h5>
                                                <p class="text-muted">Adiciones vehículos <a href="{{ route('admin.vehiculos.nuevo') }}" class="btn btn-primary"> + </a></p>
                                            </div>
                                            <h3 class="text-success fw-bold">0</h3>
                                        </div>
                                        <div class="progress progress-sm">
                                            <div class="progress-bar bg-success w-0" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <div class="d-flex justify-content-between mt-2">
                                            <p class="text-muted mb-0">Combustible</p>
                                            <p class="text-muted mb-0">0%</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('javascripts')
    <script>
        document.getElementById('mVehiculos').classList.add('active');

        $("#alert_demo_5").click(function (e) {
            swal({
              title: "Input Something",
              html: '<br><input class="form-control" placeholder="Input Something" id="input-field">',
              content: {
                element: "input",
                attributes: {
                  placeholder: "Input Something",
                  type: "text",
                  id: "input-field",
                  className: "form-control",
                },
              },
              buttons: {
                cancel: {
                  visible: true,
                  className: "btn btn-danger",
                },
                confirm: {
                  className: "btn btn-success",
                },
              },
            }).then(function () {
              swal("", "You entered : " + $("#input-field").val(), "success");
            });
          });
    </script>
@endsection