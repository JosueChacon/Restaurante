<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Restaurant en Línea - Administrador</title>
  <link rel="icon" type="image/png" href="/img/icon/empleado.svg" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="stylesheet" href="/adminlte/plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <link rel="stylesheet" href="/adminlte/dist/css/adminlte.min.css">
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  @yield('estilos')
</head>

<body class="hold-transition sidebar-mini">
  <div class="wrapper">

    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>          
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('home') }}"><i class="fas fa-home"></i> Inicio</a>          
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('programacion.index') }}"><i class="fas fa-check-circle"></i> Programaciones</a>          
        </li>
      </ul>
    </nav>

    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <div class="brand-link">
        <img  alt="AdminLTE Logo"
        class="brand-image img-circle elevation-3"
        src="/img/cargo.png" style="opacity: .8">
       <span class="brand-text font-weight-light">{{ auth()->user()->Persona->Trabajador->Cargo['descripcion'] }}</span>
      </div>

      <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="image">
            <img class="img-circle elevation-2" alt="User Image"
            src="{{ asset(auth()->user()->getRutaFoto()) }}">
          </div>
          <div class="info">
            <label for="" style="color: white">{{ auth()->user()->Persona->nombres }} <i class="fas fa-circle text-success"></i></label>            
          </div>
        </div>

        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-header text-white">PERSONAL</li>
            <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-folder-open"></i>
                <p>
                  Trabajadores
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{ URL::to('trabajadores/MiGente') }}" class="nav-link">
                    <i class="nav-icon fas fa-people-carry"></i>
                    <p>Mi Gente</p>
                  </a>
                </li>
                {{-- <li class="nav-item">
                  <a href="{{route('ClavePersonal')}}" class="nav-link">
                    <i class="nav-icon fas fa-chevron-circle-right"></i>
                    <p>Cambiar Claves</p>
                  </a>
                </li> --}}
              </ul>
            </li>

            <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-question"></i>
                <p>
                  Consultas
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{ route('ListaTrabajadores_') }}" class="nav-link">
                    <i class="nav-icon fas fa-check-circle"></i>
                    <p>Trabajadores</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('ListaClientes') }}" class="nav-link">
                    <i class="nav-icon fas fa-check-circle"></i>
                    <p>Clientes</p>
                  </a>
                </li>
              </ul>
            </li>

            <li class="nav-header text-white" style="margin-top: -10pt">CAJA</li>
            <li class="nav-item">
              <a href="{{route('aperturarcaja')}}" class="nav-link">
                <i class="nav-icon fas fa-lock-open"></i>
                <p>Aperturar caja</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{route('cerrarcaja')}}" class="nav-link">
                <i class="nav-icon fas fa-lock"></i>
                <p>Cerrar caja</p>
              </a>
            </li>
            <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-question"></i>
                <p>
                  Consultas
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{route('ListaRecibos')}}" class="nav-link">
                    <i class="nav-icon fas fa-check-circle"></i>
                    <p>Ventas Generales</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{route('MontoEnCaja')}}" class="nav-link">
                    <i class="nav-icon fas fa-check-circle"></i>
                    <p>Ventas del día</p>
                  </a>
                </li>
                {{-- <li class="nav-item">
                  <a href="{{route('resumencaja')}}" class="nav-link">
                    <i class="nav-icon fas fa-check-circle"></i>
                    <p>Resumen de caja</p>
                  </a>
                </li> --}}
              </ul>
            </li>

            <li class="nav-header text-white" style="margin-top: -10pt">RECURSOS</li>
            <li class="nav-item">
              <a href="{{route('NotaIngreso.index')}}" class="nav-link">
                <i class="nav-icon fas fa-clipboard"></i>
                <p>Nota de Ingreso</p>
              </a>
            </li>
            <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-tasks"></i>
                <p>
                  Abastecimiento
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{ route('mesas.index') }}" class="nav-link">
                    <i class="nav-icon fas fa-chevron-circle-right"></i>
                    <p>Mesas</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ URL::to('abastecimiento/tipoplato') }}" class="nav-link">
                    <i class="nav-icon fas fa-chevron-circle-right"></i>
                    <p>Tipos de Plato</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ URL::to('abastecimiento/plato') }}" class="nav-link">
                    <i class="nav-icon fas fa-chevron-circle-right"></i>
                    <p>Platos</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ URL::to('abastecimiento/categoria') }}" class="nav-link">
                    <i class="nav-icon fas fa-chevron-circle-right"></i>
                    <p>Categorías</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ URL::to('abastecimiento/producto') }}" class="nav-link">
                    <i class="nav-icon fas fa-chevron-circle-right"></i>
                    <p>Bebidas</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ URL::to('abastecimiento/programacion') }}" class="nav-link">
                    <i class="nav-icon fas fa-chevron-circle-right"></i>
                    <p>Programación</p>
                  </a>
                </li>
              </ul>
            </li>

            <li class="nav-header text-white" style="margin-top: -10pt">CUENTA</li>
            <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-cog"></i>
                <p>
                  Configuración
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{ route('cambiarfoto') }}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Cambiar foto de perfil</p>
                  </a>
                </li>

                <li class="nav-item">
                  <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-block btn-outline-secondary btn-sm">
                      Cerrar Sesión
                    </button>
                  </form>
                </li>
              </ul>
            </li>

          </ul>
        </nav>
        <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
    </aside>

    <div class="content-wrapper">
      <section class="content">
        <br>
        <div class="container">
          <section class="content">
            <div class="container-fluid">
              @yield('contenido')
            </div>
          </section>
        </div>
      </section>
    </div>

    <aside class="control-sidebar control-sidebar-dark">
    </aside>
  </div>

  <script src="/adminlte/plugins/jquery/jquery.min.js"></script>
  <script src="/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="/adminlte/dist/js/adminlte.min.js"></script>
  <script src="/adminlte/dist/js/demo.js"></script>
  <script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>
  <script src="/js/ruta-api.js"></script>
  @yield('script')
</body>

</html>