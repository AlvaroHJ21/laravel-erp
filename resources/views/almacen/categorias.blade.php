@extends('layouts.app')

@section('title', 'Categorias')

@section('content_header')
    <h1>Categorias</h1>
@stop

@section('content')

    <div class="row">
        <div class="col-12 d-flex">
            <div class="card flex-fill">
                <div class="card-header d-flex justify-content-between">
                    <h5 class="card-title mb-0">
                        Categorías
                    </h5>
                    <button class="btn btn-primary btn-sm btnAdd" data-bs-toggle="modal"
                        data-bs-target="#formUserModal">Nuevo</button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover my-0" id="tabla">
                            <thead>
                                <tr>
                                    <th>N.</th>
                                    <th>Código</th>
                                    <th>Nombre</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($categorias as $categoria)
                                    <tr>
                                        <td>{{ $categoria->id }}</td>
                                        <td>{{ $categoria->codigo }}</td>
                                        <td>{{ $categoria->nombre }}</td>
                                        <td>
                                            <form action="{{ route('categorias.toggle_active', $categoria) }}"
                                                method="POST">
                                                @csrf
                                                @method('PUT')
                                                <button href=""
                                                    class="btn btn-sm">
                                                    <span
                                                        class="badge {{ $categoria->activo ? 'bg-success' : 'bg-secondary' }}">
                                                        {{ $categoria->activo ? 'Activo' : 'Desactivo' }}
                                                    </span>
                                                </button>
                                            </form>
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

    <!-- Modal de venta -->
    <div class="modal fade" id="formUserModal" tabindex="-1" aria-labelledby="formUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="formUserModalLabel">Crear nueva categoría</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('categorias.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nombre" class="col-form-label">Nombre:</label>
                            <input type="text" class="form-control" name="nombre" id="nombre"
                                value="{{ old('nombre') }}" placeholder="Ej. Sensores de posicionamiento" required>
                        </div>
                        <div class="form-group row mb-3">
                            <label for="codigo" class="col-form-label">Código:</label>
                            <input type="text" class="form-control" name="codigo" id="codigo"
                                value="{{ old('codigo') }}" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Guardar</button>
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


@stop

@push('scripts')
@endpush
