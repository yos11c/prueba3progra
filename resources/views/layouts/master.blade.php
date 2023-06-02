<!DOCTYPE html>
<html lang="en">
    <head>
        <div><link rel="shortcut icon" href="/favicon.png">
            <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
            <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0" />
            <title>PROYECTO GRUPO #4</title>

            <!-- CSS Materialize -->
            <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
            <link rel="stylesheet" href="{{ asset('css/materialize.min.css') }}"> <!-- Con asset, laravel va a la carpeta 'public' y busca la ruta dada -->

            <!-- JQuery -->
            <script src="{{ asset('js/jquery-2.1.1.min.js') }}"></script>

            <!-- Datatable -->
            <link rel="stylesheet" type="text/css" href="{{ asset('css/jquery.dataTables.min.css') }}">
            <script type="text/javascript" charset="utf8" src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
            <!-- Datatable Responsive -->
            <link rel="stylesheet" type="text/css" href="{{ asset('css/responsive.dataTables.min.css') }}">
            <script type="text/javascript" charset="utf8" src="{{ asset('js/dataTables.responsive.min.js') }}"></script>

            <!-- Mensajes de alerta -->
            <link rel="stylesheet" href="{{ asset('css/toastr.min.css') }}">
            <script src="{{ asset('js/toastr.min.js') }}" charset="utf-8"></script>

            @yield('header')</div>
    </head>

    <body background="{{asset('img/background.png')}}">
        <!--Menus desplegables-->
        <ul id="dropdown1" class="dropdown-content">
            <li><a href="motores"><i class="material-icons left">time_to_leave</i>Motores</a></li>
            <li><a href="transmisiones"><i class="material-icons left">event_seat</i>Transmisiones</a></li>
            <li><a href="partes"><i class="material-icons left">extension</i>Partes</a></li>
            <li><a href="herramientas"><i class="material-icons left">settings</i>Herramientas</a></li>
            <li><a href="cajas_herramientas"><i class="material-icons left">business_center</i>Cajas de herramientas</a></li>
        </ul>
        <ul id="dropdown2" class="dropdown-content">
            <li><a href="motores"><i class="material-icons left">time_to_leave</i>Motores</a></li>
            <li><a href="transmisiones" style="font-size: 15px"><i class="material-icons left">event_seat</i>Transmisiones</a></li>
            <li><a href="partes" style="font-size: 15px"><i class="material-icons left">extension</i>Partes</a></li>
            <li><a href="herramientas" style="font-size: 15px"><i class="material-icons left">settings</i>Herramientas</a></li>
            <li><a href="cajas_herramientas" style="font-size: 15px"><i class="material-icons left">business_center</i>Cajas de Herramientas</a></li>
        </ul>
        <ul id="dropdown3" class="dropdown-content">
            <li><a href="servicios"><i class="material-icons left">dvr</i>Servicios</a></li>
            <li><a href="ventas"><i class="material-icons left">shopping_basket</i>Ventas</a></li>
            <li><a href="gastos"><i class="material-icons left">money_off</i>Gastos</a></li>
        </ul>

        <ul id="dropdown4" class="dropdown-content">
            <li><a href="servicios"><i class="material-icons left">dvr</i>Servicios</a></li>
            <li><a href="ventas"><i class="material-icons left">shopping_basket</i>Ventas</a></li>
            <li><a href="gastos"><i class="material-icons left">money_off</i>Gastos</a></li>
        </ul>
        <ul id="dropdown5" class="dropdown-content">
             <li><a href="historial"><i class="material-icons left">info_outline</i>Historial</a></li>
            <li><a href="gerentes"><i class="material-icons left">group</i>Gerentes</a></li>
        </ul>

        <ul id="dropdown6" class="dropdown-content">
             <li><a href="historial"><i class="material-icons left">info_outline</i>Historial</a></li>
            <li><a href="gerentes"><i class="material-icons left">group</i>Gerentes</a></li>
        </ul>

        <ul id="dropdown7" class="dropdown-content">
             <li><a href="empleados"><i class="material-icons left">assignment_ind</i>Empleados</a></li>
            <li><a href="faltas"><i class="material-icons left">event_busy</i>Faltas</a></li>
        </ul>

        <ul id="dropdown8" class="dropdown-content">
            <li><a href="empleados"><i class="material-icons left">assignment_ind</i>Empleados</a></li>
            <li><a href="faltas"><i class="material-icons left">event_busy</i>Faltas</a></li>
        </ul>

        <!-- La secciones que tengan el arroba isAdmin, endisAdmin,
        son las secciones que solo podra ver el Administrador -->

        <nav>
            <div class="nav-wrapper">
                <a href="/" class="brand-logo" style="margin-left: 15px; margin-top: 6px;"><img style="width: 120px;" src="/img/la.png"></a>
                <a href="#" data-target="mobile-demo" class="sidenav-trigger"><i class="material-icons">menu</i></a>
                <ul id="nav-mobile" class="right hide-on-med-and-down">
                    <li><a href="/" style="margin-right: 10px; width: 92%;"><i class="material-icons left">home</i>Inicio</a></li>
                    <li><a href="trabajos" style="margin-right: 10px; width: 93%;"><i class="material-icons left">assignment_ind</i>Trabajos</a></li>

                    @isAdmin
                    <li><a class="dropdown-trigger" href="#" data-target="dropdown4" style="margin-right: 10px; width: 95%;"><i class="material-icons left">monetization_on</i>Finanzas<i class="material-icons right">arrow_drop_down</i></a></li>
                    <li><a class="dropdown-trigger" href="#" data-target="dropdown6" style="margin-right: 10px; width: 95%;"><i class="material-icons left">verified_user</i>Admin<i class="material-icons right">arrow_drop_down</i></a></li>
                    <li><a href="Dashboard" style="margin-right: 10px; width: 93%;"><i class="material-icons left">assignment_ind</i>Graficos</a></li>
                    @endisAdmin
                        <!-- Dropdown Trigger -->
                        <li><a class="dropdown-trigger" href="#" data-target="dropdown8" style="margin-right: 10px; width: 95%;"><i class="material-icons left">person</i>Empleados<i class="material-icons right">arrow_drop_down</i></a></li>
                        <li><a class="dropdown-trigger" href="#" data-target="dropdown2" style="margin-right: 10px;"><i class="material-icons left">build</i>Inventario<i class="material-icons right">arrow_drop_down</i></a></li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <center><p>
                                    <button type="submit" class="waves-effect waves-light btn-small #ef5350 red lighten-1" style="margin-bottom: 40px; margin-right: 10px; width: 80%;">Salir</button>
                                </p></center>
                            </form>
                        </li>
                </ul>
            </div>
        </nav>

        <ul id="mobile-demo" class="sidenav">
            <li><a href="/" style="margin-right: 10px;"><i class="material-icons">home</i>Inicio</a></li>
            <li><a href="trabajos" style="margin-right: 10px;"><i class="material-icons left">assignment_ind</i>Trabajos</a></li>
            <li><a class="dropdown-trigger" href="#" data-target="dropdown7" style="margin-right: 10px;"><i class="material-icons left">person</i>Empleados<i class="material-icons right">arrow_drop_down</i></a></li>
            @isAdmin
            <li><a class="dropdown-trigger" href="#" data-target="dropdown5" style="margin-right: 10px;"><i class="material-icons left">verified_user</i>Admin<i class="material-icons right">arrow_drop_down</i></a></li>
            <li><a class="dropdown-trigger" href="#" data-target="dropdown3" style="margin-right: 10px;"><i class="material-icons left">monetization_on</i>Finanzas<i class="material-icons right">arrow_drop_down</i></a></li>
            @endisAdmin
                <!-- Dropdown Trigger -->
                <li><a class="dropdown-trigger" href="#" data-target="dropdown1" style="margin-right: 10px;"><i class="material-icons">build</i>Inventario<i class="material-icons right">arrow_drop_down</i></a></li>
                <li>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <center><p>
                            <button type="submit" class="waves-effect waves-light btn-small #ef5350 red lighten-1" style="margin-bottom: 40px; margin-right: 15px;">Salir</button>
                        </p></center>
                    </form>
                </li>
        </ul>


        <div class="container">
            @yield('content')
        </div>

        <!--  Scripts-->
        <script src="{{asset('js/materialize.min.js')}}"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                M.updateTextFields();
            });
        </script>
        <script type="text/javascript">
            document.addEventListener('DOMContentLoaded', function() {
                //collapsible
                var elems = document.querySelectorAll('.collapsible');
                var options;
                var instances = M.Collapsible.init(elems, options);

                //select option
                var elems2 = document.querySelectorAll('select');
                var instances2 = M.FormSelect.init(elems2);

                //Menu desplegable navbar
                //$(".dropdown-trigger").dropdown();
            });
        </script>

        <script type="text/javascript">
            $(".dropdown-trigger").dropdown();
        </script>

        @if(Session::has('info'))
            <script type="text/javascript">
                toastr.info('{{ Session::get('info') }}');
            </script>
        @elseif(Session::has('success'))
            <script type="text/javascript">
                toastr.success('{{ Session::get('success') }}');
            </script>
        @elseif(Session::has('error'))
            <script type="text/javascript">
                toastr.error('{{ Session::get('error') }}');
            </script>


        @endif

        <script type="text/javascript">
            $(document).ready(function(){
                $('.sidenav').sidenav();
            });
        </script>

        @yield('footer')
    </body>
</html>
