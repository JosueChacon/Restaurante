<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reporte de Ventas Diarias</title>
    <style>
        .tipo-letra {
            font-size: 9pt;
            font-family: Arial, Helvetica, sans-serif;
            color: black;
        }

    </style>
</head>

<body>
    <div style="width: 100%; margin-left: -9mm; margin-right: -9mm; margin-top: -5mm" class="tipo-letra">
        <div style="text-align: center; font-size: 12pt">
            <span>***** Restaurant *****</span>
        </div>
        <div style="text-align: center; font-size: 12pt">
            <span>Ruc: 00000000000</span>
        </div>
        <div style="text-align: center; font-size: 10pt; margin-top: 10pt">
            <span>!! Reporte de Ventas Diarias !!</span>
        </div>
        <div style="margin-top: 10pt">
            <span>Responsable: {{ auth()->user()->Persona->nombres_apellidos() }}</span>
        </div>
        <div style="margin-top: 5pt">
            <span>Fecha reporte: {{ date('d-m-Y') }}&nbsp;&nbsp;&nbsp;&nbsp;</span>
        </div>
        <div style="margin-top: 5pt">
            <span>Hora reporte: {{ date('h:i a') }}</span>
        </div>
        {{-- <div style="margin-top: 5pt">
            <span>Hora de programación: {{ $programacion->fecha->format('d/m/Y  h:i a') }}</span>
        </div> --}}
        <div>
            <span>----------------------------------------------------------------</span>
        </div>
        <table style="width: 100%;">
            <thead>
                <tr>
                    <th style="text-align: left">#</th>
                    <th style="text-align: left">Recibo</th>
                    <th style="text-align: left">Hora</th>
                    <th style="text-align: left">Cajero</th>
                    <th style="text-align: left">Cliente</th>
                    <th style="text-align: right">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($recibos_x_t as $key => $fila)
                    <tr>
                        <th style="text-align: left">{{ $key + 1 }}</th>
                        <td style="text-align: left">{{ $fila->nrorecibo }}</td>
                        <td style="text-align: left">{{ $fila->fecha->format('h:ia') }}</td>
                        <td style="text-align: left">{{ $fila->Trabajador->Persona->nombres_apellidos() }}</td>
                        <td style="text-align: left">{{ $fila->Cliente->Persona->nombres_apellidos() }}</td>
                        <td class="text-right">{{ number_format($fila->total, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div>
            <span>----------------------------------------------------------------</span>
        </div>
        <table style="width: 100%">
            <thead>
                <tr>
                    <th style="text-align: left">TOTAL:</th>
                    <th style="text-align: right">S/. {{ number_format($total, 2) }}</th>
                </tr>
            </thead>
        </table>
        <br><br>
        <div style="margin-top: 5pt; text-align: center">
            <span>!!! REPORTE IMPRESO !!!</span>
        </div>
        <div style="text-align: center">
            <span>!!! GRACIAS POR SU CONFIANZA !!!</span>
        </div>
    </div>


</body>

</html>
