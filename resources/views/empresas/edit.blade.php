@extends('layouts.app')

@section('title', 'Editar Empresa')

@section('content_header')
  <div class="d-flex align-items-center">
    <button onclick="window.history.back()" class="btn">
      <i data-feather="arrow-left" style="scale: 1.5"></i>
    </button>
    <h1>Editar Empresa</h1>
  </div>
@stop

@section('content')
  <form method="post" action="{{ route('empresas.update', $empresa) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="row">
      <div class="col-12 col-lg-6 d-flex">
        <div class="card flex-fill">
          <div class="card-header">
            <h5 class="card-title">DATOS DE LA EMPRESA</h5>
          </div>
          <div class="card-body">
            <div class="card-text">
              <input type="hidden" value="{{ $empresa['id'] }}" id="id" name="id">
              <div class="form-group row mb-3">
                <div class="col-sm-3">
                  <label for="ruc" class="form-label">RUC</label>
                  <input id="ruc" class="form-control" type="number" name="ruc"
                         value="{{ $empresa['ruc'] }}">
                </div>
                <div class="col-sm-9">
                  <label for="razon_social" class="form-label">Razon social</label>
                  <input id="razon_social" class="form-control" type="text" name="razon_social"
                         value="{{ $empresa['razon_social'] }}">
                </div>
              </div>

              <div class="form-group row mb-3">
                <div class="col-sm-3">
                  <label for="nombre_comercial" class="form-label">Nombre Comercial</label>
                  <input id="nombre_comercial" class="form-control" type="text" name="nombre_comercial"
                         value="{{ $empresa['nombre_comercial'] }}">
                </div>
                <div class="col-sm-6">
                  <label for="domicilio_fiscal" class="form-label">Domicilio</label>
                  <input id="domicilio_fiscal" class="form-control" type="text" name="domicilio_fiscal"
                         value="{{ $empresa['domicilio_fiscal'] }}">
                </div>
                <div class="col-sm-3">
                  <label for="ubigeo" class="form-label">Ubigeo</label>
                  <input id="ubigeo" class="form-control" type="number" name="ubigeo"
                         value="{{ $empresa['ubigeo'] }}">
                </div>
              </div>

              <div class="form-group row mb-3">
                <div class="col-sm-3">
                  <label for="urbanizacion" class="form-label">Urbanizacion</label>
                  <input id="urbanizacion" class="form-control" type="text" name="urbanizacion"
                         value="{{ $empresa['urbanizacion'] }}">
                </div>
                <div class="col-sm-3">
                  <label for="distrito" class="form-label">Distrito</label>
                  <input id="distrito" class="form-control" type="text" name="distrito"
                         value="{{ $empresa['distrito'] }}">
                </div>
                <div class="col-sm-3">
                  <label for="provincia" class="form-label">Provincia</label>
                  <input id="provincia" class="form-control" type="text" name="provincia"
                         value="{{ $empresa['provincia'] }}">
                </div>
                <div class="col-sm-3">
                  <label for="departamento" class="form-label">Departemento</label>
                  <input id="departamento" class="form-control" type="text" name="departamento"
                         value="{{ $empresa['departamento'] }}">
                </div>
              </div>

              <div class="form-group row mb-3">
                <div class="col-sm-3">
                  <label for="telefono_fijo" class="form-label">Telefono fijo</label>
                  <input id="telefono_fijo" class="form-control" type="number" name="telefono_fijo"
                         value="{{ $empresa['telefono_fijo'] }}">
                </div>
                <div class="col-sm-6">
                  <label for="correo" class="form-label">Correo</label>
                  <input id="correo" class="form-control" type="email" name="correo"
                         value="{{ $empresa['correo'] }}">
                </div>
                <div class="col-sm-3">
                  <label for="telefono_movil" class="form-label">Telefono movil</label>
                  <input id="telefono_movil" class="form-control" type="number" name="telefono_movil"
                         value="{{ $empresa['telefono_movil'] }}">
                </div>
              </div>

              <div class="form-group row mb-3">
                <div class="col-sm-4">
                  <label for="codigo_sucursal_sunat" class="form-label">Codigo sucursal de sunat</label>
                  <input id="codigo_sucursal_sunat" class="form-control" type="number"
                         name="codigo_sucursal_sunat" value="{{ $empresa['codigo_sucursal_sunat'] }}">
                </div>
              </div>

              <div class="form-group mb-3">
                <label for="logo" class="form-label">Imagen</label>
                <div class="d-flex" style="gap: 8px">
                  <div>
                    <img class="img-thumbnail"
                         src="{{ asset('storage/empresas/' . $empresa['logo']) }}" width="200px"
                         alt="">
                  </div>
                  <div>
                    <img width="200px" src="{{ asset('img/default-image.png') }}" alt="avatar"
                         id="img">
                  </div>
                </div>
                <input id="logo" class="form-control" type="file" name="logo">
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-12 col-lg-6">
        <div class="card flex-fill">
          <div class="card-header">
            <h5 class="card-title">CREDENCIALES</h5>
          </div>
          <div class="card-body">

            <div class="row">
              <div class="col-12 col-sm-6 mb-3">
                <label for="usu_secundario_usuario" class="form-label">Usuario Secundario</label>
                <input id="usu_secundario_usuario" class="form-control" type="text"
                       name="usu_secundario_usuario" value="{{ $empresa['usu_secundario_usuario'] }}" />
              </div>
              <div class="col-12 col-sm-6 mb-3">
                <label for="usu_secundario_password" class="form-label">Usuario Secundario
                  (Contraseña)</label>
                <input id="usu_secundario_password" class="form-control" type="text"
                       name="usu_secundario_password" value="{{ $empresa['usu_secundario_password'] }}" />
              </div>
              <div class="col-12 col-sm-6 mb-3">
                <label for="guias_client_id" class="form-label">Guias Client ID</label>
                <input id="guias_client_id" class="form-control" type="text" name="guias_client_id"
                       value="{{ $empresa['guias_client_id'] }}">
              </div>
              <div class="col-12 col-sm-6 mb-3">
                <label for="guias_client_secret" class="form-label">Guias Client Secret</label>
                <input id="guias_client_secret" class="form-control" type="text"
                       name="guias_client_secret" value="{{ $empresa['guias_client_secret'] }}">
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>

    <button class="btn btn-success w-100" type="submit">ACTUALIZAR</button>
  </form>
@stop

@section('css')
  @vite('resources/js/app.js')
@stop

@section('js')
  <script>
    const file = document.getElementById('logo');
    const img = document.getElementById('img');
    file.addEventListener('change', e => {
      if (e.target.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
          img.src = e.target.result;
        }
        reader.readAsDataURL(e.target.files[0])
      }
    });
  </script>
@stop
