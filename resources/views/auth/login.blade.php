{{-- @extends('adminlte::auth.login') --}}

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link rel="shortcut icon" href="/assets/img/logo.png" />
  <title>Sistema ERP</title>

  @vite(['resources/css/app.css'])
</head>

<body>
  <main class="d-flex w-100">
    <div class="container d-flex flex-column">
      <div class="row vh-100">
        <div class="col-sm-10 col-md-8 col-lg-6 mx-auto d-table h-100">
          <div class="d-table-cell align-middle">

            <div class="card">
              <div class="card-body">
                <div class="text-center mt-4">
                  <h1 class="h2">Bienvenido</h1>
                  <p class="lead">
                    Acceda a su cuenta para continuar
                  </p>
                </div>
                <div class="m-sm-4">
                  <div class="text-center">
                    <img src="<?= asset('img/logo.png') ?>" alt="Logo"
                         class="img-fluid rounded-circle" width="132" height="132" />
                  </div>

                  <!-- TODO: cambiar base_url y metodo a POST para el login -->

                  {{-- Errors --}}
                  @if ($errors->any())
                    <div class="alert alert-danger p-2">

                      @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                      @endforeach

                    </div>
                  @endif

                  <form action="{{ route('login.store') }}" method="POST">

                    @csrf

                    <div class="mb-3">
                      <label class="form-label" for="usuario">Usuario</label>
                      <input class="form-control form-control-lg" type="text" id="usuario"
                             name="username" placeholder="Nombre de usuario" />
                    </div>
                    <div class="mb-3">
                      <label class="form-label" for="password">Contraseña</label>
                      <input class="form-control form-control-lg" type="password" id="password"
                             name="password" placeholder="*********"" />
                    </div>
                    <div class="text-center mt-3">
                      <button type="submit" class="btn btn-lg btn-primary">Iniciar
                        Sesión</button>
                    </div>
                  </form>

                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>
  </main>
</body>

</html>
