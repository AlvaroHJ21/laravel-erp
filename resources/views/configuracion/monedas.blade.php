@extends('layouts.app')

@section('title', 'Monedas')

@section('content_header')
    <h1>Monedas</h1>
@stop

@section('content')

    <div class="row">
        <div class="col-12 d-flex">
            <div class="card flex-fill">
                <div class="card-header d-flex justify-content-between">
                    <h5 class="card-title mb-0">
                        Monedas
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover my-0" id="tabla">
                            <thead>
                                <tr>
                                    <th>N.</th>
                                    <th>Moneda</th>
                                    <th>Abreviado</th>
                                    <th>Estandar</th>
                                    <th>Símbolo</th>
                                    <th>Activo</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($monedas as $moneda)
                                    <tr>
                                        <td>{{ $moneda->id }}</td>
                                        <td>{{ $moneda->nombre }}</td>
                                        <td>{{ $moneda->abreviado }}</td>
                                        <td>{{ $moneda->abrstandar }}</td>
                                        <td>{{ $moneda->simbolo }}</td>
                                        <td>
                                            <form action="{{ route('monedas.change_status', $moneda) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <button
                                                    class="btn btn-sm">
                                                    <span
                                                        class="badge {{ $moneda->activo == '1' ? 'bg-success' : 'bg-secondary' }}">
                                                        {{ $moneda->activo == '1' ? 'Activo' : 'Desactivo' }}
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
