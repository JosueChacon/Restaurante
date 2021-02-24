<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reporte Stock Actual Platos</title>
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
            <span>!! Reporte, Stock Actual de Platos !!</span>
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
        <div style="margin-top: 5pt">
            <span>Hora de programación: {{ $programacion->fecha->format('h:i a') }}</span>
        </div>                                 
        <div>
            <span>------------------------------------------------------------------------------------------------------------------------------------</span>
        </div>
        <table style="width: 100%;">
            <thead>
                <tr>
                    <th style="text-align: left">#</th>
                    <th style="text-align: left">Nommbre</th>
                    <th style="text-align: right">Precio</th>
                    <th style="text-align: right">Stock</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($programacion->DProgramacion as $key => $item)
                    <tr>
                        <th style="text-align: left">{{ $key+1 }}</th>
                        <td style="text-align: left">{{ $item->Plato->nombre }}</td>                        
                        <td style="text-align: right">{{ number_format($item->Plato->p_venta, 2) }}</td>
                        <td style="text-align: right">{{ $item->stock }}</td>
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
                    <th style="text-align: left">TOTAL STOCK:</th>
                    <th style="text-align: right">{{ $total_platos }}</th>
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
