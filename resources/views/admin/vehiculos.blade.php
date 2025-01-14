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
                <div class="col-md-4">
                    <div class="row">
                        @forelse ($vehiculos as $item)
                            <div class="col-sm-12">
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
                                            <p class="text-muted mb-0">hay: {{$item->disponibilidad}} Bs.</p>
                                        </div>
                                        <div class="d-flex justify-content-between mt-2">
                                            <p class="text-muted mb-0">Vueltas: {{$item->giros}} ({{$item->comb_gastado}} Bs.)</p>
                                            <p class="text-muted mb-0">Saldo: {{$item->disponibilidad}} lt.</p>
                                        </div>
                                        <div>
                                            <a href="{{ route('admin.vehiculos.combustible', ['vehiculo'=>$item]) }}" class="btn btn-success btn-sm">+ Combustible</a>
                                            <a onclick="recuperarHistorialCombustible({{ $item->id }});" href="#" class="btn btn-secondary btn-sm">Historial</a>
                                            <a onclick="datosVehiculo({{ $item->id }});" href="#" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalNuevoMantenimiento">Mantenimiento</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-sm-12">
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
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h5><b>Historial de combustible y mantenimiento</b></h5>
                                </div>
                                <h3 class="text-success fw-bold" id="vehiculo">placa</h3>
                            </div>
                            <div class="justify-content-between mt-2" id="tabla_historial">
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para nuevo comercio-->
    <div class="modal fade" id="modalNuevoMantenimiento" tabindex="-1" aria-labelledby="modalNuevoMantenimiento" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                        <h5 class="modal-title inline" id="info_vehiculo">Registrar mantenimiento</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.vehiculos.mantenimiento.guardar') }}" method="POST" class="row g-3 needs-validation form-nuevo-comercio" novalidate>
                        @csrf
                        <input type="hidden" name="vehiculo_id" id="vehiculo_id" value="0">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tipo_servicio_id">Tipo servicio:</label>
                                    <select class="form-select form-control" name="tipo_servicio_id" id="tipo_servicio_id" required>
                                        <option value=""> --Seleccionar-- </option>
                                        @foreach ($tipoMantenimiento as $item)
                                            <option value="{{ $item->id }}">{{ $item->descripcion }}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">Selecciones proforma</div>
                                    @error('tipo_servicio_id')
                                        <div style="color:red; font-size: 75%;">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="fecha">Fecha</label>
                                    <input type="date" class="form-control" value="{{old('fecha', date('d/m/Y'))}}" name="fecha" id="fecha" required>
                                    <div class="invalid-feedback">Ingrese fecha</div>
                                    @error('fecha')
                                        <div style="color:red; font-size: 75%;">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="costo_servicio">Costo del Servicio (Bs)</label>
                                    <input type="number" class="form-control" value="{{old('costo_servicio', 0)}}" name="costo_servicio" id="costo_servicio" onchange="totalMantenimiento();" placeholder="..." required/>
                                    <div class="invalid-feedback">Nombre del cliente es obligatorio</div>
                                    @error('costo_servicio')
                                        <div style="color:red; font-size: 75%;">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="costo_material">Costo del material (Bs)</label>
                                    <input type="text" class="form-control" value="{{old('costo_material')}}" name="costo_material" id="costo_material" onchange="totalMantenimiento();" placeholder="..." required/>
                                    <div class="invalid-feedback">Nombre del cliente es obligatorio</div>
                                    @error('costo_material')
                                        <div style="color:red; font-size: 75%;">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="costo_total">Costo total (Bs)</label>
                                    <input type="text" class="form-control" value="{{old('costo_total')}}" name="costo_total" id="costo_total" placeholder="..." required/>
                                    <div class="invalid-feedback">Nombre del cliente es obligatorio</div>
                                    @error('costo_total')
                                        <div style="color:red; font-size: 75%;">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        {{-- <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="observacion">Observación:</label>
                                    <input type="text" class="form-control" value="{{old('observacion')}}" name="observacion" id="observacion" placeholder="..."/>
                                    <div class="invalid-feedback">Nombre del cliente es obligatorio</div>
                                </div>
                            </div>
                        </div> --}}
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn btn-success">Guardar mantenimiento</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    {{-- @if($errors->any())
                        @foreach ($errors->all() as $item)
                            <li>{{ $item }}</li>
                        @endforeach
                    @endif --}}
                </div>
            </div>
        </div>
    </div>
@endsection
@section('javascripts')
    <script>
        document.getElementById('mVehiculos').classList.add('active');

        function recuperarHistorialCombustible(vehi){
            $.ajax({
                url : "{{route('admin.vehiculos.historial')}}",
                data : { 'vehiculo_id':vehi, 'fecha_comercio':"{{date('Y-m-d',strtotime($primerDia))}}", "_token": "{{ csrf_token() }}", },
                type : 'POST',
                dataType : 'json',
                success : function(resp) {
                    if(resp.estado == true){
                        $('#tabla_historial').html(resp.tabla_historial);
                        $('#vehiculo').html(resp.vehiculo);
                    }else{
                        swal("Advertencia", resp.mensaje, {
                            buttons: {
                                confirm: {
                                    className: "btn btn-primary",
                                },
                            },
                        });
                    }
                },
                error : function(xhr, status) {
                    alert('Error: del servidor.');
                }
            });
        }

        function datosVehiculo(vehi){
            $.ajax({
                url : "{{route('admin.vehiculos.datos')}}",
                data : { 'vehiculo_id':vehi, 'fecha_comercio':"{{date('Y-m-d',strtotime($primerDia))}}", "_token": "{{ csrf_token() }}", },
                type : 'POST',
                dataType : 'json',
                success : function(resp) {
                    if(resp.estado == true){
                        $('#info_vehiculo').html('Mantenimiento para: '+resp.vehiculo.marca + ' - ' + resp.vehiculo.placa);
                        $('#vehiculo_id').val(resp.vehiculo.id);
                    }else{
                        swal("Advertencia", resp.mensaje, {
                            buttons: {
                                confirm: {
                                    className: "btn btn-primary",
                                },
                            },
                        });
                    }
                },
                error : function(xhr, status) {
                    alert('Error: del servidor.');
                }
            });
        }

        function totalMantenimiento()
        {
            $('#costo_total').val($('#costo_servicio').val()*1 + $('#costo_material').val()*1);
        }

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