@extends('adminlte::page')

@section('title', 'Editar Entidad')

@section('content_header')
    <div class="d-flex align-items-center">
        <a href="{{ route('entidades.index') }}"
            class="btn"
            style="color:inherit">
            <i class="fa fa-arrow-left"></i>
        </a>
        <h1>Editar Cliente Proveedor</h1>
    </div>
@stop

@section('content')

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show">
            <h5><i class="icon fas fa-ban"></i> Error!</h5>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button"
                class="close"
                data-dismiss="alert"
                aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <p class="card-text">
            <form id="form"
                method="POST"
                action="{{ route('entidades.update', $entidad) }}"
                novalidate>
                @csrf
                @method('PUT')
                <div class="form-group row mb-6">
                    <div class="col-sm-6">
                        <label for="tipo_documento_id"
                            class="form-label">Tipo de Documento</label>
                        <select id="tipo_documento_id"
                            name="tipo_documento_id"
                            class="form-control">
                            @foreach ($tiposDocumentosIdentidad as $tipo)
                                <option value="{{ $tipo->id }}"
                                    {{ $entidad->tipo_documento_id == $tipo->id ? 'selected' : '' }}>{{ $tipo->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-6">
                        <label for="numero_documento"
                            class="form-label">Número de documento</label>
                        <input id="numero_documento"
                            class="form-control"
                            name="numero_documento"
                            placeholder="Ej. 12345678"
                            required
                            value="{{ old('numero_documento', $entidad->numero_documento) }}">
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <div class="col-12">
                        <label for="nombre"
                            class="form-label">Nombre legal</label>
                        <input id="nombre"
                            class="form-control"
                            type="text"
                            name="nombre"
                            placeholder="Nombre legal/Razón Social"
                            required
                            value="{{ old('nombre', $entidad->nombre) }}">
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <div class="col-8">
                        <label for="direccion"
                            class="form-label">Dirección</label>
                        <input id="direccion"
                            class="form-control"
                            type="text"
                            name="direccion"
                            placeholder="Dirección"
                            required
                            value="{{ old('direccion', $entidad->direccion) }}">
                    </div>
                    <div class="col-4">
                        <label for="ubigeo"
                            class="form-label">Ubigeo</label>
                        <input id="ubigeo"
                            class="form-control"
                            type="text"
                            name="ubigeo"
                            placeholder="Ubigeo"
                            required
                            value="{{ old('ubigeo', $entidad->ubigeo) }}">
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <div class="col-sm-4">
                        <label for="tipo"
                            class="form-label">Seleccione tipo</label>
                        <select name="tipo"
                            class="form-control"
                            value="{{ $entidad->tipo }}">
                            <option value="1"
                                {{ old('tipo', $entidad->tipo) == '1' ? 'selected' : '' }}>CLIENTE</option>
                            <option value="2"
                                {{ old('tipo', $entidad->tipo) == '2' ? 'selected' : '' }}>PROVEEDOR</option>
                            <option value="3"
                                {{ old('tipo', $entidad->tipo) == '3' ? 'selected' : '' }}>PROVEEDOR / CLIENTE
                            </option>
                        </select>
                    </div>
                    <div class="col-sm-4">
                        <label for="telefono"
                            class="form-label">Número de teléfono</label>
                        <input id="telefono"
                            class="form-control"
                            type="number"
                            name="telefono"
                            placeholder="Ej. 987654321"
                            required
                            value="{{ old('telefono', $entidad->telefono) }}">
                    </div>
                    <div class="col-sm-4 form-check form-switch">

                        <input type="hidden" name="retencion" value="0">
                        <input type="checkbox"
                            id="retencion"
                            name="retencion"
                            {{ $entidad->retencion ? 'checked' : '' }} value="1">
                        <label class="form-check-label"
                            for="retencion">
                            Agente de retención
                        </label>
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <div class="col-sm-8">
                        <label for="correo"
                            class="form-label">Correo electrónico</label>
                        <input id="correo"
                            class="form-control"
                            type="email"
                            name="correo"
                            placeholder="Ej. nombre@gmail.com"
                            required
                            value="{{ old('correo', $entidad->correo) }}">
                    </div>
                    <div class="col-sm-4">
                        <label for="porcentaje_descuento"
                            class="form-label">Porcentaje de descuento</label>
                        <input id="porcentaje_descuento"
                            class="form-control"
                            type="number"
                            name="porcentaje_descuento"
                            value="{{ old('porcentaje_descuento', $entidad->porcentaje_descuento) }}">
                    </div>
                </div>
                <button class="btn btn-success"
                    type="submit">GUARDAR</button>
            </form>
            </p>
        </div>
    </div>


@stop

@section('js')
    <script></script>
@stop
