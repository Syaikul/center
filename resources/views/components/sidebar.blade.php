<div class="sidebar" style="background-color: #e8f0ec !important; color: white;">
    <div class="sidebar-logo">
        <!-- Logo Header -->
        <div class="logo-header" style="background-color: #e8f0ec !important; color: white;">
            <a href="index.html" class="logo">
                <img src="https://www.mesitechmitra.co.id/assets/photos/logo-baru.png" alt="navbar brand"
                    class="navbar-brand" height="40" />
            </a>
            <div class="nav-toggle">
                <button class="btn btn-toggle toggle-sidebar">
                    <i class="gg-menu-right"></i>
                </button>
                <button class="btn btn-toggle sidenav-toggler">
                    <i class="gg-menu-left"></i>
                </button>
            </div>
            <button class="topbar-toggler more">
                <i class="gg-more-vertical-alt"></i>
            </button>
        </div>
        <!-- End Logo Header -->
    </div>
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <ul class="nav nav-secondary">
                <li class="nav-item">
                    <a href="widgets.html">
                        <i class="fas fa-home"></i>
                        <p>Dashboard</p>
                        <span class="badge badge-success"></span>
                    </a>
                </li>
                <li class="nav-item active">
                    <a data-bs-toggle="collapse" href="#dashboard" class="collapsed" aria-expanded="false">
                        <i class="fas fa-desktop"></i>
                        <p>Data Master</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="dashboard">
                        <ul class="nav nav-collapse">
                            <li>
                                <a href="{{ route('kategori.index') }}">
                                    <span class="sub-item">Kategori</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('satuan.index') }}">
                                    <span class="sub-item">Satuan</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('barang.index') }}">
                                    <span class="sub-item">Barang</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('personel.index') }}">
                                    <span class="sub-item">Personel</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('posisi.index') }}">
                                    <span class="sub-item">Posisi</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('gudang.index') }}">
                                    <span class="sub-item">Gudang</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a href="widgets.html">
                        <i class="fas fa-user"></i>
                        <p>User</p>
                        <span class="badge badge-success"></span>
                    </a>
                </li>



            </ul>
        </div>
    </div>
</div>
