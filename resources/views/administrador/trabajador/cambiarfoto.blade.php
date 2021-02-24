@extends('layout.plantilla_admin')
@section('estilos')
    <link rel="stylesheet" href="/css/preview-image.css">
@endsection
@section('contenido')
    <i class="fas fa-image text-primary"></i>
    <font style="font-family:Arial, Helvetica, sans-serif; font-size: 16pt">
        Foto de {{ $trabajador->Persona->nombres_apellidos() }}</font>
    <form method="POST" action="{{ route('foto', $trabajador->idtrabajador) }}" enctype="multipart/form-data">
        @csrf
        <div class="card">
            <div class="card-body border shadow">
                <div class="row">
                    <div class="col-md-12">
                        <img src="{{ asset($trabajador->Persona->User->getRutaFoto()) }}" width="150"
                            class="img-fluid img-thumbnail" alt="Responsive image">
                    </div>
                </div>
                <div class="row pt-2">
                    <div class="col-md-6">
                        <label>¿Cambiar imagen?</label>
                        <input class="form-control @error('foto') is-invalid @enderror" id="foto" name="foto" type="file"
                            accept="image/*" required style="padding: 3px" value="{{ old('foto') }}">
                        @error('foto')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <div class="image-preview img-responsive" id="imagePreview">
                            <img src="/img/img.png" alt="Image preview" class="image-preview__image">
                            <span class="image-preview__default-text">Vista Previa</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row pt-2">
            <div class="col-sm-2">
                <a href="{{ route('MiGente.index') }}" class="form-control btn btn-danger"><i
                        class="fas fa-arrow-left"></i>
                    Cancelar</a>
            </div>
            <div class="col-sm-2">
                <button type="submit" id="grabar" class="form-control btn btn-primary"><i class="fas fa-save"></i>
                    Cambiar Foto
                </button>
            </div>
        </div>
        <br>
    </form>
@endsection
@section('script')
    <script>
        const foto = document.getElementById("foto");
        const previewContainer = document.getElementById("imagePreview");
        const previewImage = previewContainer.querySelector(".image-preview__image");
        const previewDefaultText = previewContainer.querySelector(".image-preview__default-text");

        foto.addEventListener("change", function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                previewDefaultText.style.display = "none";
                previewImage.style.display = "block";
                reader.addEventListener("load", function() {
                    previewImage.setAttribute("src", this.result);
                });
                reader.readAsDataURL(file);
            }
        });

    </script>
@endsection
