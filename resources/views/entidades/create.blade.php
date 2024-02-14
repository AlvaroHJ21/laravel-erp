@extends('layouts.app')

@section('title', 'Crear Entidad')

@section('content_header')
    <div class="d-flex align-items-center">
        <a href="{{ route('entidades.index') }}"
            class="btn">
            <i data-feather="arrow-left" style="scale: 1.5"></i>
        </a>
        <h1>Crear Cliente Proveedor</h1>
    </div>
@stop

@section('content')

    <div class="card">
        <div class="card-body">
            <!-- <h5 class="card-title">Agregar Cliente / Proveedor</h5> -->
            <p class="card-text">
            <form id="form"
                method="POST"
                action="{{ route('entidades.store') }}"
                enctype="multipart/form-data"
                novalidate>
                @csrf
                <div class="form-group row mb-3">
                    <div class="col-sm-5">
                        <label for="tipo_documento_id"
                            class="form-label">
                            Tipo de Documento
                        </label>
                        <select id="tipo_documento_id"
                            name="tipo_documento_id"
                            class="form-select">
                            @foreach ($tiposDocumentosIdentidad as $tipo)
                                <option value="{{ $tipo->id }}"
                                    {{ old('tipo_documento_id') == $tipo->id ? 'selected' : '' }}>{{ $tipo->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-5">
                        <label for="numero_documento"
                            class="form-label">
                            Número de documento
                        </label>
                        <input id="numero_documento"
                            class="form-control"
                            type="text"
                            name="numero_documento"
                            placeholder="Ej. 12345678"
                            required
                            value="{{ old('numero_documento') }}">
                    </div>
                    <div class="col-sm-2 d-flex align-items-end">
                        <button id="btn_buscar_sunat"
                            type="button"
                            class="btn btn-primary w-100"
                            style="display: none;">
                            <i class="align-middle"
                                data-feather="search"></i>
                            Sunat
                        </button>
                        <button id="btn_buscar_reniec"
                            type="button"
                            class="btn btn-primary w-100"
                            style="display: none;">
                            <i class="align-middle"
                                data-feather="search"></i>
                            Reniec
                        </button>
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
                            value="{{ old('nombre') }}">
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
                            value="{{ old('direccion') }}">
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
                            value="{{ old('ubigeo') }}">
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <div class="col-sm-4">
                        <label for="tipo"
                            class="form-label">Seleccione tipo</label>
                        <select name="tipo"
                            class="form-select">
                            <option value="1"
                                {{ old('tipo') == '1' ? 'selected' : '' }}>CLIENTE</option>
                            <option value="2"
                                {{ old('tipo') == '2' ? 'selected' : '' }}>PROVEEDOR</option>
                            <option value="3"
                                {{ old('tipo') == '3' ? 'selected' : '' }}>PROVEEDOR /CLIENTE
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
                            value="{{ old('telefono') }}">
                    </div>
                    <div class="col-sm-4 form-check form-switch">
                        <input id="retencion"
                            class="form-check-input"
                            type="checkbox"
                            {{ old('retencion') == 'on' ? 'checked' : '' }}
                            name="retencion">
                        <label class="form-check-label"
                            for="retencion">Agente de retención</label>
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
                            value="{{ old('correo') }}">
                    </div>
                    <div class="col-sm-4">
                        <label for="porcentaje_descuento"
                            class="form-label">Porcentaje de descuento</label>
                        <input id="porcentaje_descuento"
                            class="form-control"
                            type="number"
                            name="porcentaje_descuento"
                            value="{{ old('porcentaje_descuento') }}">
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
    <script>
        $(document).ready(function() {
            updateButton();
            $("#tipo_documento_id").change(function() {
                updateButton();
                $("#numero_documento").val("");
            })

            function updateButton() {
                const tipoDocumento = $("#tipo_documento_id").val();
                if (tipoDocumento == 1) {
                    $("#btn_buscar_reniec").show();
                    $("#btn_buscar_sunat").hide();
                    return;
                }
                if (tipoDocumento == 2) {
                    $("#btn_buscar_sunat").show();
                    $("#btn_buscar_reniec").hide();
                    return;
                }

                $("#btn_buscar_sunat").hide();
                $("#btn_buscar_reniec").hide();
            }
            $("#btn_buscar_sunat").click(function() {
                // const tipoDocumento = $("#tipo_documento").val();
                const numeroDocumento = $("#numero_documento").val();
                const api = `${baseUrl}api/sunat/ruc/${numeroDocumento}`;

                if (numeroDocumento.length != 11) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'El RUC debe tener 11 dígitos',
                    })
                    return;
                }

                $.ajax({
                    url: api,
                    type: "GET",
                    headers: [
                        "Content-Type", "application/json"
                    ],
                    success: function(response) {
                        const data = JSON.parse(response);
                        console.log(data);
                        if (data.ok) {
                            const entidad = data.data;

                            $("#nombre").val(entidad.razonSocial);
                            const direccion = entidad.direccion + " " + entidad.departamento +
                                "-" + entidad.provincia + "-" + entidad.distrito;
                            $("#direccion").val(direccion);
                        }
                    },
                    error: function(error) {
                        console.log(error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'No se encontró el RUC',
                        })
                    }
                })
            })

            $("#btn_buscar_reniec").click(function() {
                // const tipoDocumento = $("#tipo_documento").val();
                const numeroDocumento = $("#numero_documento").val();
                const api = `${baseUrl}api/reniec/dni/${numeroDocumento}`;


                if (numeroDocumento.length != 8) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'El DNI debe tener 8 dígitos',
                    })
                    return;
                }

                $.ajax({
                    url: api,
                    type: "GET",
                    headers: [
                        "Content-Type", "application/json"
                    ],
                    success: function(response) {
                        const data = JSON.parse(response);
                        console.log(data);
                        if (data.ok) {
                            const entidad = data.data;

                            $("#nombre").val(
                                `${entidad.apellidoPaterno} ${entidad.apellidoMaterno} ${entidad.nombres}`
                            );
                        }
                    },
                    error: function(error) {
                        console.log(error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'No se encontró el DNI',
                        })
                    }
                })
            })
        });
    </script>
@stop
