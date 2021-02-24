@extends($plantilla)

@section('contenido')
<link rel="stylesheet" href="/css/preview-image.css">
<br>
<div class="card">
    <div class="card-header">
        Actualizar foto de perfil
    </div>
    <div class="card-body">
        <p class="card-title">
            <form method="POST" action="{{route('cambiarfoto')}}" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-sm-6">
                        <label>¿Cambiar imagen?</label>
                        <input class="form-control @error('foto') is-invalid @enderror" id="foto" name="foto"
                            type="file" accept="image/*" required style="padding: 3px" value="{{ old('foto') }}">
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
                </div>
                <div class="row">
                    <div class="col-sm-12">&nbsp;</div>
                    <div class="col-sm-6">
                        <button type="submit" class="btn btn-primary btn-sm">Cambiar Foto</button>
                    </div>
                </div>
            </form>
        </p>
    </div>
</div>
@endsection
@section('script')
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