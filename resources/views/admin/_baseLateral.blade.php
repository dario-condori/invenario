<div class="sidebar-logo">
    <!-- Logo Header -->
    <div class="logo-header" data-background-color="dark">
        <a href="index.html" class="logo">
            <img src="{{ asset('plantilla/img/kaiadmin/logo_light.svg') }}" alt="navbar brand" class="navbar-brand" height="20"/>
        </a>
        <div class="nav-toggle">
            <button class="btn btn-toggle toggle-sidebar">
                <i class="gg-menu-right"></i>
            </button>
            <button class="btn btn-toggle sidenav-toggler">
                <i class="gg-menu-left"></i>
            </button>
        </div>
        <button class="topbar-toggler more">
            <i class="gg-more-vertical-alt"></i>
        </button>
    </div>
    <!-- End Logo Header -->
</div>

<div class="sidebar-wrapper scrollbar scrollbar-inner">
    <div class="sidebar-content">
        <ul class="nav nav-secondary">
            <li id="mResumen" class="nav-item">
                <a href="{{ route('admin.dashboard',['fecha_comercio'=>date('Y-m-d')]) }}">
                    <i class="fas fa-desktop"></i>
                    <p>Resumen</p>
                    <span class="badge badge-success">4</span>
                </a>
            </li>
            <li id="mVehiculos" class="nav-item">
                <a href="{{ route('admin.vehiculos') }}">
                    <i class="fas fa-truck"></i>
                    <p>Vehículos</p>
                </a>
            </li>
            <li id="mProforma" class="nav-item">
                <a href="{{ route('proforma.listado') }}">
                    <i class="fas fa-clipboard"></i>
                    <p>Proforma</p>
                </a>
            </li>
            <li id="mComercializacion" class="nav-item">
                <a href="{{ route('comercio.listado',['fecha_comercio'=>date('Y-m-d')]) }}">
                    <i class="fas fa-dollar-sign"></i>
                    <p>Comercialización</p>
                </a>
            </li>
            <li id="mReporteSemanal" class="nav-item">
                <a href="{{ route('comercio.reporte.semanal',['fecha_comercio'=>date('Y-m-d')]) }}">
                    <i class="fas fa-dollar-sign"></i>
                    <p>Reporte Semanal</p>
                </a>
            </li>
            <li class="nav-item">
                <a data-bs-toggle="collapse" href="#base">
                    <i class="fas fa-layer-group"></i>
                    <p>Base</p>
                    <span class="caret"></span>
                </a>
                <div class="collapse" id="base">
                    <ul class="nav nav-collapse">
                        <li>
                            <a href="components/avatars.html">
                            <span class="sub-item">Avatars</span>
                            </a>
                        </li>
                        <li>
                            <a href="components/buttons.html">
                            <span class="sub-item">Buttons</span>
                            </a>
                        </li>
                        <li>
                            <a href="components/gridsystem.html">
                            <span class="sub-item">Grid System</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
</div>