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
                    <button type="button" class="btn btn-primary btn-round" data-bs-toggle="modal" data-bs-target="#modalNuevaProforma">
                        <span class="btn-label"><i class="fa fa-plus"></i></span>
                        Generar proforma
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
                                        <th scope="col">Nro</th>
                                        <th scope="col">Estado</th>
                                        <th scope="col">Fecha</th>
                                        <th scope="col">Cliente</th>
                                        <th scope="col">Producto</th>
                                        <th scope="col">Total</th>
                                        <th scope="col">-</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($proformas as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>
                                            @if(!count($item->comercios))
                                                <span class="badge badge-danger">Sin Vender</span>
                                            @else
                                                <span class="badge badge-success">Vendido</span>
                                            @endif
                                            {{-- count($item->comercios) --}}
                                        </td>
                                        <td>{{ date('d/m/Y',strtotime($item->fecha_registro)) }}</td>
                                        <td>{{ $item->cliente_nombre }} (CI: {{ $item->cliente_ci }})</td>
                                        <td>
                                            @php($total=0)
                                            @forelse ($item->productos as $itemProd)
                                                @php($total = $total + $itemProd->precio_total)
                                                {{ number_format($itemProd->cantidad,0) }} {{ $itemProd->producto->descripcion }} => {{ number_format($itemProd->precio_total,2) }}_Bs.<br>
                                            @empty
                                                <label class="text-danger">Sin productos ...!!!</label>
                                            @endforelse
                                        </td>
                                        <td>
                                            {{ number_format($total, 0) }}_Bs.
                                        </td>
                                        <td>
                                            @if($total)
                                            <a href="{{ route('proforma.generar.pdf', ['id'=>$item->id]) }}" title="Imprimir proforma" target="_blank" class="btn btn-warning btn-round btn-icon" data-bs-toggle="tooltip" data-bs-placement="top" >
                                                <span class="btn-label"><i class="fa fa-print"></i></span>
                                            </a>
                                            @endif
                                            <a href="{{ route('proforma.generar', ['id'=>$item->id]) }}" title="Editar productos de la proforma" class="btn btn-success btn-round btn-icon" data-bs-toggle="tooltip" data-bs-placement="top" >
                                                <span class="btn-label"><i class="fa fa-pen"></i></span>
                                            </a>
                                            @if(!count($item->comercios))
                                            <a href="{{ route('proforma.generar', ['id'=>$item->id]) }}" title="Eliminar proforma" class="btn btn-danger btn-round btn-icon" data-bs-toggle="tooltip" data-bs-placement="top" >
                                                <span class="btn-label"><i class="fa fa-trash"></i></span>
                                            </a>
                                            @endif
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" align="center">Sin proformas ...!!!</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para nueva proforma-->
    <div class="modal fade" id="modalNuevaProforma" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Generar nueva proforma</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('proforma.guardar.cliente') }}" method="POST" class="row g-3 needs-validation" novalidate>
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="fecha_registro">Fecha</label>
                                    <input type="date" class="form-control" value="{{old('fecha_registro', date('d/m/Y'))}}" name="fecha_registro" id="fecha_registro" required>
                                    <div class="invalid-feedback">Ingrese fecha</div>
                                    @error('fecha_registro')
                                        <div style="color:red; font-size: 75%;">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="cliente_ci">C.I. del cliente:</label>
                                    <input type="text" class="form-control" value="{{old('cliente_ci', 0)}}" name="cliente_ci" id="cliente_ci" placeholder="..."/>
                                    @error('cliente_ci')
                                        <div style="color:red; font-size: 75%;">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="cliente_nombre">Nombre del cliente:</label>
                                    <input type="text" class="form-control" value="{{old('cliente_nombre')}}" name="cliente_nombre" id="cliente_nombre" placeholder="..." required/>
                                    <div class="invalid-feedback">Nombre del cliente es obligatorio</div>
                                    @error('cliente_nombre')
                                        <div style="color:red; font-size: 75%;">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 text-center">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn btn-success">Generar proforma</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    
                </div>
            </div>
        </div>
    </div>
  
@endsection
@section('javascripts')
    <script>
        document.getElementById('mProforma').classList.add('active');
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
    </script>

    @if(session('estadoProforma'))
        <script>
            swal("{{session('estadoProforma')}}", {
                buttons: {
                    confirm: {
                        className: "btn btn-success",
                    },
                },
            });
        </script>
    @endif
@endsection