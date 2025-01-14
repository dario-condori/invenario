@extends('admin._base')

@section('titulo')
    Comercio
@endsection

@section('contenido')
    <div class="container">
        <div class="page-inner">
            <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
                <div>
                    <h3 class="fw-bold mb-3">
                        Comercialización, desde {{date('d/m/Y',strtotime($primerDia))}} a {{date('d/m/Y',strtotime($ultimoDia))}}
                        <a href="{{route('comercio.listado',['fecha_comercio'=>date('Y-m-d', strtotime($fanterior))])}}" class="btn btn-secondary btn-sm" >
                            <span class="btn-label"><i class="fas fa-angle-double-left"></i></span>
                            Anterior semana
                        </a>
                        <a href="{{route('comercio.listado',['fecha_comercio'=>date('Y-m-d', strtotime($fsiguiente))])}}" class="btn btn-secondary btn-sm">
                            <span class="btn-label"><i class="fas fa-angle-double-right"></i></span>
                            Siguiente semana
                        </a>
                    </h3>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalNuevoComercio">
                        <span class="btn-label"><i class="fa fa-plus"></i></span>
                        Adicionar vuelta
                    </button>

                    <input type="hidden" name="fecha_comercio" id="fecha_comercio" value="{{$fecha_comercio}}">

                    <a href="{{ route('comercio.reporte.semanal',['fecha_comercio'=>date('Y-m-d', strtotime($fecha_comercio))]) }}" target="_blank" class="btn btn-warning">
                        <span class="btn-label"><i class="fa fa-print"></i></span>
                        Reporte
                    </a>
                    {{-- <a href="{{ route('comercio.operacion.pdf',['fecha_comercio'=>date('Y-m-d', strtotime($fecha_comercio))]) }}" target="_blank" class="btn btn-warning">
                        <span class="btn-label"><i class="fa fa-print"></i></span>
                        Imprimir
                    </a> --}}
                    <button class="btn btn-default">
                        <span class="btn-label"><i class="fa fa-truck"></i></span>
                        @if($combustible)
                            Diesel: {{ number_format($combustible->costo,1) }}_Bs. ({{ $combustible->volumen }}_lt) cargado el: {{ date('d/m/Y', strtotime($combustible->fecha))}}
                        @else
                            Diesel: {{ number_format(0,1) }}_Bs. ({{ 0 }}_lt)
                        @endif
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
                                        <th scope="col">Transporte</th>
                                        <th scope="col">Gastos</th>
                                        <th scope="col">Lugar</th>
                                        <th scope="col">Observacion</th>
                                        <th scope="col">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php($compra=0)
                                    @php($venta=0)
                                    @php($saldo=0)
                                    @php($transporte=0)
                                    @php($nro=0)
                                    @forelse ($vueltas as $item)
                                        @php($compra = $compra + ($item->precio_compra / 1000) * $item->cantidad_compra)
                                        @php($venta = $venta + ($item->precio_venta / 1000) * $item->cantidad_venta)
                                        @php($saldo = $saldo + ($item->precio_saldo / 1000))
                                        @php($transporte = $transporte + $item->transporte)
                                        @php($nro++)
                                        <tr>
                                            <td>{{ $item->vuelta }}</td>
                                            <td>{{date('d/m/Y',strtotime($item->fecha))}}</td>
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
                                                Refresco:{{ number_format($item->refresco,0) }} <br>
                                                Peaje:{{ number_format($item->peaje,0) }} <br>
                                                Viatico:{{ number_format($item->viatico,0) }} <br>
                                                Mitades:{{ number_format($item->corte_mitad,0) }} <br>
                                            </td>
                                            <td>
                                                {{ $item->lugar_venta }}
                                                <br>{{ $item->cliente }} ({{ $item->cliente_celular }})
                                            </td>
                                            <td>
                                                {{ $item->observacion }}
                                            </td>
                                            <td>
                                                <a href="{{ route('proforma.generar.pdf', ['id'=>$item->id]) }}" title="Imprimir proforma" target="_blank" class="btn btn-warning btn-round btn-icon" data-bs-toggle="tooltip" data-bs-placement="top" >
                                                    <span class="btn-label"><i class="fa fa-print"></i></span>
                                                </a>
                                                <a href="{{ route('comercio.operacion.productos',['comercio'=>$item]) }}" title="Editar registro" class="btn btn-success btn-round btn-icon" data-bs-toggle="tooltip" data-bs-placement="top" >
                                                    <span class="btn-label"><i class="fa fa-pen"></i></span>
                                                </a>
                                                <form action="{{ route('comercio.operacion.eliminar') }}" method="POST" title="Eliminar vuelta" data-bs-toggle="tooltip" data-bs-placement="top" style="display: inline" class="form-eliminar-vuelta">
                                                    @csrf
                                                    @method('DELETE')
                                                    <input type="hidden" name="comercio_id" value="{{$item->id}}">
                                                    <input type="hidden" name="fecha_comercio" id="fecha_comercio" value="{{$fecha_comercio}}">
                                                    <button class="btn btn-danger btn-round btn-icon" type="submit">
                                                        <span class="btn-label"><i class="fa fa-trash"></i></span>
                                                    </button>
                                                </form>
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

    <!-- Modal para nuevo comercio-->
    <div class="modal fade" id="modalNuevoComercio" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                        <h5 class="modal-title inline" id="exampleModalLabel">Registrar nueva vuelta</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('comercio.operacion.guardar') }}" method="POST" class="row g-3 needs-validation form-nuevo-comercio" novalidate>
                        @csrf
                        <div class="row">
                            <div class="col-sm-12 col-md-5 p-0">
                                <div class="form-group">
                                    <label for="cliente">Nombre cliente</label>
                                    <input type="text" class="form-control" value="{{old('cliente')}}" name="cliente" id="cliente" placeholder="..." required>
                                    <div class="invalid-feedback">Ingrese fecha</div>
                                    @error('cliente')
                                        <div style="color:red; font-size: 75%;">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-3 p-0">
                                <div class="form-group">
                                    <label for="cliente_celular">Celular</label>
                                    <input type="text" class="form-control" value="{{old('cliente_celular')}}" name="cliente_celular" id="cliente_celular" placeholder="..." required>
                                    <div class="invalid-feedback">Ingrese fecha</div>
                                    @error('cliente_celular')
                                        <div style="color:red; font-size: 75%;">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-4 p-0">
                                <div class="form-group">
                                    <label for="proforma_id">Proforma:</label>
                                    <select class="form-select form-control" name="proforma_id" id="proforma_id" required>
                                        <option value=""> --Seleccionar-- </option>
                                        <option value="0"> Sin proforma </option>
                                        @foreach ($proformasLibres as $item)
                                            <option value="{{ $item->id }}">No.{{ $item->id }} - {{ date('d/m/Y', strtotime($item->fecha_registro)) }} {{ $item->cliente_nombre }}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">Selecciones proforma</div>
                                    @error('proforma_id')
                                        <div style="color:red; font-size: 75%;">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 col-md-2 p-0">
                                <div class="form-group">
                                    <label for="vuelta">Vuelta</label>
                                    <input type="text" class="form-control" value="{{old('vuelta', $nro+1)}}" name="vuelta" id="vuelta" required>
                                    <div class="invalid-feedback">Ingrese fecha</div>
                                    @error('vuelta')
                                        <div style="color:red; font-size: 75%;">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-4 p-0">
                                <div class="form-group">
                                    <label for="fecha">Fecha</label>
                                    <input type="date" class="form-control" value="{{old('fecha', date('d/m/Y'))}}" name="fecha" id="fecha" required>
                                    <div class="invalid-feedback">Ingrese fecha</div>
                                    @error('fecha')
                                        <div style="color:red; font-size: 75%;">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-3 p-0">
                                <div class="form-group">
                                    <label for="transporte">Costo transporte:</label>
                                    <input type="text" class="form-control" value="{{old('transporte')}}" name="transporte" id="transporte" placeholder="..." required/>
                                    <div class="invalid-feedback">Nombre del cliente es obligatorio</div>
                                    @error('transporte')
                                        <div style="color:red; font-size: 75%;">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-3 p-0">
                                <div class="form-group">
                                    <label for="costo_combustible">Combustible:</label>
                                    <input type="text" class="form-control" value="{{old('costo_combustible', 50)}}" name="costo_combustible" id="costo_combustible" placeholder="corte"/>
                                    @error('costo_combustible')
                                        <div style="color:red; font-size: 75%;">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 col-md-5 p-0">
                                <div class="form-group">
                                    <label for="lugar_venta">Lugar de entrega:</label>
                                    <input type="text" class="form-control" value="{{old('lugar_venta')}}" name="lugar_venta" id="lugar_venta" placeholder="..." required/>
                                    <div class="invalid-feedback">Nombre del cliente es obligatorio</div>
                                    @error('lugar_venta')
                                        <div style="color:red; font-size: 75%;">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-4 p-0">
                                <div class="form-group">
                                    <label for="vehiculo_id">Vehiculo:</label>
                                    <select class="form-select form-control" onchange="tieneCombustible();" name="vehiculo_id" id="vehiculo_id" required>
                                        <option value=""> -- elija -- </option>
                                        @forelse ($vehiculos as $item)
                                            <option value="{{ $item->id }}">{{ $item->marca }} {{ $item->placa }}</option>
                                        @empty
                                            <option>-- Error --</option>
                                        @endforelse
                                    </select>
                                    @error('vehiculo_id')
                                        <div style="color:red; font-size: 75%;">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-3 p-0">
                                <div class="form-group">
                                    <label for="combustible">Estado Diesel</label>
                                    <p id="combustible"> ...elija vehiculo.. </p>
                                    <input type="hidden" value="" name="combustible_id" id="combustible_id" required/>
                                    @error('combustible_id')
                                        <div style="color:red; font-size: 75%;">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 col-md-5 p-0">
                                <div class="form-group">
                                    <label for="personal_id">Vendedor:</label>
                                    <select class="form-select form-control" name="personal_id" id="personal_id" required>
                                        <option value=""> -- elija -- </option>
                                        @forelse ($personal as $item)
                                            <option value="{{ $item->id }}">{{ $item->nombres }} {{ $item->apellido_1 }} {{ $item->apellido_2 }}</option>
                                        @empty
                                        <option>-- Error --</option>
                                        @endforelse
                                    </select>
                                    <div class="invalid-feedback">El cliente es obligatorio</div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-7 p-0">
                                <div class="form-group">
                                    <label for="observacion">Observación:</label>
                                    <input type="text" class="form-control" value="{{old('observacion')}}" name="observacion" id="observacion" placeholder="..."/>
                                    <div class="invalid-feedback">Nombre del cliente es obligatorio</div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 col-md-3 p-0">
                                <div class="form-group">
                                    <label for="refresco">Refresco:</label>
                                    <input type="text" class="form-control" value="{{old('refresco', 10)}}" name="refresco" id="refresco" placeholder="..." required/>
                                    <div class="invalid-feedback">costo del refresco es obligatorio</div>
                                    @error('refresco')
                                        <div style="color:red; font-size: 75%;">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-3 p-0">
                                <div class="form-group">
                                    <label for="peaje">Peaje:</label>
                                    <input type="text" class="form-control" value="{{old('peaje', 0)}}" name="peaje" id="peaje" placeholder="..." required/>
                                    <div class="invalid-feedback">Costo del peaje es obligatorio</div>
                                    @error('peaje')
                                        <div style="color:red; font-size: 75%;">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-3 p-0">
                                <div class="form-group">
                                    <label for="viatico">Viático:</label>
                                    <input type="text" class="form-control" value="{{old('viatico', 0)}}" name="viatico" id="viatico" placeholder="viatico"/>
                                    @error('viatico')
                                        <div style="color:red; font-size: 75%;">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-3 p-0">
                                <div class="form-group">
                                    <label for="corte_mitad">Corte a mitad:</label>
                                    <input type="text" class="form-control" value="{{old('corte_mitad', 0)}}" name="corte_mitad" id="corte_mitad" placeholder="corte"/>
                                    @error('corte_mitad')
                                        <div style="color:red; font-size: 75%;">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn btn-success">Guardar registro</button>
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
        document.getElementById('mComercializacion').classList.add('active');
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

        $('.form-eliminar-vuelta').submit(function(e){
            e.preventDefault();
            swal({
                title: "Advertencia !!",
                text: "Esta seguro de eliminar el registro de esta vuelta ?",
                type: "warning",
                buttons: {
                    cancel: {
                        visible: true,
                        text: "Cancelar",
                        className: "btn btn-info",
                    },
                    confirm: {
                        text: "Si, eliminar",
                        className: "btn btn-danger",
                    },
                },
            }).then((Delete) => {
                if (Delete) {
                    this.submit();
                } else {
                    swal.close();
                }
            });

        });

        function tieneCombustible(id_vehiculo)
        {
            $('#combustible').html('...');
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
                    alert('Error al recuperar estado del combustible');
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