<nav class="navbar navbar-expand-lg navbar-light shadow">
    <div class="container d-flex justify-content-between align-items-center">

        <a class="navbar-brand text-success logo h1 align-self-center" href="{{ url('/') }}">
            Panda
        </a>

        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse"
            data-bs-target="#templatemo_main_nav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse flex-fill d-lg-flex justify-content-lg-between" id="templatemo_main_nav">
            <div class="flex-fill">
                <ul class="nav navbar-nav d-flex gap-1 justify-content-center mx-lg-auto align-items-center nav-menu-destacado">
                    <li class="nav-item"><a class="nav-link" href="{{ url('/') }}">Inicio</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('about') }}">Sobre nosotros</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('shop') }}">Comprar</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('contact') }}">Contacto</a></li>
                </ul>
            </div>
            <div class="navbar align-self-center d-flex">
                <a class="nav-icon d-none d-lg-inline" href="#" data-bs-toggle="modal"
                    data-bs-target="#templatemo_search">
                    <i class="fa fa-fw fa-search text-dark mr-2"></i>
                </a>
                <a class="nav-icon position-relative text-decoration-none" href="{{ route('cart.index') }}">
                    <i class="fa fa-fw fa-cart-arrow-down text-dark mr-1"></i>
                    <span
                        class="position-absolute top-0 left-100 translate-middle badge rounded-pill bg-light text-dark">
                        {{ $carritoCantidad }}</span>
                </a>

                <div class="dropdown">
                    <a class="nav-icon position-relative text-decoration-none dropdown-toggle" href="#"
                        role="button" id="userMenu" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-fw fa-user text-dark mr-3"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userMenu">
                        @auth
                            <li><a class="dropdown-item" href="{{ route('dashboard.home') }}">Mi cuenta</a></li>
                            <li><a class="dropdown-item" href="{{ route('dashboard.orders') }}">Mis pedidos</a></li>
                            <li><a class="dropdown-item" href="{{ route('dashboard.profile') }}">Editar perfil</a></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button class="dropdown-item text-danger">Cerrar sesión</button>
                                </form>
                            </li>
                        @else
                            <li><a class="dropdown-item"
                                    href="{{ route('login', ['redirect' => url()->current()]) }}">Iniciar sesión</a></li>
                            <li><a class="dropdown-item" href="{{ route('register') }}">Registrarse</a></li>
                        @endauth
                    </ul>
                </div>
            </div>
        </div>
    </div>
</nav>
