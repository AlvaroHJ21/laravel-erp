@extends('layouts.app')

@section('title', 'Unidades')

@section('content_header')
    <h1>Unidades</h1>
@stop

@section('content')

    <div class="row">
        <div class="col-12 d-flex">
            <div class="card flex-fill">
                <div class="card-header d-flex justify-content-between">
                    <h5 class="card-title mb-0">
                        Unidades
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover my-0" id="tabla">
                            <thead>
                                <tr>
                                    <th>N.</th>
                                    <th>Código</th>
                                    <th>Unidad</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($unidades as $unidad)
                                    <tr>
                                        <td>{{ $unidad->id }}</td>
                                        <td>{{ $unidad->codigo }}</td>
                                        <td>{{ $unidad->unidad }}</td>
                                        <td>
                                            <form action="{{ route('unidades.toggle_active', $unidad->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <button
                                                    class="btn btn-sm">
                                                    <span
                                                        class="badge {{ $unidad->activo == '1' ? 'bg-success' : 'bg-secondary' }}">
                                                        {{ $unidad->activo == '1' ? 'Activo' : 'Desactivo' }}
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
