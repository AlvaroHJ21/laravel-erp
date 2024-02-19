@extends('layouts.app')

@section('title', 'Productos')

@section('content_header')
    <h1>Productos</h1>
@stop

@section('content')

    <div class="row">
        <div class="col-12 d-flex">
            <div class="card flex-fill">
                <div class="card-header d-flex justify-content-between">
                    <h5 class="card-title mb-0">
                        Productos
                    </h5>
                    <a href="{{ route('productos.create') }}" class="btn btn-primary btn-sm btnAdd">Agregar</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover my-0" id="table-productos">
                            <thead>
                                <tr>
                                    <th>Código</th>
                                    <th>Nombre</th>
                                    <th>Unidad</th>
                                    <th>Valor Venta</th>
                                    <th>Cantidad</th>
                                    <th>Categoría</th>
                                    <th>Imagen</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($productos as $producto)
                                    <tr>
                                        <td>{{ $producto->codigo }}</td>
                                        <td>{{ $producto->nombre }}</td>
                                        <td>{{ $producto->unidad->unidad }}</td>
                                        <td>{{ $producto->tipo_moneda == 1 ? 'S/' : '$' }} {{ $producto->valor_venta }}</td>
                                        <td>{{ $producto->cantidad ? $producto->cantidad : '0' }}</td>
                                        <td>
                                            {{ $producto->categoria->nombre }}
                                        </td>
                                        <td>
                                            @if ($producto->imagen)
                                                <img class="img-thumbnail"
                                                    src="{{ asset('storage/productos/' . $producto->imagen) }}"
                                                    width="100" alt="">
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('productos.edit', $producto) }}"
                                                class="btn btn-sm btn-outline-secondary" type="button">
                                                <i data-feather="edit"></i>
                                            </a>
                                            <button
                                                data-url="{{ route('productos.destroy', $producto) }}"
                                                class="btn-delete btn btn-outline-danger btn-sm">
                                                <i data-feather="trash"></i>
                                            </button>
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


@stop

@push('scripts')
@endpush
