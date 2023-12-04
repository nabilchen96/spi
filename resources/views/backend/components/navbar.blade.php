<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item">
            <a class="nav-link" href="{{ url('dashboard') }}">
                <i class="icon-grid menu-icon"></i>
                <span class="menu-title">Dashboard</span>
            </a>

        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
                <i class="icon-layout menu-icon"></i>
                <span class="menu-title" style="margin-top: 7px;">Master</span>
                <i style="margin-top: 7px;" class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-basic">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('user') }}">
                            <span class="menu-title">User</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('halaman-kecamatan') }}">
                            <span class="menu-title">Matrik</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('kelurahan') }}">
                            <span class="menu-title">Periode</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('kelurahan') }}">
                            <span class="menu-title">Unit</span>
                        </a>
                    </li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="">
                <i class="bi bi-window-plus menu-icon"></i>
                <span class="menu-title">Risiko</span>
            </a>

        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#mrisiko" aria-expanded="false" aria-controls="ui-basic">
                <i class="bi bi-bar-chart menu-icon"></i>
                <span class="menu-title" style="margin-top: 7px;">Nilai Risiko</span>
                <i style="margin-top: 7px;" class="menu-arrow"></i>
            </a>
            <div class="collapse" id="mrisiko">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('halaman-kecamatan') }}">
                            <span class="menu-title">Nilai Efektivitas</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('halaman-kecamatan') }}">
                            <span class="menu-title">Kemungkinan</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('halaman-kecamatan') }}">
                            <span class="menu-title">Dampak</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('halaman-dapil') }}">
                            <span class="menu-title">Profil Risiko</span>
                        </a>
                    </li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#penanganan" aria-expanded="false" aria-controls="ui-basic">
                <i class="bi bi-gear menu-icon"></i>
                <span class="menu-title" style="margin-top: 7px;">Penanganan</span>
                <i style="margin-top: 7px;" class="menu-arrow"></i>
            </a>
            <div class="collapse" id="penanganan">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('halaman-dapil') }}">
                            <span class="menu-title">Renc. Penanganan</span>
                        </a>
                    </li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="">
                <i class="bi bi-folder-plus menu-icon"></i>
                <span class="menu-title">Berkas Audit</span>
            </a>

        </li>
    </ul>
</nav>
