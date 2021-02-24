@extends('layout.plantilla_admin')
@section('estilos')

@endsection
@section('contenido')
<br>
<div class="card">
    <div class="card-header">
        <u>
            <font style="font-family: times new roman; font-size: 18pt"><em>Cambiar clave de personal</em></font>
        </u>
    </div>
    <div class="card-body">
        @if (session('good'))
        <div class="alert alert-success alert-dissmissible fade show mt-3" role="alert">
            {{session('good')}}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span
                    aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif
        @if (session('error'))
        <div class="alert alert-danger alert-dissmissible fade show mt-3" role="alert">
            {{session('error')}}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif
        <div class="table-responsive pt-2">
            <table class="table table-striped table-bordered" id="tbl_trabajadores">
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Trabajador</th>
                        <th>Dirección</th>
                        <th>Celular</th>
                        <th>Usuario</th>
                        <th>Cargo</th>
                        <th class="text-center">¿Cambiar clave?</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($trabajadores as $item)
                    <tr>
                        <td>{{$item->idtrabajador}}</td>
                        <td>{{$item->Persona->nombrecompleto($item->Persona)}}</td>
                        <td>{{$item->Persona->direccion}}</td>
                        <td>{{$item->Persona->celular}}</td>
                        <td>{{$item->Persona->User->name}}</td>
                        <td>{{$item->Cargo->descripcion}}</td>
                        <td class="text-center">
                            <button id="btncambiar" name="btncambiar"
                                onclick="abrir_modal('{{$item->Persona->User->id}}', '{{$item->Persona->nombrecompleto($item->Persona)}}','{{$item->Persona->User->name}}')"
                                data-toggle="modal" data-target="#staticBackdrop" class="btn btn-sm btn-warning"><i
                                    class="fas fa-edit"></i>
                                Cambiar
                                Clave</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                </tfoot>
            </table>
            {{$trabajadores->links()}}
        </div>
    </div>
</div>
<div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Nueva Clave</h5>
            </div>
            <form action="{{route('ClavePersonal')}}" id="frmCambios" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <label for="">Trabajador: </label>
                            <input type="text" name="id" id="id" hidden>
                            <input type="text" disabled id="trabajador" name="trabajador" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <label for="">Usuario: </label>
                            <input type="text" disabled id="usuario" name="usuario" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <label for="">Nueva Clave: </label>
                            <input type="text" required id="clave" name="clave" placeholder="Ingrese nueva clave"
                                class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <label for="">Repita Clave: </label>
                            <input type="text" required id="r_clave" placeholder="Repita la clave" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <label for="">Clave de Administrador: </label>
                            <input type="password" required id="clave_admin" name="clave_admin"
                                placeholder="Ingrese clave de administrador" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" onclick="limpiar()" class="btn btn-secondary"
                        data-dismiss="modal">Cerrar</button>
                    <button type="button" id="guardarcambios" onclick="verificarControles()" name="guardarcambios"
                        class="btn btn-primary">Guardar
                        Cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('script')
<script type="text/javascript">
    function abrir_modal(id, trabajador, usuario){
        $('#id').val(id);
        $('#trabajador').val(trabajador);
        $('#usuario').val(usuario);
    }

    function limpiar(){
        $('#clave').val("");
        $('#r_clave').val("");
        $('#clave_admin').val("");
    }

    function verificarControles(){
        clave=$('#clave').val();
        r_clave=$('#r_clave').val();
        clave_admin=$('#clave_admin').val();

        if (clave.trim().length < 8){
            alert('La clave debe contener almenos 8 dígitos');
            return;
        }

        if (r_clave.trim() == ''){
            alert('Repita la clave');
            return;
        }
            
        if (clave!=r_clave){
            alert('Las claves no coinciden');
            return;
        }
        
        if (clave_admin.trim() == ''){
            alert('Ingrese clave de administrador');
            return;
        }

        document.forms['frmCambios'].submit();
    }
</script>
@endsection