<div class="modal fade" id="modalConfirmar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    <i class="fas fa-spinner text-primary"></i>
                    Esperando confirmación...
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <span>*</span>
                <span id="msj">Ingrese su clave:</span>
                <div class="row">
                    <div class="col-md-6">
                        <input type="password" name="clave" id="clave" maxlength="50" placeholder="******"
                            class="form-control">
                    </div>
                    <div class="col-md-6">
                        <button type="button" onclick="confirmarClave()" class="btn btn-primary"><i
                                class="fas fa-check"></i> Registrar pedido</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>