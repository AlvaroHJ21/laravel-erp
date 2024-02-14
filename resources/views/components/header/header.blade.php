<nav class="navbar navbar-expand navbar-light navbar-bg">
    <a class="sidebar-toggle js-sidebar-toggle">
        <i class="hamburger align-self-center"></i>
    </a>

    <div class="navbar-collapse collapse">
        <ul class="navbar-nav navbar-align">
            <div class="nav-item">
                <div id="btn_dark" class="nav-icon cursor-pointer"></div>
            </div>
            <li class="nav-item dropdown">
                <a class="nav-icon dropdown-toggle" href="#" id="alertsDropdown" data-bs-toggle="dropdown">
                    <div class="position-relative">
                        <i class="align-middle" data-feather="bell"></i>
                        <span class="indicator notificaciones-num d-none">1</span>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end py-0" aria-labelledby="alertsDropdown">
                    <div class="dropdown-menu-header">
                        Notificaciones Nuevas: <span class="notificaciones-num">1</span>
                    </div>
                    <div id="notificaciones-container" class="list-group">
                        <!-- <a href="#" class="list-group-item">
                <div class="row g-0 align-items-center">
                  <div class="col-2">
                    <i class="text-neutro" data-feather="bell"></i>
                  </div>
                  <div class="col-10">
                    <div class="text-dark">Tipo de cambio</div>
                    <div class="text-muted small mt-1">Actualiza el tipo de cambio</div>
                    <div class="text-muted small mt-1">2h ago</div>
                  </div>
                </div>
              </a> -->
                    </div>
                    <div class="dropdown-menu-footer">
                        <a href="<?= 'notificaciones' ?>">Ver todas las notificaciones</a>
                    </div>
                </div>

            </li>
            <li class="nav-item dropdown">
                <a class="nav-icon dropdown-toggle d-inline-block d-sm-none" href="#" data-bs-toggle="dropdown">
                    <i class="align-middle" data-feather="settings"></i>
                </a>

                <a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="#" data-bs-toggle="dropdown">
                    <img src="{{ asset('img/avatars/avatar.jpg') }}" class="avatar img-fluid rounded me-1"
                        alt="usuario" /> <span class="text-dark"><?= session('nombre') ?></span>
                </a>
                <div class="dropdown-menu dropdown-menu-end">
                    <a class="dropdown-item" href="pages-profile.html"><i class="align-middle me-1"
                            data-feather="user"></i> Profile</a>
                    <a class="dropdown-item" href="#"><i class="align-middle me-1" data-feather="pie-chart"></i>
                        Analytics</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="pages-settings.html"><i class="align-middle me-1"
                            data-feather="settings"></i> Settings & Privacy</a>
                    <a class="dropdown-item" href="#"><i class="align-middle me-1" data-feather="help-circle"></i>
                        Help Center</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="{{route("login.logout")}}">Log out</a>
                </div>
            </li>
        </ul>
    </div>

    <!-- <script src="/assets/js/darkmode.js" type="module"></script> -->
</nav>
