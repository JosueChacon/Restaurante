<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Restaurant en Línea - Registro</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/adminlte/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="/adminlte/dist/css/adminlte.min.css">
    <link rel="icon" type="image/png" href="/img/icon/registro.svg" />
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

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
</head>

<body>
    <div class="limiter">
        <div class="container-login100" style="background-image: url('/logindoc/images/bg-02.jpg');">
            <form method="POST" action="{{ route('Registro') }}">
                @csrf
                <div class="container">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title"><u>¿Sus datos personales?</u></h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <label>Nombres</label>
                                    <input class="form-control" id=" nombres" name="nombres" type="text"
                                        placeholder="¿Nombres?" value="{{ old('nombres') }}" required maxlength="50">
                                </div>
                                <div class="col-sm-6">
                                    <label>Apellidos</label>
                                    <input class="form-control " id="apellidos" name="apellidos" type="text"
                                        placeholder="¿Apellidos?" value="{{ old('apellidos') }}" required
                                        maxlength="50">
                                </div>
                                <div class="col-sm-2"></div>
                                <div class="col-sm-2"></div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <label>Dirección</label>
                                    <input class="form-control" id="direccion" name="direccion" type="text"
                                        placeholder="¿Dirección?" value="{{ old('direccion') }}" required
                                        maxlength="150">
                                </div>
                                <div class="col-sm-6">
                                    <label>Teléfono</label>
                                    <input class="form-control " id="celular" name="celular" type="text"
                                        placeholder="¿Teléfono?" value="{{ old('celular') }}" required maxlength="9"
                                        onkeypress='return event.charCode >= 48 && event.charCode <= 57'>
                                </div>
                            </div>
                        </div>
                        <div class="card-header">
                            <h3 class="card-title"><u>¿Sus datos de usuario?</u></h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <label>Usuario</label>
                                    <input class="form-control @error('name') is-invalid @enderror" id="name"
                                        name="name" type="text" placeholder="¿Usuario?" value="{{ old('name') }}"
                                        required maxlength="255">
                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <label>Contraseña</label>
                                    <input class="form-control @error('password') is-invalid @enderror" id="password"
                                        name="password" type="password" placeholder="¿Contraseña?"
                                        value="{{ old('password') }}" required maxlength="255">
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Repita Contraseña</label>
                                        <input class="form-control" id="password_confirmation"
                                            name="password_confirmation" type="password" placeholder="Repita contraseña"
                                            required maxlength="255">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-sm-6 col-6">
                                    <div class="text-left">
                                        <a href="{{route('login')}}" class="form-control btn btn-danger"><i
                                                class="fas fa-arrow-left"></i>
                                            Volver</a>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-6">
                                    <div class="text-left">
                                        <button type="submit" class="form-control btn btn-info"><i
                                                class="fas fa-check-circle"></i>
                                            Registrar
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script src="/adminlte/plugins/jquery/jquery.min.js"></script>
    <script src="/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="/adminlte/dist/js/adminlte.min.js"></script>
    <script src="/adminlte/dist/js/demo.js"></script>
</body>

</html>