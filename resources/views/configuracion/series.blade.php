@extends('layouts.app')

@section('title', 'Series')

@section('content_header')
    <h1>Series</h1>
@stop

@section('content')

    <div class="row">
        <div class="col-12 d-flex">
            <div class="card flex-fill">
                <div class="card-header d-flex justify-content-between">
                    <h5 class="card-title mb-0">
                        Series
                    </h5>
                    <button class="btn btn-primary btn-sm btnAdd" data-bs-toggle="modal"
                        data-bs-target="#formUserModal">Nuevo</button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="table-series" class="table table-hover my-0" id="tabla">
                            <thead>
                                <tr>
                                    <th>N.</th>
                                    <th>Tipo Documento</th>
                                    <th>Serie</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($series as $serie)
                                    <tr>
                                        <td>{{ $serie->id }}</td>
                                        <td><span class="badge bg-success">{{ $serie->tipo_documento->nombre }}</span></td>
                                        <td>{{ $serie->serie }}</td>
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
                    <h5 class="modal-title" id="formUserModalLabel">Crear nueva serie</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('series.create') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="userID" id="userID">
                        <div class="mb-3">
                            <label for="inputRole" class="col-form-label">Tipo de documento:</label>
                            <select name="tipo_documento_id" id="inputRole" class="form-control" required>
                                <option value="">-- Elige un tipo de documento --</option>
                                @foreach ($tiposDocumento as $tipo)
                                    <option value="{{ $tipo->id }}">{{ $tipo->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="inputUsername" class="col-form-label">Serie:</label>
                            <input type="text" class="form-control" name="serie" id="inputUsername"
                                value="{{ old('serie') }}" required>
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
