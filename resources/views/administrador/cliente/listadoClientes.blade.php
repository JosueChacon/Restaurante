@extends('layout.plantilla_admin')
@section('contenido')
    <i class="fas fa-list text-primary"></i>
    <font style="font-family:Arial, Helvetica, sans-serif; font-size: 16pt">
        Clientes
    </font>
    <div class="card">
        <div class="card-body border shadow">
            @if (session('datos'))
                <div class="alert alert-warning alert-dissmissible fade show mt-3" role="alert">
                    {{ session('datos') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            <form>
                <div class="row">
                    <div class="col-sm-6 col-8">
                        <input name="buscarpor" class="form-control" type="search" placeholder="Buscar por apellidos"
                            aria-label="Search" value="{{ $buscarpor }}">
                    </div>
                    <div class="col-sm-4 col-4">
                        <button class="btn btn-success" type="submit"><i class="fas fa-search"></i>
                            Buscar</button>
                    </div>
                </div>
            </form>
            <div class="row pt-2">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Dni</th>
                                    <th scope="col">Nombres</th>
                                    <th scope="col">Apellidos</th>
                                    <th scope="col">Dirección</th>
                                    <th scope="col">Celular</th>
                                    {{-- <th scope="col" class="text-center">Acción</th> --}}
                                </tr>
                            </thead>
                            <tbody style="font-size: 11pt">
                                @foreach ($clientes as $key => $item)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $item->Persona->dni }}</td>
                                        <td>{{ $item->Persona->nombres }}</td>
                                        <td>{{ $item->Persona->apellidos }}</td>
                                        <td>{{ $item->Persona->direccion }}</td>
                                        <td>{{ $item->Persona->celular }}</td>
                                        {{-- <td class="text-center">                                            
                                            <a href="{{ route('consultas.clientes.pedidos', $item->idcliente) }}"
                                                class="btn btn-sm btn-primary"><i class="fas fa-list-alt"></i> Pedidos</a>
                                        </td> --}}
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $clientes->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
@endsection
