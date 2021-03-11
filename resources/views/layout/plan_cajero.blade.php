<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Restaurant .::Cajero</title>
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
          <a class="nav-link" href="{{ route('home') }}"><i class="fas fa-home"></i> 
            <abbr class="d-none d-sm-block float-right" style="text-decoration: none">&nbsp;Inicio</abbr>
          </a>          
        </li>
        <li class="nav-item">
          <a class="nav-link text-red" href="{{ route('logout') }}"><i class="fas fa-sign-out-alt"></i> Salir</a>          
        </li>  
      </ul>
    </nav>

    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="image">
            <img src="{{asset(auth()->user()->getRutaFoto())}}" class="img-circle elevation-2" alt="User Image">
          </div>
          <div class="info">
            <label for="" style="color: white">Usuario:</label>
            <u><a href="{{URL::to('home')}}">{{ auth()->user()->Persona->nombres }}</a></u>
            <br><label for="" style="color: white">{{ auth()->user()->Persona->Trabajador->Cargo['descripcion'] }}</label>
          </div>
        </div>

        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">          
            <li class="nav-header">CAJA</li>
            <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-dollar-sign"></i>
                <p>
                  Cobranza
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
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
                {{-- <li class="nav-item">
                  <a href="{{ route('recibos.create') }}" class="nav-link">
                    <i class="nav-icon fas fa-tasks"></i>
                    <p>Emitir Recibo</p>
                  </a>
                </li> --}}
              </ul>
            </li>
            <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-question-circle"></i>
                <p>
                  Consultas
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                {{-- <li class="nav-item">
                  <a href="{{route('consultas.pedidos.atendidos')}}" class="nav-link">
                    <i class="nav-icon fas fa-check-circle"></i>
                    <p>Pedidos Confirmados</p>
                  </a>
                </li> --}}
                <li class="nav-item">
                  <a href="{{route('consultas.recibos')}}" class="nav-link">
                    <i class="nav-icon fas fa-check-circle"></i>
                    <p>Recibos Emitidos</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{route('consultas.ventasdiarias')}}" class="nav-link">
                    <i class="nav-icon fas fa-dollar-sign"></i>
                    <p>Mis ventas</p>
                  </a>
                </li>
              </ul>
            </li>
           
            <li class="nav-header">CUENTA</li>
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