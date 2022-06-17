<header>
    <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-danger">
        <div class="container-fluid">
            {{-- <a class="navbar-brand bg-dark rounded" href="/">
                <img src="/assets/image/Logo/RAP.png" alt="RAP-XPRESS" width="50">
                <strong>RAP-XPRESS </strong>
            </a> --}}
            <a class="navbar-brand tombol bg-primary" href="/">
                <img src="/assets/image/Logo/RAP.png" alt="RAP-XPRESS" width="50">
                <strong>RAP-XPRESS </strong>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse"
                aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <ul class="navbar-nav me-auto mb-2 mb-md-0">
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('/') ? 'active' : '' }}" aria-current="page" href="/"><i
                                class="bi bi-house"></i> Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('tracking*') ? 'active' : '' }}" href="/tracking"><i
                                class="bi bi-search"></i> Lacak
                            Paket</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('kurir*') ? 'active' : '' }}" href="/kurir"><i
                                class="bi bi-person-square"></i> Kurir</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('online-shop*') ? 'active' : '' }}" href="/online-shop"><i
                                class="bi bi-shop"></i> Online Shop</a>
                    </li>
                    @auth()
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                Welcome back, {{ auth()->user()->name }}
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="/dashboard"><i class="bi bi-speedometer"></i> My
                                        Dashboard</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <form action="/logout" method="post">
                                        @csrf
                                        <button type="submit" class="dropdown-item">
                                            <i class="bi bi-box-arrow-right"></i> Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('register*') ? 'active' : '' }}" href="/register"> <i
                                    class="bi bi-person-plus"></i> Daftar
                                Mitra</a>
                        </li>
                    @endauth
                </ul>
                <!-- <form class="d-flex">
            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success" type="submit">Search</button>
          </form> -->
            </div>
        </div>
    </nav>
</header>
