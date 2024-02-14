@extends('layouts.app')

@section('title', 'Tipos de cambio')

@section('content_header')
    <h1>Tipos de cambio</h1>
@stop

@section('content')

    <div class="row">
        <div class="col-12 col-lg-6 col-xxl-6 d-flex">
            <div class="card flex-fill">
                <div class="card-header d-flex justify-content-between">
                    <h5 class="card-title mb-0">
                        Tipos de cambio de empresa
                    </h5>
                    <div>
                        <button class="btn btn-primary btn-sm btnAdd" id="{{ Auth::user()->rol == 1 ? '' : 'btn_venta' }}"
                            data-bs-toggle="modal" data-bs-target="#formTipoCambioVentaModal">Tipo cambio venta</button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="table-tipo-cambio-empresa" class="table table-hover my-0" id="tabla-tipo-cambio-empresa">
                            <thead>
                                <tr>
                                    <!-- <th>N.</th> -->
                                    <th>Fecha</th>
                                    <th>Moneda</th>
                                    <th>Tipo de cambio</th>
                                    <th>Proveniente</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tipos as $index => $tipo)
                                    @if ($tipo->proveniente != '1')
                                        <tr>
                                            <td>{{ $tipo->created_at }}</td>
                                            <td>{{ $tipo->moneda->nombre }}</td>
                                            <td>{{ $tipo->tipo_cambio_compra }}</td>
                                            <td>EMPRESA</td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-6 col-xxl-6 d-flex">
            <div class="card flex-fill">
                <div class="card-header d-flex justify-content-between">
                    <h5 class="card-title mb-0">
                        Tipos de cambio Sunat
                    </h5>
                    <div>
                        <button class="btn btn-primary btn-sm btnAdd" id="{{ Auth::user()->rol == 1 ? '' : 'btn_sunat' }}"
                            data-bs-toggle="modal" data-bs-target="#formTipoCambioModal">Tipo cambio sunat</button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="table-tipo-cambio-sunnat" class="table table-hover my-0" id="tabla-tipo-cambio-sunat">
                            <thead>
                                <tr>
                                    <!-- <th>N.</th> -->
                                    <th>Fecha</th>
                                    <th>Moneda</th>
                                    <th>Tipo de cambio</th>
                                    <th>Proveniente</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tipos as $index => $tipo)
                                    @if ($tipo->proveniente == '1')
                                        <tr>
                                            <td>{{ $tipo->created_at }}</td>
                                            <td>{{ $tipo->moneda->nombre }}</td>
                                            <td>{{ $tipo->tipo_cambio_compra }}</td>
                                            <td>SUNAT</td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de registrar un nuevo tipo de cambio de sunat -->
    <div class="modal fade" id="formTipoCambioModal" tabindex="-1" aria-labelledby="formUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="formUserModalLabel">Registrar tipo de cambio ($)</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('tipos_cambio.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" value="{{ Auth::user()->nombre }}" id="encargado" name="encargado">
                        <div class="form-group row mb-3">
                            <div class="col-sm-6">
                                <label for="tipo_cambio_compra" class="col-form-label">Compra:</label>
                                <input type="number" class="form-control" name="tipo_cambio_compra" id="tipo_cambio_compra"
                                    step="0.001" readonly value="{{ old('tipo_cambio_compra', $tipoCambioCompraHoy) }}">
                            </div>
                            <div class="col-sm-6">
                                <label for="tipo_cambio_venta" class="col-form-label">Venta:</label>
                                <input type="number" class="form-control" name="tipo_cambio_venta" id="tipo_cambio_venta"
                                    step="0.001" readonly value="{{ old('tipo_cambio_venta', $tipoCambioVentaHoy) }}">
                            </div>
                            <input type="hidden" name="proveniente" value="1">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Registrar</button>
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal de registrar un nuevo tipo de cambio de venta -->
    <div class="modal fade" id="formTipoCambioVentaModal" tabindex="-1" aria-labelledby="formUserModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="formUserModalLabel">Registrar tipo de cambio ($)</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('tipos_cambio.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" value="{{ Auth::user()->nombre }}" id="encargado" name="encargado">
                        <div class="form-group row mb-3">
                            <div class="col-sm-6">
                                <label for="tipo_cambio_compra" class="col-form-label">Compra:</label>
                                <input type="number" class="form-control" name="tipo_cambio_compra"
                                    id="tipo_cambio_compra"
                                    step="0.001" required value="{{ old('tipo_cambio_compra') }}">
                            </div>
                            <div class="col-sm-6">
                                <label for="tipo_cambio_venta" class="col-form-label">Venta:</label>
                                <input type="number" class="form-control" name="tipo_cambio_venta"
                                    id="tipo_cambio_venta" step="0.001" required
                                    value="{{ old('tipo_cambio_venta') }}">
                            </div>
                            <input type="hidden" name="proveniente" value="2">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Registrar</button>
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


@stop

@push('scripts')
@endpush
