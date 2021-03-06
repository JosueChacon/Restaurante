@extends('layout.plantilla_admin')
@section('contenido')
<link rel="stylesheet" href="/css/preview-image.css">
<form action="{{route('tipoplato.store')}}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="card">
        <div class="card-header">
            <h4><strong>TIPO DE PLATO</strong></h4>
        </div>
        <div class="card-body">
            <h5 class="card-title"><u>.::Nuevo Tipo de Plato</u></h5>
            <p class="card-text">
                <div class="row">
                    <div class="col-sm-6">
                        <label for="">Descripción</label>
                        <input type="text" maxlength="50" id="descripcion" name="descripcion"
                            placeholder="Ingrese descripción" value="{{old('descripcion')}}" class="form-control"
                            required>
                    </div>
                    <div class="col-sm-6"></div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <label for="">Foto</label>
                        <input type="file" required id="foto" name="foto"
                            class="form-control @error('foto') is-invalid @enderror" style="padding: 3px">
                        @error('foto')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                        <div class="image-preview" id="imagePreview">
                            <img src="" alt="Image preview" class="image-preview__image">
                            <span class="image-preview__default-text">Vista Previa</span>
                        </div>
                    </div>
                    <div class="col-sm-6"></div>
                </div>
                <br>
                <div class="row">
                    <div class="col-sm-2">
                        <div class="form-group">
                            <a href="{{route('tipoplato.index')}}" class="btn btn-danger btn-block">
                                <i class="fas fa-arrow-left"></i> Cancelar</a>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-block">
                                <i class="fas fa-save"></i> Guardar
                            </button>
                        </div>
                    </div>
                </div>
            </p>
        </div>
    </div>
</form>
<script>
    const foto = document.getElementById("foto");
    const previewContainer = document.getElementById("imagePreview");
    const previewImage = previewContainer.querySelector(".image-preview__image");
    const previewDefaultText = previewContainer.querySelector(".image-preview__default-text");

    foto.addEventListener("change", function(){
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            previewDefaultText.style.display = "none";
            previewImage.style.display = "block";
            reader.addEventListener("load", function(){
                previewImage.setAttribute("src", this.result);
            });
            reader.readAsDataURL(file);
        }
    });
</script>
@endsection