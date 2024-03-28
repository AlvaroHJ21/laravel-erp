@extends('layouts.app')

@section('title', 'Vehiculos')

@section('content_header')
  <h1>Vehículos</h1>
@stop

@section('content')

  <div class="row">
    <div class="col-12 d-flex">
      <div class="card flex-fill">
        <div class="card-header d-flex justify-content-between">
          <h5 class="card-title mb-0">
            Vehículos
          </h5>
          <button id="btn-add"
                  class="btn btn-primary btn-sm"
                  data-bs-toggle="modal"
                  data-bs-target="#modal">Nuevo</button>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-hover my-0" id="tabla">
              <thead>
                <tr>
                  <th>N.</th>
                  <th>Placa</th>
                  <th>Marca</th>
                  <th>Modelo</th>
                  <th>Categoria M1L</th>
                  <th>Acciones</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($vehiculos as $vehiculo)
                  <tr>
                    <td>{{ $vehiculo->id }}</td>
                    <td>{{ $vehiculo->placa }}</td>
                    <td>{{ $vehiculo->marca }}</td>
                    <td>{{ $vehiculo->modelo }}</td>
                    <td>{{ $vehiculo->categoria_m1_l ? 'Sí' : 'No' }}</td>
                    <td class="text-center">
                      <div class="d-flex" style="gap: 4px">

                        <button class="btn btn-sm btn-outline-secondary btn-edit"
                                data-id="{{ $vehiculo->id }}"
                                data-bs-toggle="modal"
                                data-bs-target="#modal">
                          <i data-feather="edit"></i>
                        </button>

                        @if (Auth::user()->rol == 1)
                          <button data-url="{{ route('vehiculos.destroy', $vehiculo) }}"
                                  class="btn-delete btn btn-outline-danger btn-sm">
                            <i data-feather="trash"></i>
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
    </div>
  </div>

  <!-- Form modal -->
  <div class="modal fade" id="modal" tabindex="-1" aria-labelledby="formUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="formUserModalLabel">Crear nueva categoría</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form id="form" method="POST">
          @csrf
          <div class="modal-body row">
            <div class="col-6 mb-3">
              <label for="placa" class="col-form-label">Placa:</label>
              <input type="text" class="form-control" name="placa" id="placa"
                     value="" placeholder="" required>
            </div>
            <div class="col-6 mb-3">
              <label for="marca" class="col-form-label">Marca:</label>
              <input type="text" class="form-control" name="marca" id="marca"
                     value="" required>
            </div>
            <div class="col-6 mb-3">
              <label for="modelo" class="col-form-label">Modelo:</label>
              <input type="text" class="form-control" name="modelo" id="modelo"
                     value="" required>
            </div>
            <div class="col-6 mb-3">
              <div class="form-check form-switch">
                <input id="categoria_m1_l"
                       class="form-check-input"
                       type="checkbox"
                       name="categoria_m1_l">
                <label class="form-check-label"
                       for="categoria_m1_l">Categoria ML 1</label>
              </div>
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

@section('js')
  <script>
    const vehiculos = @json($vehiculos);
    const postUrl = @json(route('vehiculos.store'));
    const updateUrl = @json(route('vehiculos.update', ':id'));
  </script>
  @vite(['resources/js/vehiculos/index.ts'])
@stop
