@extends('admin._base')

@section('titulo')
    Vehículo Nuevo
@endsection

@section('contenido')
    <div class="container">
        <div class="page-inner">
            <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
                <div>
                    <h3 class="fw-bold mb-3">Agregar vuelta: {{ $vehiculo->marca }} - {{ $vehiculo->placa }}</h3>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <form action="{{ route('comercio.operacion.guardar') }}" method="POST" class="row g-3 needs-validation" novalidate="">
                            @csrf
                            <input type="hidden" value="{{$vehiculo->id}}" name="vehiculo_id">
                            <input type="hidden" value="{{$combustible->id}}" name="combustible_id">
                            <div class="card-header">
                                <div class="card-title">
                                    <div class="row">
                                        <div class="col-md-6">
                                            Producto: 
                                            <select class="form-select form-control" name="producto_id" id="producto_id">
                                                @forelse ($productos as $item)
                                                    <option value="{{$item->id}}">{{ $item->descripcion }} - ({{ $item->sigla }})</option>
                                                @empty
                                                    <option>sin productos</option>
                                                @endforelse
                                            </select>
                                            @error('producto_id')
                                                <div style="color:red; font-size: 75%;">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            Proforma: 
                                            <select class="form-select form-control" name="proforma_id" id="proforma_id">
                                                @forelse ($proformas as $item)
                                                    @if(!count($item->comercios))
                                                        <option value="{{$item->id}}">({{ sprintf('%04d', $item->id) }}/{{ $item->gestion }}) : {{ $item->cliente_nombre }}</option>
                                                    @endif
                                                @empty
                                                    <option>sin productos</option>
                                                @endforelse
                                            </select>
                                            @error('producto_id')
                                                <div style="color:red; font-size: 75%;">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div> 
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="vuelta">Vuelta</label>
                                            <input type="number" class="form-control" value="{{old('vuelta', $nro_vuelta)}}" name="vuelta" id="vuelta" placeholder="..."/>
                                            @error('vuelta')
                                                <div style="color:red; font-size: 75%;">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="fecha">Fecha</label>
                                            <input type="date" class="form-control" value="{{old('fecha')}}" name="fecha" id="fecha"/>
                                            @error('fecha')
                                                <div style="color:red; font-size: 75%;">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="cantidad_compra">Cantidad de COMPRA</label>
                                            <input type="number" class="form-control" value="{{old('cantidad_compra')}}" name="cantidad_compra" id="cantidad_compra" placeholder="..."/>
                                            @error('cantidad_compra')
                                                <div style="color:red; font-size: 75%;">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="precio_compra">Precio de compra</label>
                                            <input type="number" class="form-control" value="{{old('precio_compra')}}" name="precio_compra" id="precio_compra" placeholder="..."/>
                                            @error('precio_compra')
                                                <div style="color:red; font-size: 75%;">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="cantidad_venta">Cantidad de VENTA</label>
                                            <input type="number" class="form-control" value="{{old('cantidad_venta')}}" name="cantidad_venta" id="cantidad_venta" placeholder="..."/>
                                            @error('cantidad_venta')
                                                <div style="color:red; font-size: 75%;">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="precio_venta">Precio de venta</label>
                                            <input type="number" class="form-control" value="{{old('precio_venta')}}" name="precio_venta" id="precio_venta" placeholder="..."/>
                                            @error('precio_venta')
                                                <div style="color:red; font-size: 75%;">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="cantidad_saldo">Cantidad de SALDO</label>
                                            <input type="number" class="form-control" value="{{old('cantidad_saldo')}}" name="cantidad_saldo" id="cantidad_saldo" placeholder="..."/>
                                            @error('cantidad_saldo')
                                                <div style="color:red; font-size: 75%;">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="precio_saldo">Precio de saldo</label>
                                            <input type="number" class="form-control" value="{{old('precio_saldo')}}" name="precio_saldo" id="precio_saldo" placeholder="..."/>
                                            @error('precio_saldo')
                                                <div style="color:red; font-size: 75%;">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="lugar_venta">Lugar</label>
                                            <input type="text" class="form-control" value="{{old('lugar_venta')}}" name="lugar_venta" id="lugar_venta" placeholder="..."/>
                                            @error('lugar_venta')
                                                <div style="color:red; font-size: 75%;">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="personal_id">Chofer</label>
                                            <select class="form-select form-control" name="personal_id" id="personal_id">
                                                @forelse ($personal as $item)
                                                    <option value="{{$item->id}}">{{ $item->nombres }} {{ $item->apellido_1 }} {{ $item->apellido_2 }}</option>
                                                @empty
                                                    <option>sin personal</option>
                                                @endforelse
                                            </select>
                                            @error('personal_id')
                                                <div style="color:red; font-size: 75%;">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-action">
                                <button class="btn btn-success" type="submit">Registrar</button>
                                <a href="{{ route('admin.vehiculos') }}" class="btn btn-danger">Cancelar</a>
                            </div>
                        </form>
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