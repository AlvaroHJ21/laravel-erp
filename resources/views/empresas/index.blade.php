@extends('adminlte::page')

@section('title', 'Empresas')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h1>Empresas</h1>
        <a href="{{ route('empresas.create') }}" class="btn btn-primary">Crear</a>
    </div>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="table-empresas" class="table table-hover my-0">
                    <thead>
                        <tr>
                            <th>N.</th>
                            <th>Razon Social</th>
                            <th>Nombre Comercial</th>
                            <th>Ruc</th>
                            <th>Direccion</th>
                            <th>Modo</th>
                            @if (Auth::user()->rol == 1)
                                <th>Acciones</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($empresas as $empresa)
                            <tr>
                                <td>{{ $empresa['id'] }}</td>
                                <td>{{ $empresa['razon_social'] }}</td>
                                <td>{{ $empresa['nombre_comercial'] }}</td>
                                <td>{{ $empresa['ruc'] }}</td>
                                <td>{{ $empresa['domicilio_fiscal'] }}</td>
                                <td>
                                    <form action="{{ route('empresas.toggle_mode', $empresa) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <button
                                            class="btn btn-sm {{ $empresa['modo'] == '1' ? 'btn-success' : 'btn-secondary' }}">
                                            {{ $empresa['modo'] == '1' ? 'Producción' : 'Prueba' }}
                                        </button>
                                    </form>
                                </td>
                                @if (Auth::user()->rol == 1)
                                    <td>
                                        <a href="{{ route('empresas.edit', $empresa) }}"
                                            class="btn btn-outline-secondary btn-sm" type="button">
                                            <i class="fa fa-edit"></i>
                                        </a>

                                        <form id="form-delete-{{ $empresa['id'] }}"
                                            action="{{ route('empresas.destroy', $empresa) }}" class="d-inline"
                                            method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-outline-danger btn-sm"
                                                onclick="confirmDelete({{ $empresa['id'] }})">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>

                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@stop

@section('css')
    @vite('resources/js/app.js')
@stop

@section('js')

    <script>
        function confirmDelete(id) {
            Swal.fire({
                    title: "¿Estás seguro?",
                    text: "Una vez eliminada, no podrás recuperar este registro.",
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar',
                })
                .then((response) => {
                    if (response.value) {
                        document.getElementById(`form-delete-${id}`).submit();
                    }
                });
        }
    </script>
@stop
