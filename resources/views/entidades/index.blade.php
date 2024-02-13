@extends('adminlte::page')

@section('title', 'Entidades')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h1>Clientes / Proveedores</h1>
        <a href="{{ route('entidades.create') }}" class="btn btn-primary">Crear</a>
    </div>
@stop

@section('content')

    <div class="card flex-fill">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover my-0" id="tabla">
                    <thead>
                        <tr>
                            <th class="text-center">Razón Social</th>
                            <th class="text-center">Documento</th>
                            <th class="text-center">Tipo</th>
                            <th class="text-center">Dirección</th>
                            <th class="text-center">Teléfono</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($entidades as $entidad)
                            <tr>
                                <td>{{ $entidad->nombre }}</td>
                                <td>
                                    {{ $entidad->documento_identidad->nombre }}
                                    {{ $entidad->numero_documento }}
                                </td>
                                <td>{{ $entidad->tipo }}</td>
                                <td>{{ $entidad->direccion }}</td>
                                <td>{{ $entidad->telefono }}</td>
                                <td class="text-center">
                                    <div class="d-flex" style="gap: 4px">
                                        <a href="{{ route('entidades.edit', $entidad) }}"
                                            class="btn btn-sm btn-outline-secondary" type="button">
                                            <i class="fa fa-edit"></i>
                                        </a>

                                        @if (Auth::user()->rol == 1)
                                            @csrf
                                            <button
                                                data-url="{{ route('entidades.destroy', $entidad) }}"
                                                class="btn-delete btn btn-outline-danger btn-sm">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        @endif
                                    </div>

                                </td>
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
