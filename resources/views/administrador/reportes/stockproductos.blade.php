<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reporte Productos</title>
    <style type="text/css">
        .encabezado {
            text-align: center;
            font-size: 16pt;
            font-family: Arial, Helvetica, sans-serif;
        }

        .interlineado {
            margin-top: -10pt;
        }

        .fuente {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12pt;
            color: black;
        }

        .fuente-tabla {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 10pt;
        }

    </style>
    <link rel="stylesheet" href="css/bootstrap.min.css">

</head>

<body>
    <div class="container-fluid">
        <p class="encabezado">Reporte, Stock Actual de Productos</p>
        <div class="fuente">
            <p><strong>Responsable:</strong> {{ auth()->user()->Persona->nombres_apellidos() }}</p>
            <p class="interlineado"><strong>Fecha reporte:</strong> {{ date('d-m-Y') }}</p>
            <p class="interlineado"><strong>Hora reporte:</strong> {{ date('h:i a') }}</p>
        </div>
        <div class="fuente">
            <p>.::Productos</p>
        </div>
        <table class="table table-striped interlineado">
            <thead style="background-color: blue;">
                <tr class="fuente-tabla" style="color: white">
                    <th style="width: 0.3cm">#</th>
                    <th style="width: 5cm">Nombre</th>
                    <th style="width: 2cm">Categoría</th>
                    <th class="text-right" style="width: 3cm">P. Costo S/.</th>
                    <th class="text-right" style="width: 2cm">P. Venta S/.</th>
                    <th class="text-right">Stock</th>
                </tr>
            </thead>
            <tbody class="fuente-tabla">
                @foreach ($productos as $key => $item)
                    <tr>
                        <th scope="row">{{ $key+1 }}</th>
                        <td>{{ $item->nombre }}</td>
                        <td>{{ $item->Categoria->descripcion }}</td>
                        <td class="text-right">{{ $item->p_costo }}</td>
                        <td class="text-right">{{ $item->p_venta }}</td>
                        <td class="text-right">{{ $item->stock }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="fuente-tabla">
            <div class="float-right">
                {{-- <p><strong>Total: S/. {{ $recibo->total }}</strong></p> --}}
            </div>
        </div>
    </div>
</body>

</html>
