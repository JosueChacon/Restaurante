<!DOCTYPE html>
<html lang="es">

<head>
    <title>Restaurant en Línea</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="/img/icon/panadero.svg" />
    <link rel="stylesheet" type="text/css" href="/logindoc/vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="/logindoc/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="/logindoc/fonts/iconic/css/material-design-iconic-font.min.css">
    <link rel="stylesheet" type="text/css" href="/logindoc/vendor/animate/animate.css">
    <link rel="stylesheet" type="text/css" href="/logindoc/vendor/css-hamburgers/hamburgers.min.css">
    <link rel="stylesheet" type="text/css" href="/logindoc/vendor/animsition/css/animsition.min.css">
    <link rel="stylesheet" type="text/css" href="/logindoc/vendor/select2/select2.min.css">
    <link rel="stylesheet" type="text/css" href="/logindoc/vendor/daterangepicker/daterangepicker.css">
    <link rel="stylesheet" type="text/css" href="/logindoc/css/util.css">
    <link rel="stylesheet" type="text/css" href="/logindoc/css/main.css">
    <link rel="stylesheet" href="/adminlte/plugins/fontawesome-free/css/all.min.css">
</head>

<body>
    <div class="limiter">
        <div class="container-login100" style="background-image: url('/logindoc/images/bg-02.jpg');">
            <div class="wrap-login100">
                <form method="POST" action="{{ route('login') }}" class="login100-form">
                    @csrf
                    <span class="login100-form-logo">
                        <img src="/img/icon/comida.svg" alt="">
                    </span>

                    <span class="login100-form-title p-b-34 p-t-27">
                        Iniciar Sesión
                    </span>

                    <div class="form-group">
                        <input class="form-control @error('name') is-invalid @enderror" type="text"
                            placeholder="Ingrese Usuario" maxlength="255" id="name" name="name"
                            value="{{ old('name') }}" required>

                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <input class="form-control @error('password') is-invalid @enderror" type="password" id="pass"
                            name="password" placeholder="Ingrese Contraseña" maxlength="255" value="{{ old('pass') }}"
                            required>

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="container-login100-form-btn">
                        <button class="login100-form-btn" type="submit">
                            Ingresar
                        </button>
                    </div>

                    <div class="text-center p-t-50">
                        {{-- <a class="txt1" href="{{URL::to('/Registro')}}">
                              ¿Nueva cuenta?  
                            Bienvenido
                        </a> --}}
                        <span class="txt1">Bienvenido</span>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="/logindoc/vendor/jquery/jquery-3.2.1.min.js"></script>
    <script src="/logindoc/vendor/animsition/js/animsition.min.js"></script>
    <script src="/logindoc/vendor/bootstrap/js/popper.js"></script>
    <script src="/logindoc/vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="/logindoc/vendor/select2/select2.min.js"></script>
    <script src="/logindoc/vendor/daterangepicker/moment.min.js"></script>
    <script src="/logindoc/vendor/daterangepicker/daterangepicker.js"></script>
    <script src="/logindoc/vendor/countdowntime/countdowntime.js"></script>
    <script src="/logindoc/js/main.js"></script>

</body>

</html>
