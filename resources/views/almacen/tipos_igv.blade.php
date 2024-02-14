@extends('layouts.app')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Tipos de IGV</h1>
@stop

@section('content')

    <div class="row">
        <div class="col-12 d-flex">
            <div class="card flex-fill">
                <div class="card-header d-flex justify-content-between">
                    <h5 class="card-title mb-0">
                        Impuestos
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover my-0" id="table-tipo-igv">
                            <thead>
                                <tr>
                                    <th>N.</th>
                                    <th>Código</th>
                                    <th>Tipo</th>
                                    <th>Código Tributo</th>
                                    <th>Porcentaje</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tipos as $tipo)
                                    <tr>
                                        <td>{{ $tipo->id }}</td>
                                        <td>{{ $tipo->codigo }}</td>
                                        <td>{{ $tipo->tipo_igv }}</td>
                                        <td>{{ $tipo->codigo_de_tributo }}</td>
                                        <td>{{ number_format($tipo->porcentaje, 2) }}</td>
                                        <td>
                                            <form action="{{ route('tipos_igv.toggle_active', $tipo) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <button
                                                    class="btn btn-sm">
                                                    <span
                                                        class="badge {{ $tipo->activo == '1' ? 'bg-success' : 'bg-secondary' }}">
                                                        {{ $tipo->activo == '1' ? 'Activo' : 'Desactivo' }}
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


@stop

@push('scripts')
@endpush
