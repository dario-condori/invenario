<!DOCTYPE html>
<html lang="es">
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>@yield('titulo', 'Inventario')</title>
    <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport" />
    <link rel="icon" href="{{ asset('plantilla/img/kaiadmin/favicon.ico') }}" type="image/x-icon"/>

    <!-- Fonts and icons -->
    <script src="{{ asset('plantilla/js/plugin/webfont/webfont.min.js') }}"></script>
    <script>
      WebFont.load({
        google: { families: ["Public Sans:300,400,500,600,700"] },
        custom: {
          families: [
            "Font Awesome 5 Solid",
            "Font Awesome 5 Regular",
            "Font Awesome 5 Brands",
            "simple-line-icons",
          ],
          urls: ["{{ asset('plantilla/css/fonts.min.css') }}"],
        },
        active: function () {
          sessionStorage.fonts = true;
        },
      });
    </script>

    <!-- CSS Files -->
    <link rel="stylesheet" href="{{ asset('plantilla/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('plantilla/css/plugins.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('plantilla/css/kaiadmin.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('plantilla/css/demo.css') }}" />

    @yield('hojaEstilo')

  </head>
    <body>
        <div class="wrapper">
            <!-- lateral -->
            {{-- <div class="sidebar" data-background-color="dark">
                @include('admin._baseLateral')
            </div> --}}
            <!-- panel -->
            <div class="main-panel" style="width: 100%;">
                {{-- @include('admin._baseCabecera') --}}

                @yield('contenido')
                
                @include('admin._basePie')
            </div>
        </div>
        <!--   Core JS Files   -->
        <script src="{{ asset('plantilla/js/core/jquery-3.7.1.min.js') }}"></script>
        <script src="{{ asset('plantilla/js/core/popper.min.js') }}"></script>
        <script src="{{ asset('plantilla/js/core/bootstrap.min.js') }}"></script>
        <script src="{{ asset('plantilla/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js') }}"></script>
        <script src="{{ asset('plantilla/js/plugin/chart.js/chart.min.js') }}"></script>
        <script src="{{ asset('plantilla/js/plugin/jquery.sparkline/jquery.sparkline.min.js') }}"></script>
        <script src="{{ asset('plantilla/js/plugin/chart-circle/circles.min.js') }}"></script>
        <script src="{{ asset('plantilla/js/plugin/datatables/datatables.min.js') }}"></script>
        <script src="{{ asset('plantilla/js/plugin/bootstrap-notify/bootstrap-notify.min.js') }}"></script>
        <script src="{{ asset('plantilla/js/plugin/jsvectormap/jsvectormap.min.js') }}"></script>
        <script src="{{ asset('plantilla/js/plugin/jsvectormap/world.js') }}"></script>
        <script src="{{ asset('plantilla/js/plugin/sweetalert/sweetalert.min.js') }}"></script>
        <script src="{{ asset('plantilla/js/kaiadmin.min.js') }}"></script>
        <script src="{{ asset('plantilla/js/setting-demo.js') }}"></script>
        <script src="{{ asset('plantilla/js/demo.js') }}"></script>

        @yield('javascripts')
    </body>
</html>
