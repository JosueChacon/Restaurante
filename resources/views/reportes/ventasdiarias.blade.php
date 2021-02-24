<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reporte de ventas diarias</title>
    <style type="text/css">
        .encabezado {
            text-align: center;
            font-size: 16pt;
            font-family: 'Courier New', Courier, monospace
        }

        .interlineado {
            margin-top: -10pt;
        }

        .fuente {
            font-family: 'Courier New', Courier, monospace;
            font-size: 12pt;
            color: black;
        }

        .fuente-tabla {
            font-family: 'Courier New', Courier, monospace;
            font-size: 10pt;
        }

    </style>
    <link rel="stylesheet" href="css/bootstrap.min.css">

</head>

<body>
    <div class="container-fluid">
        <p class="encabezado">Reportes de ventas diarias</p>
        <div class="fuente">
            <p><strong>Fecha de reporte:</strong> {{ date('d/m/Y') }}</p>
            <p class="interlineado"><strong>Hora de reporte:</strong> {{ date('h:i a') }}</p>
            <p class="interlineado">
                <strong>Usuario:</strong>{{ auth()->user()->Persona->nombres_apellidos() }}
            </p>
            <p class="interlineado"><strong>Cantidad Recibos:</strong>{{ count($recibos_x_t) }}</p>

        </div>
        <div class="fuente">
            <p>.::Recibos</p>
        </div>
        <table class="table table-striped interlineado">
            <thead style="background-color: blue;">
                <tr class="fuente-tabla" style="color: white">
                    <th style="width: 0.3cm">#</th>
                    <th style="width: 2cm">Nº Recibo</th>
                    <th style="width: 0.9cm">Hora</th>
                    <th style="width: 4.5cm">Cliente</th>
                    <th class="text-right">Efectivo</th>
                    <th class="text-right">Tarjeta</th>
                    <th class="text-right" style="width: 0.5cm">Total</th>
                </tr>
            </thead>
            <tbody class="fuente-tabla">
                @foreach ($recibos_x_t as $key => $fila)
                    <tr>
                        <th scope="row">{{ $key + 1 }}</th>
                        <td>{{ $fila->nrorecibo }}</td>
                        <td>{{ $fila->fecha->format('h:ia') }}</td>
                        <td>{{ $fila->Cliente->nombrecompleto($fila->Cliente) }}</td>
                        <td class="text-right">{{ number_format($fila->efectivo, 2) }}</td>
                        <td class="text-right">{{ number_format($fila->tarjeta, 2) }}</td>
                        <td class="text-right">{{ number_format($fila->total, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="fuente-tabla">
            <p style="font-size: 14pt"><strong>Total efectivo: S/. {{ number_format($efectivo, 2) }}</strong></p>
            <p style="font-size: 14pt"><strong>Total tarjeta: S/. {{ number_format($tarjeta, 2) }}</strong></p>
            <p style="font-size: 14pt"><strong>Total Ventas: S/. {{ number_format($total, 2) }}</strong></p>
        </div>
    </div>
</body>

</html>
