@extends('layout.plantilla_admin')
@section('estilos')
    <link rel="stylesheet" href="/js/datatables/jquery.dataTables.min.css">
@endsection
@section('contenido')
    <i class="fas fa-people-carry text-primary"></i>
    <font style="font-family:Arial, Helvetica, sans-serif; font-size: 16pt">
        Mi Gente
    </font>
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-12">
                    <a class="form-control btn btn-primary" href="{{ route('MiGente.create') }}"><i
                            class="fas fa-plus-square"></i> Agregar Personal</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            @if (session('good'))
                <div class="alert alert-success alert-dissmissible fade show mt-3" role="alert">
                    {{ session('good') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span
                            aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger alert-dissmissible fade show mt-3" role="alert">
                    {{ session('error') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="tblTrabajador">
                            <thead class="table-dark">
                                <tr>
                                    <th>Dni</th>
                                    <th>Trabajador</th>
                                    <th>Teléfono</th>
                                    <th>Dirección</th>
                                    <th>E-mail</th>
                                    <th>Cargo</th>
                                    <th>Usuario</th>
                                    <th class="text-center">Acción</th>
                                </tr>
                            </thead>
                            <tbody style="font-size: 10.5pt">
                                @foreach ($trabajadores as $row)
                                    <tr>
                                        <td>{{ $row->Persona->dni }}</td>
                                        <td>{{ $row->Persona->nombres_apellidos() }}</td>
                                        <td>{{ $row->Persona->celular }}</td>
                                        <td>{{ $row->Persona->direccion }}</td>
                                        <td>{{ $row->Persona->email }}</td>
                                        <td>{{ $row->Cargo->descripcion }}</td>
                                        <td>{{ $row->Persona->User->name }}</td>
                                        <td class="text-center">
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-secondary dropdown-toggle"
                                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fas fa-tasks"></i>
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item"
                                                        href="{{ route('MiGente.edit', $row->idtrabajador) }}"><i
                                                            class="fas fa-edit text-info"></i> Editar</a>
                                                    <a class="dropdown-item"
                                                        href="{{ route('foto', $row->idtrabajador) }}"><i
                                                            class="fas fa-image text-success"></i> Foto</a>
                                                    <div class="dropdown-divider"></div>
                                                    <a class="dropdown-item" href="javascript:;"
                                                        onclick="eliminar('{{ $row->idtrabajador }}')"><i
                                                            class="fas fa-trash text-danger"></i> Eliminar</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('utilitarios.modalConfirmar')
@endsection
@section('script')
    <script src="/js/datatables/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#tblTrabajador').DataTable({
                language: {
                    "url": "/js/datatables/Spanish.json",
                },
            })
        });

        var idtrabajador = 0

        function eliminar(idtrabajador) {
            this.idtrabajador = idtrabajador
            $('#modalConfirmar').modal('show')
        }

        function aceptar() {
            $.ajax({
                type: "DELETE",
                url: RUTA_API + 'trabajadores/MiGente/' + idtrabajador,
                dataType: "JSON",
                success: function(data) {
                    if (data.rpta == 'ok') {
                        $(location).prop('href', RUTA_API + 'trabajadores/MiGente')
                    } else {
                        alert('Error al eliminar trabajador.')
                    }
                },
                error: function(error) {
                    console.log(error);
                },
            });
        }

    </script>
@endsection
