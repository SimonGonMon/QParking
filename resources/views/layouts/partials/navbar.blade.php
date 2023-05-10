<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid px-5">
        <a href="/" class="align-items-center mb-2 mb-lg-0 text-white text-decoration-none me-2">
            <img class="bi me-50" src="{!! url('assets/images/qparking_fondooscuro.png') !!}" alt="" width="62"
                 height="62">
        </a>

{{--        <ul class="nav col-6 col-lg-auto me-lg-auto mb-0 justify-content-center mb-md-0 mx-auto">--}}
{{--            <li class="d-flex"><a href="{{ route('home.index') }}" class="nav-link px-2 text-light">Inicio</a></li>--}}
{{--        </ul>--}}

{{--        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"--}}
{{--                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span--}}
{{--                class="navbar-toggler-icon"></span></button>--}}

        @guest
            <div class="text-end">
                <a href="{{ route('login.perform') }}" class="btn btn-outline-light me-2">Ingresar</a>
                <a href="{{ route('register.perform') }}" class="btn btn-primary">Registro</a>
            </div>
        @endguest

        @auth
            <div class="btn-group dropstart">
                <button type="button" class="btn btn-outline-light dropdown-toggle" data-bs-toggle="dropdown"
                        aria-expanded="false">
                    {{ auth()->user()->name }}
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="{{ route('dashboard.index') }}">Dashboard</a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item" href="{{ route('logout.perform') }}">Cerrar Sesión</a></li>
                </ul>
            </div>
        @endauth
    </div>
</nav>
