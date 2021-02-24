{{-- data-backdrop="static" data-keyboard="false" --}}
<div class="modal fade" id="modalConfirmar" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">
                    <i class="fas fa-spinner text-secondary"></i>
                    <font style="font-family:Arial, Helvetica, sans-serif; font-size: 14pt">
                        Esperando confirmación...
                    </font>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <span>El registro seleccionado será eliminado. ¿Desea continuar?</span>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">
                    <i class="fas fa-times"></i> Cancelar
                </button>
                <button type="button" class="btn btn-primary btn-sm" onclick="aceptar()">
                    <i class="fas fa-check"></i> Aceptar
                </button>
            </div>
        </div>
    </div>
</div>
