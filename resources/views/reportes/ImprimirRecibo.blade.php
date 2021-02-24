<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Recibo Nº {{ $recibo->nrorecibo }}</title>
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
            <span>RECIBO</span>
        </div>    
        <div style="margin-top: 10pt">
            <span>Nº Recibo: {{ $recibo->nrorecibo }}</span>
        </div>
        <div style="margin-top: 5pt">
            <span>Fecha: {{ $recibo->fecha->format('d/m/Y') }}&nbsp;&nbsp;&nbsp;&nbsp;</span>
            <span>Hora: {{ $recibo->fecha->format('h:i a') }}</span>
        </div>
        <div style="margin-top: 5pt">
            <span>Cajero: {{ $recibo->Trabajador->Persona->nombres_apellidos() }}</span>
        </div>  
        <div style="margin-top: 5pt">
            <span>Cliente: {{ $recibo->Cliente->nombrecompleto($recibo->Cliente) }}</span>
        </div>              
        <div style="margin-top: 5pt;">
            <span>Lugar: MESA {{ $recibo->DRecibo[0]->Pedido->Reserva->Mesa->nromesa }}</span>
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
                @foreach ($recibo->DRecibo as $item)
                    @foreach ($item->Pedido->DPedido as $key => $fila)
                        <tr>
                            <th style="text-align: left">{{ $key+1 }}</th>
                            <td style="text-align: left">{{ $fila->cantidad }}</td>
                            <td style="text-align: left">{{ $fila->Plato_Prod->nombre }}</td>
                            <td style="text-align: right">{{ number_format($fila->p_venta, 2) }}</td>                            
                            <td style="text-align: right">{{ number_format($fila->p_venta * $fila->cantidad, 2) }}</td>
                        </tr>
                    @endforeach
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
                    <th style="text-align: right">S/. {{ number_format($recibo->total, 2) }}</th>
                </tr>
            </thead>
        </table>
        <br><br><br><br>
        <div style="margin-top: 5pt; text-align: center">
            <span>!!! RECIBO IMPRESO !!!</span>
        </div>
        <div style="text-align: center">
            <span>!!! GRACIAS POR SU CONFIANZA !!!</span>
        </div>
    </div>


</body>

</html>
