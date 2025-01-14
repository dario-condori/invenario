@extends('admin._base')

@section('titulo')
    Combustible
@endsection

@section('contenido')
    <div class="container">
        <div class="page-inner">
            <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
                <div>
                    <h3 class="fw-bold mb-3">Combustible para: {{ $vehiculo->marca }} [Placa: {{ $vehiculo->placa }}]</h3>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <form action="{{ route('admin.combustible.cargar') }}" method="POST">
                            @csrf
                            <input type="hidden" name="vehiculo_id" id="vehiculo_id" value="{{$vehiculo->id}}">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="fecha">Fecha:</label>
                                            <input type="date" class="form-control" name="fecha" id="fecha" value="{{ old('fecha') }}" placeholder="..."/>
                                            @error('fecha')
                                                <div style="color:red; font-size: 75%;">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="precio_unitario">Tipo Servicio</label>
                                            <select class="form-select form-control" name="tipo_servicio_id" id="tipo_servicio_id">
                                                @forelse ($tipoMantenimiento as $item)
                                                    <option value="{{$item->id}}">{{ $item->descripcion }}</option>
                                                @empty
                                                    <option>sin tipo</option>
                                                @endforelse
                                            </select>
                                            @error('tipo_servicio_id')
                                                <div style="color:red; font-size: 75%;">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group md-6">
                                            <label for="costo_servicio">Costo del Servicio (Bs)</label>
                                            <input type="number" class="form-control" name="costo_servicio" id="costo_servicio" value="{{ old('costo_servicio') }}" placeholder="..." onchange="litrosCombustible()"/>
                                            @error('costo_servicio')
                                                <div style="color:red; font-size: 75%;">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="costo_material">Costo del material (Bs)</label>
                                            <input type="number" class="form-control" name="costo_material" id="costo_material" value="{{ old('costo_material') }}" placeholder="..." onchange="litrosCombustible()"/>
                                            @error('costo_material')
                                                <div style="color:red; font-size: 75%;">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="total_litros">Total litros</label>
                                            <input type="number" class="form-control" name="total_litros" id="total_litros" placeholder="0" disabled/>
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
        document.getElementById('mVehiculos').classList.add('active');
        
        function litrosCombustible(){
            var precio_unitario=$('input[id=precio_unitario]').val();
            var costo=$('input[id=costo]').val();
            $('#total_litros').val(Math.round(costo / precio_unitario));
        }
    </script>
@endsection