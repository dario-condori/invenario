@extends('admin._base')

@section('titulo')
    Resumen
@endsection

@section('contenido')
    <div class="container">
        <div class="page-inner">
            <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
                <div>
                    <h3 class="fw-bold mb-3">Resumen</h3>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6 col-md-3">
                    <div class="card card-stats card-round">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-icon">
                                    <div class="icon-big text-center icon-primary bubble-shadow-small">
                                        <i class="fas fa-users"></i>
                                    </div>
                                </div>
                                <div class="col col-stats ms-3 ms-sm-0">
                                    <div class="numbers">
                                        <p class="card-category">Vueltas</p>
                                        <h4 class="card-title">13</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="card card-stats card-round">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-icon">
                                    <div class="icon-big text-center icon-info bubble-shadow-small">
                                        <i class="fas fa-user-check"></i>
                                    </div>
                                </div>
                                <div class="col col-stats ms-3 ms-sm-0">
                                    <div class="numbers">
                                        <p class="card-category">Comprados</p>
                                        <h4 class="card-title">7000</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="card card-stats card-round">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-icon">
                                    <div class="icon-big text-center icon-success bubble-shadow-small">
                                        <i class="fas fa-luggage-cart"></i>
                                    </div>
                                </div>
                                <div class="col col-stats ms-3 ms-sm-0">
                                    <div class="numbers">
                                        <p class="card-category">Vendidos</p>
                                        <h4 class="card-title">6,500</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="card card-stats card-round">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-icon">
                                    <div class="icon-big text-center icon-secondary bubble-shadow-small">
                                        <i class="far fa-check-circle"></i>
                                    </div>
                                </div>
                                <div class="col col-stats ms-3 ms-sm-0">
                                    <div class="numbers">
                                        <p class="card-category">Almacen</p>
                                        <h4 class="card-title">576</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8">
                    <div class="card card-round">
                        <div class="card-header">
                            <div class="card-head-row card-tools-still-right">
                                <div class="card-title">Comercialización</div>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table align-items-center mb-0">
                                    <thead class="thead-light">
                                        <tr>
                                            <th scope="col">Vuelta</th>
                                            <th scope="col" class="text-end">Producto</th>
                                            <th scope="col" class="text-end">Compra</th>
                                            <th scope="col" class="text-end">Bs.</th>
                                            <th scope="col" class="text-end">Venta</th>
                                            <th scope="col" class="text-end">Bs.</th>
                                            <th scope="col" class="text-end">Estado</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="text-center">1</td>
                                            <td class="text-start">ladrillo de 18 huecos</td>
                                            <td class="text-end">3,000 Uni</td>
                                            <td class="text-end">2,250.00</td>
                                            <td class="text-end">3,000 Uni</td>
                                            <td class="text-end">2,700.00</td>
                                            <td class="text-center">
                                                <span class="badge badge-success">Entregado</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">2</td>
                                            <td class="text-start">ladrillo de 18 huecos</td>
                                            <td class="text-end">3,000 Uni</td>
                                            <td class="text-end">2,250.00</td>
                                            <td class="text-end">3,000 Uni</td>
                                            <td class="text-end">2,700.00</td>
                                            <td class="text-center">
                                                <span class="badge badge-success">Entregado</span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-round">
                        <div class="card-body">
                            <div class="card-head-row card-tools-still-right">
                                <div class="card-title">Otros productos</div>
                            </div>
                            <div class="card-list py-4">
                                <div class="item-list">
                                    <div class="info-user ms-3">
                                        <div class="status">06-09-2024</div>
                                    </div>
                                    <div class="info-user ms-3">
                                        <div class="username">Cerramica</div>
                                        <div class="status">Color blanco</div>
                                    </div>
                                    <div class="info-user ms-3">
                                        <div class="username">200 uni</div>
                                        <div class="status">1500 Bs</div>
                                    </div>
                                </div>
                                <div class="item-list">
                                    <div class="info-user ms-3">
                                        <div class="status">05-09-2024</div>
                                    </div>
                                    <div class="info-user ms-3">
                                        <div class="username">Bota agua</div>
                                        <div class="status">doble</div>
                                    </div>
                                    <div class="info-user ms-3">
                                        <div class="username">20 uni</div>
                                        <div class="status">150 Bs</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('javascripts')
    <script>
        document.getElementById('mResumen').classList.add('active');
    </script>
@endsection