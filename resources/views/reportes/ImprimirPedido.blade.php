<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Pedido Nº {{ $pedido->formato($pedido->idpedido) }}</title>
    <style>
        .tipo-letra {
            font-size: 9pt;
            font-family: Arial, Helvetica, sans-serif;
            color: black;
        }
    </style>
</head>

<body>
    {{-- margin-left: -10mm; margin-right: -10mm; margin-top: -5mm --}}
    <div style="width: 100%; margin-left: -10mm; margin-right: -10mm; margin-top: -5mm" class="tipo-letra">
        <div style="text-align: center; font-size: 12pt">
            <span>***** Restaurant *****</span>
        </div>
        <div style="text-align: center; font-size: 12pt">
            <span>Ruc: 00000000000</span>
        </div>
        <div style="text-align: center; font-size: 10pt; margin-top: 10pt">
            <span>PEDIDO</span>
        </div>    
        <div style="margin-top: 10pt">
            <span>Nº Pedido: {{ $pedido->formato($pedido->idpedido) }}</span>
        </div>
        <div style="margin-top: 5pt">
            <span>Fecha: {{ $pedido->fecha->format('d-m-Y') }}&nbsp;&nbsp;&nbsp;&nbsp;</span>
            <span>Hora: {{ $pedido->fecha->format('h:i a') }}</span>
        </div>
        <div style="margin-top: 5pt">
            <span>Mesero: {{ $pedido->Trabajador->Persona->nombres_apellidos() }}</span>
        </div>        
        <div style="margin-top: 5pt">
            <span>Estado: {{ $pedido->estado }}</span>
        </div>
        <div style="margin-top: 5pt;">
            <span>Cliente de: MESA {{ $pedido->Reserva->Mesa->nromesa }}</span>
        </div>
        <div>
            <span>------------------------------------------------------------------------------------------------------------------------------------</span>
        </div>
        <table style="width: 100%;">
            <thead>
                <tr>
                    <th style="text-align: left">#</th>
                    <th style="text-align: left">Cant</th>
                    <th style="text-align: left">Descripción</th>
                    <th style="text-align: right">Precio</th>
                    <th style="text-align: right">Importe</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pedido->DPedido as $i => $item)
                    <tr>
                        <td style="text-align: left">{{ $i + 1 }}</td>
                        <td style="text-align: left">{{ $item->cantidad }}</td>
                        <td style="text-align: left">{{ $item->Plato_Prod->nombre }}</td>
                        <td style="text-align: right">{{ number_format($item->p_venta, 2) }}</td>
                        <td style="text-align: right">{{ number_format($item->p_venta * $item->cantidad, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div>
            <span>------------------------------------------------------------------------------------------------------------------------------------</span>
        </div>
        <table style="width: 100%">
            <thead>
                <tr>
                    <th style="text-align: left">TOTAL:</th>
                    <th style="text-align: right">S/. {{ number_format($pedido->Total($pedido->DPedido), 2) }}</th>
                </tr>
            </thead>
        </table>
        <br><br><br><br>
        <div style="margin-top: 5pt; text-align: center">
            <span>!!! PEDIDO IMPRESO !!!</span>
        </div>
        <div style="text-align: center">
            <span>!!! GRACIAS POR SU CONFIANZA !!!</span>
        </div>
    </div>


</body>

</html>
