@extends('admin._base')

@section('titulo')
    Nueva Vuelta
@endsection

@section('contenido')
    <div class="container">
        <div class="page-inner">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">
                                Registro de productos para la vuelta
                            </div>
                        </div>
                        <div class="card-body mt-1">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card card-info bg-info-gradient">
                                        <div class="card-body curves-shadow">
                                            <h1># {{ $comercio->vuelta }}</h1>
                                            <h3 class="py-0 mb-0">{{ $comercio->vehiculo->marca}} - {{ $comercio->vehiculo->placa}}</h3>
                                            <div class="row">
                                                <div class="col-8 pe-0">
                                                    <h3 class="fw-bold mb-1">Fecha: {{ date('d/m/Y', strtotime($comercio->fecha)) }}</h3>
                                                    <div class="text-small text-uppercase fw-bold op-8">
                                                        Lugar: {{ $comercio->lugar_venta }}
                                                    </div>
                                                </div>
                                                <div class="col-4 ps-0 text-end">
                                                    <h3 class="fw-bold mb-1">Proforma: {{ $comercio->proforma_id }}</h3>
                                                    <div class="text-small text-uppercase fw-bold op-8">
                                                        Personal: {{ $comercio->personal->nombres }} {{ $comercio->personal->apellido_1 }} {{ $comercio->personal->apellido_2 }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="cliente_nombre">Nombre cliente: <b>{{ strtoupper($comercio->proforma->cliente_nombre) }}</b></label>
                                        <label for="cliente_nombre"> / C.I.: <b>{{ $comercio->proforma->cliente_ci }}</b></label>
                                    </div>
                                    <button type="button" class="btn btn-info btn-round" data-bs-toggle="modal" data-bs-target="#modalProducto">
                                        <span class="btn-label"><i class="fa fa-plus"></i></span>
                                        Agregar Producto
                                    </button>
                                    <br><br>
                                    <a href="{{ route('proforma.generar.pdf', ['id'=>$comercio->proforma->id]) }}" target="_blank" class="btn btn-warning btn-round">
                                        <span class="btn-label"><i class="fa fa-print"></i></span>
                                        Imprimir proforma
                                    </a>
                                </div>
                            </div>
                            <div class="row">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-head-bg-info table-bordered-bd-info mt-4 table-hover">
                                        <thead>
                                            <tr>
                                                <th scope="col">Nro</th>
                                                <th scope="col">Producto</th>
                                                <th scope="col">Compra</th>
                                                <th scope="col">Venta</th>
                                                <th scope="col">Saldo</th>
                                                <th scope="col">Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php($cantidad_total=0)
                                            @php($precio_total_compra=0)
                                            @php($precio_total_venta=0)
                                            @php($i=0)
                                            @forelse ($productosComercio as $item)
                                                @php($cantidad_total = $cantidad_total + $item->cantidad)
                                                @php($precio_total_compra = $precio_total_compra + $item->precio_compra_total)
                                                @php($precio_total_venta = $precio_total_venta + $item->precio_venta_total)
                                                @php($i++)
                                            <tr>
                                                <td>{{ $i }}</td>
                                                <td>{{ $item->producto->descripcion }} ({{ $item->producto->sigla }})</td>
                                                <td>
                                                    Cant: {{ number_format($item->cantidad_compra,0) }} unid.<br>
                                                    Precio: {{ number_format($item->precio_compra,2) }} Bs.<br>
                                                    Total: {{ number_format($item->precio_compra_total,2) }} Bs.
                                                </td>
                                                <td>
                                                    Cant: {{ number_format($item->cantidad_venta,0) }} unid.<br>
                                                    Precio: {{ number_format($item->precio_venta,2) }} Bs.<br>
                                                    Total: {{ number_format($item->precio_venta_total,2) }} Bs.
                                                </td>
                                                <td class="text-right">
                                                    @forelse ($item->almacen as $alma)
                                                        Cant: {{ number_format($alma->cantidad,0) }}<br>
                                                        Precio: {{ number_format($alma->precio, 2) }}<br>
                                                        En: {{ $alma->tipoAlmacen->descripcion }}
                                                    @empty
                                                        -
                                                    @endforelse
                                                </td>
                                                <td>
                                                    <button onclick="recuperarProdCom({{$item->id}});" class="btn btn-success btn-round" data-bs-toggle="modal" data-bs-target="#modalProductoEditar">
                                                        <span class="btn-label"><i class="fa fa-pen"></i></span>
                                                    </button>
                                                    <form action="{{ route('comercio.operacion.producto.eliminar') }}" method="POST" style="display: inline" class="form-eliminar-producto">
                                                        @csrf
                                                        @method('DELETE')
                                                        <input type="hidden" name="comercio_productos_id" value="{{$item->id}}">
                                                        <button class="btn btn-danger btn-round" type="submit">
                                                            <span class="btn-label"><i class="fa fa-trash"></i></span>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="6" align="center">
                                                    <span class="badge badge-danger">No tiene productos registrados...!!!</span>
                                                </td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td>Total compra: {{ number_format($precio_total_compra,2) }} Bs.</td>
                                                <td>Total venta: {{ number_format($precio_total_venta,2) }} Bs.</td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="card-action">
                            {{-- <a href="{{ route('proforma.generar.pdf', ['id'=>$proforma->id]) }}" title="Imprimir proforma en pdf" target="_blank" class="btn btn-warning" data-bs-toggle="tooltip" data-bs-placement="top" >
                                <span class="btn-label"><i class="fa fa-print"></i></span>
                                Imprimir proforma
                            </a> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- modal para adicionar producto a vender --}}
    <div class="modal fade" id="modalProducto" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Producto a comercializar</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('comercio.operacion.producto.guardar') }}" method="POST" class="row g-3 needs-validation" novalidate>
                        @csrf
                        <input type="hidden" name="comercio_id" value="{{ $comercio->id }}">
                        <div class="row">{{-- producto --}}
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label for="tipo_origen">Origen:</label>
                                    <select class="form-select form-control" name="tipo_origen_id" id="tipo_origen_id" required>
                                        <option value="">-- Eligir --</option>
                                        @forelse ($tipoOrigen as $item)
                                            <option value="{{ $item->id }}">{{ $item->descripcion }}</option>
                                        @empty
                                            <option value="">-- Error --</option>
                                        @endforelse
                                    </select>
                                    @error('tipo_origen_id')
                                        <div style="color:red; font-size: 75%;">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-7">
                                <div class="form-group">
                                    <label for="cliente_nombre">Producto:</label>
                                    <select class="form-select form-control" name="producto_id" id="producto_id" required>
                                        <option value="">-- Eligir --</option>
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
                        <div class="row"> {{-- Compra --}}
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="cantidad_compra">Cantidad compra:</label>
                                    <input onchange="calculoTotal();" type="number" class="form-control" value="{{old('cantidad_compra')}}" name="cantidad_compra" id="cantidad_compra" required>
                                    <div class="invalid-feedback">Cantidad es obligatorio</div>
                                    @error('cantidad_compra')
                                        <div style="color:red; font-size: 75%;">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="precio_compra">Precio compra x 1000:</label>
                                    <input onchange="calculoTotal();" type="number" class="form-control" value="{{old('precio_compra')}}" name="precio_compra" id="precio_compra" placeholder="..." required/>
                                    <div class="invalid-feedback">Precio unitario es obligatorio</div>
                                    @error('precio_compra')
                                        <div style="color:red; font-size: 75%;">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="precio_compra_total">Precio compra Total:</label>
                                    <input type="text" class="form-control" value="{{old('precio_compra_total')}}" name="precio_compra_total" id="precio_compra_total" placeholder="..." required/>
                                    <div class="invalid-feedback">Total es obligatorio</div>
                                    @error('precio_compra_total')
                                        <div style="color:red; font-size: 75%;">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row"> {{-- Venta --}}
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="cantidad_venta">Cantidad venta:</label>
                                    <input onchange="calculoTotalVenta();" type="number" class="form-control" value="{{old('cantidad_venta')}}" name="cantidad_venta" id="cantidad_venta" required>
                                    <div class="invalid-feedback">Cantidad es obligatorio</div>
                                    @error('cantidad_venta')
                                        <div style="color:red; font-size: 75%;">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="precio_venta">Precio venta x 1000:</label>
                                    <input onchange="calculoTotalVenta();" type="number" class="form-control" value="{{old('precio_venta')}}" name="precio_venta" id="precio_venta" placeholder="..." required/>
                                    <div class="invalid-feedback">Precio unitario es obligatorio</div>
                                    @error('precio_venta')
                                        <div style="color:red; font-size: 75%;">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="precio_venta_total">Precio venta Total:</label>
                                    <input type="text" class="form-control" value="{{old('precio_venta_total')}}" name="precio_venta_total" id="precio_venta_total" placeholder="..." required/>
                                    <div class="invalid-feedback">Total es obligatorio</div>
                                    @error('precio_venta_total')
                                        <div style="color:red; font-size: 75%;">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row"> {{-- saldo --}}
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="cantidad_saldo">Cantidad saldo:</label>
                                    <input type="number" class="form-control" value="{{old('cantidad_saldo')}}" name="cantidad_saldo" id="cantidad_saldo" required>
                                    <div class="invalid-feedback">Cantidad es obligatorio</div>
                                    @error('cantidad_saldo')
                                        <div style="color:red; font-size: 75%;">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="precio_saldo">Precio saldo x 1000:</label>
                                    <input type="text" class="form-control" value="{{old('precio_saldo')}}" name="precio_saldo" id="precio_saldo" placeholder="..." required/>
                                    <div class="invalid-feedback">Precio unitario es obligatorio</div>
                                    @error('precio_saldo')
                                        <div style="color:red; font-size: 75%;">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="tipo_almacen_id">Guardar saldo en:</label>
                                    <select class="form-select form-control" name="tipo_almacen_id" id="tipo_almacen_id" required>
                                        <option value=""> -- donde --</option>
                                        @forelse ($tipoAlmacen as $item)
                                            <option value="{{ $item->id }}">{{ $item->descripcion }}</option>
                                        @empty
                                            <option value="">-- Error --</option>
                                        @endforelse
                                    </select>
                                    <div class="invalid-feedback">Total es obligatorio</div>
                                    @error('tipo_almacen_id')
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

    {{-- modal para actualizar producto --}}
    <div class="modal fade" id="modalProductoEditar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Producto a comercializar</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('comercio.operacion.producto.actualizar') }}" method="POST" class="row g-3 needs-validation" novalidate>
                        @csrf
                        <input type="hidden" name="comercio_id" value="{{ $comercio->id }}">
                        <input type="hidden" name="com_prod_id" id="com_prod_id" value="">
                        <div class="row">{{-- producto --}}
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label for="tipo_origen">Origen:</label>
                                    <select class="form-select form-control" name="tipo_origen_id" id="tipo_origen_id">
                                        @forelse ($tipoOrigen as $item)
                                            <option value="{{ $item->id }}">{{ $item->descripcion }}</option>
                                        @empty
                                            <option value="">-- Error --</option>
                                        @endforelse
                                    </select>
                                    @error('tipo_origen_id')
                                        <div style="color:red; font-size: 75%;">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-7">
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
                        <div class="row"> {{-- Compra --}}
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="cantidad_compra_e">Cantidad compra:</label>
                                    <input onchange="calculoTotal_e();" type="number" value="{{old('cantidad_compra_e')}}" name="cantidad_compra_e" id="cantidad_compra_e" class="form-control" required>
                                    <div class="invalid-feedback">Cantidad es obligatorio</div>
                                    @error('cantidad_compra_e')
                                        <div style="color:red; font-size: 75%;">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="precio_compra_e">Precio compra x 1000:</label>
                                    <input onchange="calculoTotal_e();" type="number" value="{{old('precio_compra_e')}}" name="precio_compra_e" id="precio_compra_e" class="form-control" placeholder="..." required/>
                                    <div class="invalid-feedback">Precio unitario es obligatorio</div>
                                    @error('precio_compra_e')
                                        <div style="color:red; font-size: 75%;">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="precio_compra_total_e">Precio compra Total:</label>
                                    <input type="text" value="{{old('precio_compra_total_e')}}" name="precio_compra_total_e" id="precio_compra_total_e" class="form-control" placeholder="..." required/>
                                    <div class="invalid-feedback">Total es obligatorio</div>
                                    @error('precio_compra_total_e')
                                        <div style="color:red; font-size: 75%;">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row"> {{-- Venta --}}
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="cantidad_venta_e">Cantidad venta:</label>
                                    <input onchange="calculoTotalVenta_e();" type="number" value="{{old('cantidad_venta_e')}}" name="cantidad_venta_e" id="cantidad_venta_e" class="form-control" required>
                                    <div class="invalid-feedback">Cantidad es obligatorio</div>
                                    @error('cantidad_venta_e')
                                        <div style="color:red; font-size: 75%;">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="precio_venta_e">Precio venta x 1000:</label>
                                    <input onchange="calculoTotalVenta_e();" type="number" value="{{old('precio_venta_e')}}" name="precio_venta_e" id="precio_venta_e" class="form-control" placeholder="..." required/>
                                    <div class="invalid-feedback">Precio unitario es obligatorio</div>
                                    @error('precio_venta_e')
                                        <div style="color:red; font-size: 75%;">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="precio_venta_total_e">Precio venta Total:</label>
                                    <input type="text" value="{{old('precio_venta_total_e')}}" name="precio_venta_total_e" id="precio_venta_total_e" class="form-control" placeholder="..." required/>
                                    <div class="invalid-feedback">Total es obligatorio</div>
                                    @error('precio_venta_total_e')
                                        <div style="color:red; font-size: 75%;">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row"> {{-- saldo --}}
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="cantidad_saldo_e">Cantidad saldo:</label>
                                    <input type="number" value="{{old('cantidad_saldo_e')}}" name="cantidad_saldo_e" id="cantidad_saldo_e" class="form-control" required>
                                    <div class="invalid-feedback">Cantidad es obligatorio</div>
                                    @error('cantidad_saldo_e')
                                        <div style="color:red; font-size: 75%;">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="precio_saldo_e">Precio saldo x 1000:</label>
                                    <input type="text" value="{{old('precio_saldo_e')}}" name="precio_saldo_e" id="precio_saldo_e" class="form-control" placeholder="..." required/>
                                    <div class="invalid-feedback">Precio unitario es obligatorio</div>
                                    @error('precio_saldo_e')
                                        <div style="color:red; font-size: 75%;">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="tipo_almacen_id">Guardar saldo en:</label>
                                    <select class="form-select form-control" name="tipo_almacen_id" id="tipo_almacen_id" required>
                                        <option value=""> -- donde --</option>
                                        @forelse ($tipoAlmacen as $item)
                                            <option value="{{ $item->id }}">{{ $item->descripcion }}</option>
                                        @empty
                                            <option value="">-- Error --</option>
                                        @endforelse
                                    </select>
                                    <div class="invalid-feedback">Total es obligatorio</div>
                                    @error('tipo_almacen_id')
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
        })();

        function calculoTotal(){
            var pc = document.getElementById('precio_compra').value;
            var cc = document.getElementById('cantidad_compra').value;
            var tot = (pc/1000)*cc;
            document.getElementById('precio_compra_total').value=tot;
            //---saldo
            var cv = document.getElementById('cantidad_venta').value;
            var sal = cc-cv;
            document.getElementById('cantidad_saldo').value=sal;
            if(sal)document.getElementById('precio_saldo').value=pc;
            else document.getElementById('precio_saldo').value=0;
        }

        function calculoTotalVenta(){
            var pv = document.getElementById('precio_venta').value;
            var cv = document.getElementById('cantidad_venta').value;
            var tot = (pv/1000)*cv;
            document.getElementById('precio_venta_total').value=tot;
            //---saldo
            var cc = document.getElementById('cantidad_compra').value;
            var pc = document.getElementById('precio_compra').value;
            var sal = cc-cv;
            document.getElementById('cantidad_saldo').value=sal;
            if(sal)document.getElementById('precio_saldo').value=pc;
            else document.getElementById('precio_saldo').value=0;
        }

        function recuperarProdCom(prod){
            $.ajax({
                url : "{{route('comercio.operacion.producto.edit')}}",
                data : { 'comercio_productos_id':prod, "_token": "{{ csrf_token() }}", },
                type : 'POST',
                dataType : 'json',
                success : function(resp) {
                    if(resp.estado == true){
                        $('#com_prod_id').val(resp.comProducto.id);
                        $('#cantidad_compra_e').val(resp.comProducto.cantidad_compra);
                        if(resp.comProducto.precio_compra > 0)$('#precio_compra_e').val(resp.comProducto.precio_compra);
                        else $('#precio_compra_e').val('');
                        if(resp.comProducto.precio_compra_total > 0)$('#precio_compra_total_e').val(resp.comProducto.precio_compra_total);
                        else $('#precio_compra_total_e').val('');
                        $('#cantidad_venta_e').val(resp.comProducto.cantidad_venta);
                        $('#precio_venta_e').val(resp.comProducto.precio_venta);
                        $('#precio_venta_total_e').val(resp.comProducto.precio_venta_total);
                        $('#cantidad_saldo_e').val(0);
                        $('#precio_saldo_e').val(0);
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
                    $('#estadoFirmador').html('<span class="badge badge-phoenix badge-phoenix-warning">El firmador no esta activo en su equipo.</span>');
                }
            });
        }

        function calculoTotal_e(){
            var pc = document.getElementById('precio_compra_e').value;
            var cc = document.getElementById('cantidad_compra_e').value;
            var tot = (pc/1000)*cc;
            document.getElementById('precio_compra_total_e').value=tot;
            //---saldo
            var cv = document.getElementById('cantidad_venta_e').value;
            var sal = cc-cv;
            document.getElementById('cantidad_saldo_e').value=sal;
            if(sal)document.getElementById('precio_saldo_e').value=pc;
            else document.getElementById('precio_saldo_e').value=0;
        }

        function calculoTotalVenta_e(){
            var pv = document.getElementById('precio_venta_e').value;
            var cv = document.getElementById('cantidad_venta_e').value;
            var tot = (pv/1000)*cv;
            document.getElementById('precio_venta_total_e').value=tot;
            //---saldo
            var cc = document.getElementById('cantidad_compra_e').value;
            var pc = document.getElementById('precio_compra_e').value;
            var sal = cc-cv;
            document.getElementById('cantidad_saldo_e').value=sal;
            if(sal)document.getElementById('precio_saldo_e').value=pc;
            else document.getElementById('precio_saldo_e').value=0;
        }

        $('.form-eliminar-producto').submit(function(e){
            e.preventDefault();
            swal({
                title: "Advertencia !!",
                text: "Esta seguro de eliminar el producto ?",
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
    </script>
@endsection