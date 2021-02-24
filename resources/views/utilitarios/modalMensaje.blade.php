{{-- data-backdrop="static" data-keyboard="false" --}}
<div class="modal fade" id="modalError" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">
                    <i class="fas fa-times-circle text-danger"></i>
                    <font style="font-family:Arial, Helvetica, sans-serif; font-size: 14pt">
                        Error
                    </font>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <span id="modalContenido"></span>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">
                    <i class="fas fa-check"></i> Ok
                </button>
            </div>
        </div>
    </div>
</div>
