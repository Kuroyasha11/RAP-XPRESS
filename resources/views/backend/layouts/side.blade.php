<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-danger sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/dashboard" style="color: black">
        <div class="sidebar-brand-icon rotate-n-15">
            {{-- <i class='fa fa-crow' style='color: blue'></i> --}}
            <img src="/assets/image/Logo/RAP.png" alt="RAP-XPRESS" width="45">
        </div>
        <div class="sidebar-brand-text mx-3">RAP-XPRESS</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ Request::is('dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="/dashboard">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    @can('admin')
        <!-- Heading -->
        <div class="sidebar-heading">
            Admin
        </div>

        <!-- Nav Item - Pages Collapse Menu -->
        <li
            class="nav-item  {{ Request::is('dashboard/partner*') ? 'active' : '' }} {{ Request::is('dashboard/registration*') ? 'active' : '' }}">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true"
                aria-controls="collapseTwo">
                <i class='fa fa-user'></i>
                <span>Mitra RAP-XPRESS</span>
            </a>
            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Fungsi :</h6>
                    <a class="collapse-item {{ Request::is('dashboard/partner*') ? 'active' : '' }}"
                        href="/dashboard/partner"><i class='fa fa-boxes'></i> Mitra</a>
                    <a class="collapse-item {{ Request::is('dashboard/registration*') ? 'active' : '' }}"
                        href="/dashboard/registration"><i class='fa fa-user-check'></i> Pendaftar</a>
                </div>
            </div>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider">


        <!-- Nav Item - Pages Collapse Menu -->
        <li
            class="nav-item {{ Request::is('dashboard/permintaan*') ? 'active' : '' }} {{ Request::is('dashboard/pengiriman*') ? 'active' : '' }} {{ Request::is('dashboard/pickup*') ? 'active' : '' }} {{ Request::is('dashboard/kurir*') ? 'active' : '' }}">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseThree" aria-expanded="true"
                aria-controls="collapseThree">
                <i class='fa fa-boxes'></i>
                <span>Paket</span>
            </a>
            <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Permintaan :</h6>
                    <a class="collapse-item {{ Request::is('dashboard/permintaan*') ? 'active' : '' }}"
                        href="/dashboard/permintaan"><i class='fa fa-inbox'></i> Permintaan</a>
                    <h6 class="collapse-header">Kurir :</h6>
                    <a class="collapse-item {{ Request::is('dashboard/pengiriman*') ? 'active' : '' }}"
                        href="/dashboard/pengiriman"><i class='fa fa-boxes'></i> Paket</a>
                    <a class="collapse-item {{ Request::is('dashboard/pickup*') ? 'active' : '' }}"
                        href="/dashboard/pickup"><i class="fa fa-truck-pickup"></i> Pengambilan Paket</a>
                    <a class="collapse-item {{ Request::is('dashboard/kurir*') ? 'active' : '' }}"
                        href="/dashboard/kurir"><i class='fa fa-shipping-fast'></i> Pengiriman Paket</a>
                </div>
            </div>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider">


        <!-- Nav Item - Pages Collapse Menu -->
        <li class="nav-item {{ Request::is('dashboard/slide*') ? 'active' : '' }} ">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseFive" aria-expanded="true"
                aria-controls="collapseFive">
                <i class="far fa-newspaper"></i>
                <span>Main Page</span>
            </a>
            <div id="collapseFive" class="collapse" aria-labelledby="headingFive" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Fungsi :</h6>
                    <a class="collapse-item {{ Request::is('dashboard/slide*') ? 'active' : '' }}"
                        href="/dashboard/slide">
                        <i class="fa fa-image"></i> Slide Utama
                    </a>
                    {{-- <a class="collapse-item {{ Request::is('dashboard/post*') ? 'active' : '' }}" href="/dashboard/post">
                        <i class="fa fa-newspaper"></i> Post Utama
                    </a> --}}
                </div>
            </div>
        </li>
    @elsecan('mitra')
        <!-- Heading -->
        <div class="sidebar-heading">
            Mitra
        </div>
        <!-- Nav Item - Pages Collapse Menu -->
        <li
            class="nav-item {{ Request::is('dashboard/paket*') ? 'active' : '' }} {{ Request::is('dashboard/pengambilan-paket*') ? 'active' : '' }} {{ Request::is('dashboard/pengiriman-paket*') ? 'active' : '' }}">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseFour" aria-expanded="true"
                aria-controls="collapseFour">
                <i class='fa fa-truck'></i>
                <span>Service</span>
            </a>
            <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    @if (auth()->user()->partner_id == 2)
                        <a class="collapse-item {{ Request::is('dashboard/paket*') ? 'active' : '' }}"
                            href="/dashboard/paket"><i class='fa fa-box'></i>
                            Paket</a>
                    @elseif(auth()->user()->partner_id == 1)
                        <a class="collapse-item {{ Request::is('dashboard/pengambilan-paket*') ? 'active' : '' }}"
                            href="/dashboard/pengambilan-paket"><i class='fa fa-box'></i>
                            Pengambilan Paket</a>
                        <a class="collapse-item {{ Request::is('dashboard/pengiriman-paket*') ? 'active' : '' }}"
                            href="/dashboard/pengiriman-paket"><i class='fa fa-box-open'></i>
                            Pengiriman Paket</a>
                    @endif
                </div>
            </div>
        </li>
    @endcan

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->
