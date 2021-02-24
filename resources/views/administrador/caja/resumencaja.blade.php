@extends('layout.plantilla_admin')
@section('contenido')
    <br>
    <div class="container">
        <section class="content">
            <div class="container-fluid">
                <i class="fas fa-file-signature text-primary"></i>
                <font style="font-family:Arial, Helvetica, sans-serif; font-size: 16pt">
                    Resumen de caja(s)</font>
                <div class="card">
                    <div class="card-body border shadow">
                        <div class="row">
                            <div class="col-md-3 col-sm-8 col-12">
                                <label> Fecha: </label>
                                <span>{{ date('d') . ' de ' . $mes . ' del ' . date('Y') }}</span>
                            </div>
                            <div class="col-md-4 col-sm-8 col-12">
                                <label> Administrador: </label>
                                <span>{{ auth()->user()->Persona->nombres_apellidos() }}</span>
                            </div>
                            <div class="col-md-3 col-sm-8 col-12">
                                <label> Trabajadores: </label>
                                <span># {{ count($trabajadores) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body border shadow">
                        <div class="row">
                            <div class="col-md-3 col-sm-6 col-12">
                                <span>Monto inicial:</span><br>
                                <input readonly type="text" name="monto_inicial"
                                    value="{{ $suma_MI != null ? number_format($suma_MI, 2) : '0.00' }}"
                                    class="form-control text-center">
                            </div>
                        </div>
                        <div class="row pt-2">
                            <div class="col-md-3 col-sm-6 col-12">
                                <span>Ventas del día:</span><br>
                                <input readonly type="text" name="monto_dia"
                                    value="{{ $suma_VD != null ? number_format($suma_VD, 2) : '0.00' }}"
                                    class="form-control text-center">
                            </div>
                        </div>
                        <div class="row pt-2">
                            <div class="col-md-3 col-sm-6 col-12">
                                <span><strong>Total en Caja:</strong> </span><br>
                                <input readonly type="text" name="monto_cierre"
                                    value="{{ $total != null ? number_format($total, 2) : '0.00' }}"
                                    class="form-control text-center">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
