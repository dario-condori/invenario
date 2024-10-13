@extends('admin._base')

@section('titulo')
    Vehículo Nuevo
@endsection

@section('contenido')
    <div class="container">
        <div class="page-inner">
            <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
                <div>
                    <h3 class="fw-bold mb-3">Vehículos</h3>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Agregar</div>
                        </div>
                        <form action="{{ route('admin.vehiculos.guardar') }}" method="POST">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="marca">Marca</label>
                                            <input type="text" class="form-control" name="marca" id="marca" value="{{old('marca')}}" placeholder="..."/>
                                            @error('marca')
                                                <div style="color:red; font-size: 75%;">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="color">Color</label>
                                            <input type="text" class="form-control" name="color" id="color" value="{{old('color')}}" placeholder="..."/>
                                            @error('color')
                                                <div style="color:red; font-size: 75%;">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="modelo">Modelo</label>
                                            <input type="text" class="form-control" name="modelo" id="modelo" value="{{old('modelo')}}" placeholder="..."/>
                                            @error('modelo')
                                                <div style="color:red; font-size: 75%;">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="placa">Placa</label>
                                            <input type="text" class="form-control" name="placa" id="placa" value="{{old('placa')}}" placeholder="..."/>
                                            @error('placa')
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
        document.getElementById('mVehiculos').classList.add('active');
    </script>
@endsection