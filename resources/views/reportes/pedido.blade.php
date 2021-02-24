<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pedido Nº {{$pedido->formato($pedido->idpedido)}}</title>
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
        <p class="encabezado">Nota de pedido</p>
        <div class="fuente">
            <p><strong>Nº Pedido:</strong> {{$pedido->formato($pedido->idpedido)}}</p>
            <p class="interlineado"><strong>Fecha y Hora:</strong> {{$pedido->fecha->format('d/m/Y  h:i a')}}</p>
            <p class="interlineado"><strong>Cliente:</strong> {{$pedido->Cliente->nombrecompleto($pedido->Cliente)}}</p>
            <p class="interlineado"><strong>Dirección:</strong> {{$pedido->Cliente->Persona->direccion}}</p>
            <p class="interlineado"><strong>Celular:</strong> {{$pedido->Cliente->Persona->celular}}</p>
            <p class="interlineado"><strong>Estado:</strong> Pedido {{$pedido->estado}}</p>
        </div>
        <div class="fuente">
            <p>.::Detalles de pedido</p>
        </div>
        <table class="table table-striped interlineado">
            <thead style="background-color: blue;">
                <tr class="fuente-tabla" style="color: white">
                    <th style="width: 0.3cm">#</th>
                    <th style="width: 3.8cm">Nombre</th>
                    <th style="width: 3.8cm">Tipo/Cat</th>
                    <th class="text-right" style="width: 3cm">P. Unitario</th>
                    <th class="text-right" style="width: 2cm">Cantidad</th>
                    <th class="text-right">Subtotal</th>
                </tr>
            </thead>
            <tbody class="fuente-tabla">
                @foreach ($pedido->DPedido as $key=>$fila)
                <tr>
                    <th scope="row">{{$cont++}}</th>
                    <td>{{$fila->Plato_Prod->nombre}}</td>
                    <td>{{$fila->TipoCat()}}</td>
                    <td class="text-right">S/. &nbsp;{{$fila->p_venta}}</td>
                    <td class="text-right">{{$fila->cantidad}}</td>
                    <td class="text-right">S/. &nbsp;{{$fila->p_venta*$fila->cantidad}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="fuente-tabla">
            <div class="float-right">
                <p><strong>Total: S/. {{$pedido->Total($pedido->DPedido)}}</strong></p>
            </div>
        </div>
    </div>
</body>

</html>