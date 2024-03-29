@extends('layouts.app')

@section('title', 'almacenes')

@section('content_header')
  <h1>Almacenes</h1>
@stop

@section('content')

  <div class="row">
    <div class="col-12 d-flex">
      <div class="card flex-fill">
        <div class="card-header d-flex justify-content-between">
          <h5 class="card-title mb-0">
            Almacenes
          </h5>
          <div class="">
            <button class="btn btn-primary btn-sm btnAdd" data-bs-toggle="modal"
                    data-bs-target="#formUserModal">Nuevo</button>
            <button class="btn btn-primary btn-sm btnAdd" data-bs-toggle="modal"
                    data-bs-target="#formModalMove">Realizar movimiento</button>
          </div>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-hover my-0" id="tabla">
              <thead>
                <tr>
                  <th>N.</th>
                  <th>Nombre</th>
                  <th>Estado</th>
                  <th>Inventarios</th>
                  <th>Inventarios</th>
                  <th>Acciones</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($almacenes as $almacen)
                  <tr>
                    <td>{{ $almacen->id }}</td>
                    <td>{{ $almacen->nombre }}</td>
                    <td>
                      <form action="{{ route('almacenes.toggle_active', $almacen) }}"
                            method="POST">
                        @csrf
                        @method('PUT')
                        <button href=""
                                class="btn btn-sm">
                          <span
                                class="badge {{ $almacen->activo ? 'bg-success' : 'bg-secondary' }}">
                            {{ $almacen->activo ? 'Activo' : 'Desactivo' }}
                          </span>
                        </button>
                      </form>
                    </td>
                    <td>
                      <button class="btn btn-sm"
                              data-bs-toggle="modal"
                              data-bs-target="#formAlmacenInventarios{{ $almacen->id }}">
                        <i data-feather="eye"></i>
                      </button>
                      @include('almacen.partials.almacenes-inventarios')
                    </td>
                    <td>
                      <button class="btn btn-sm"
                              data-bs-toggle="modal"
                              data-bs-target="#formAlmacenInventarios{{ $almacen->id }}">
                        <i data-feather="eye"></i>
                      </button>
                      @include('almacen.partials.almacenes-inventarios')
                    </td>
                    <td>
                      <button
                              data-bs-toggle="modal"
                              data-bs-target="#formAlmacenEdit{{ $almacen->id }}"
                              class="btn btn-sm btn-outline-secondary" type="button">
                        <i data-feather="edit"></i>
                      </button>
                      <button
                              {{-- data-url="{{ route('almacenes.destroy', $almacen) }}" --}}
                              class="btn-delete btn btn-outline-danger btn-sm">
                        <i data-feather="trash"></i>
                      </button>
                    </td>
                  </tr>

                  @include('almacen.partials.almacenes-form-edit')
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>



  @include('almacen.partials.almacenes-form-create')
  @include('almacen.partials.modalform-movement')
  @include('almacen.partials.modalform-movement')
@stop



@section('js')
  <script>
    window.inventarios = @json($inventarios);
  </script>
  @vite('resources/js/almacenes/index.ts')
@stop
