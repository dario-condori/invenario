@extends('admin._base')

@section('titulo')
    Vehículo Nuevo
@endsection

@section('contenido')
    <div class="container">
        <div class="page-inner">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">
                                Generar proforma
                            </div>
                        </div>
                        <div class="card-body mt-1">
                            <form action="{{ route('comercio.operacion.guardar') }}" method="POST" class="row g-3 needs-validation" novalidate="">
                                @csrf
                                <div class="row">
                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-secondary btn-round" data-bs-toggle="modal" data-bs-target="#modalProducto">
                                            <span class="btn-label"><i class="fa fa-plus"></i></span>
                                            Producto
                                        </button>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="fecha_registro">Fecha: <b>{{ date('d/m/Y',strtotime($proforma->fecha_registro)) }}</b></label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="cliente_nombre">Cliente: <b>{{ strtoupper($proforma->cliente_nombre) }} (C.I.: <b>{{ $proforma->cliente_ci }})</b></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-head-bg-secondary table-bordered-bd-secondary mt-4 table-hover">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Nro</th>
                                                    <th scope="col">Producto</th>
                                                    <th scope="col">Cantidad</th>
                                                    <th scope="col">Precio unitario</th>
                                                    <th scope="col">Total</th>
                                                    <th scope="col">Acciones</th>
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
                                                    <td>{{ $i }}</td>
                                                    <td>{{ $item->producto->descripcion }} ({{ $item->producto->sigla }})</td>
                                                    <td>{{ number_format($item->cantidad,0) }}</td>
                                                    <td>{{ number_format($item->precio_unitario,2) }}</td>
                                                    <td class="text-right">{{ number_format($item->precio_total,2) }}</td>
                                                    <td>
                                                        <a href="{{ route('proforma.generar', ['id'=>$item->id]) }}" class="btn btn-success btn-round">
                                                            <span class="btn-label"><i class="fa fa-pen"></i></span>
                                                        </a>
                                                        <a href="{{ route('proforma.generar', ['id'=>$item->id]) }}" class="btn btn-danger btn-round">
                                                            <span class="btn-label"><i class="fa fa-trash"></i></span>
                                                        </a>
                                                    </td>
                                                </tr>
                                                @empty
                                                <tr>
                                                    <td colspan="6" align="center">
                                                        <span class="badge badge-danger">Sin productos ...!!!</span>
                                                    </td>
                                                </tr>
                                                @endforelse
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td>{{ number_format($cantidad_total,0) }}</td>
                                                    <td></td>
                                                    <td>{{ number_format($precio_total,2) }}</td>
                                                    <td></td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="card-action">
                                <a href="{{ route('proforma.generar.pdf', ['id'=>$proforma->id]) }}" title="Imprimir proforma en pdf" target="_blank" class="btn btn-warning" data-bs-toggle="tooltip" data-bs-placement="top" >
                                    <span class="btn-label"><i class="fa fa-print"></i></span>
                                    Imprimir proforma
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- modal para nuevo producto --}}
    <div class="modal fade" id="modalProducto" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Adicionar producto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('proforma.guardar.producto') }}" method="POST" class="row g-3 needs-validation" novalidate>
                        @csrf
                        <input type="hidden" name="proforma_id" value="{{ $proforma->id }}">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="cliente_nombre">Producto:</label>
                                    <select class="form-select form-control" name="producto_id" id="producto_id">
                                        @forelse ($productos as $item)
                                            <option value="{{ $item->id }}">{{ $item->descripcion }} ({{ $item->sigla }})</option>
                                        @empty
                                        <option>-- Error --</option>
                                        @endforelse
                                    </select>
                                    @error('producto_id')
                                        <div style="color:red; font-size: 75%;">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="cantidad">Cantidad:</label>
                                    <input onchange="calculoTotal();" type="number" class="form-control" value="{{old('cantidad')}}" name="cantidad" id="cantidad" required>
                                    <div class="invalid-feedback">Cantidad es obligatorio</div>
                                    @error('cantidad')
                                        <div style="color:red; font-size: 75%;">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="precio_unitario">Precio unitario:</label>
                                    <input onchange="calculoTotal();" type="text" class="form-control" value="{{old('precio_unitario')}}" name="precio_unitario" id="precio_unitario" placeholder="..." required/>
                                    <div class="invalid-feedback">Precio unitario es obligatorio</div>
                                    @error('precio_unitario')
                                        <div style="color:red; font-size: 75%;">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="precio_total">Total:</label>
                                    <input type="text" class="form-control" value="{{old('precio_total')}}" name="precio_total" id="precio_total" placeholder="..." required/>
                                    <div class="invalid-feedback">Total es obligatorio</div>
                                    @error('precio_total')
                                        <div style="color:red; font-size: 75%;">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 text-center">
                                <button type="submit" class="btn btn-success">Agregar producto</button>
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
        })();

        function calculoTotal(){
            var pu = document.getElementById('precio_unitario').value;
            var ca = document.getElementById('cantidad').value;
            var tot = (pu/1000)*ca;
            document.getElementById('precio_total').value=tot;
        }
    </script>
@endsection