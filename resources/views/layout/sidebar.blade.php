<nav class="pc-sidebar">
    <div class="navbar-wrapper">
        <div class="m-header">
            <a href="{{ route('dashboard.index') }}">
                <img src="{{ Storage::url('asset_web/logo.png') }}" class="img-fluid p-3" alt="logo">
            </a>
        </div>
        <div class="navbar-content">
            <ul class="pc-navbar">
                <li class="pc-item">
                    <a href="{{ url('/dashboard') }}" class="pc-link {{ $activeMenu == 'dashboard' ? 'active' : '' }}">
                        <span class="pc-micon"><i class="ti ti-dashboard"></i></span>
                        <span class="pc-mtext">Dasbor</span>
                    </a>
                </li>
                <li class="pc-item pc-caption">
                    <label>Sensor</label>
                    <i class="ti ti-dashboard"></i>
                </li>
                <li class="pc-item pc-hasmenu">
                    <a href="#" class="pc-link">
                        <span class="pc-micon">
                            <i class="ti ti-access-point"></i>
                        </span>
                        <span class="pc-mtext">Pemantauan Sensor</span>
                        <span class="pc-arrow">
                            <i data-feather="chevron-right"></i>
                        </span>
                    </a>
                    <ul class="pc-submenu">
                        <li class="pc-item">
                            <a class="pc-link {{ $activeMenu == 'monitoringSensorNPK' ? 'active' : '' }}"
                                href="{{ route('monitoringSensorNPK.index') }}">Sensor NPK</a>
                        </li>
                        <li class="pc-item">
                            <a class="pc-link {{ $activeMenu == 'monitoringSensorDHT' ? 'active' : '' }}"
                                href="{{ route('monitoringSensorDHT.index') }}">Sensor DHT</a>
                        </li>
                    </ul>
                </li>
                <li class="pc-item pc-hasmenu">
                    <a href="#" class="pc-link">
                        <span class="pc-micon">
                            <i class="ti ti-history"></i>
                        </span>
                        <span class="pc-mtext">Riwayat Sensor</span>
                        <span class="pc-arrow">
                            <i data-feather="chevron-right"></i>
                        </span>
                    </a>
                    <ul class="pc-submenu">
                        <li class="pc-item">
                            <a class="pc-link {{ $activeMenu == 'riwayatDataNPK' ? 'active' : '' }}"
                                href="{{ route('riwayatDataNPK.index') }}">Sensor NPK</a>
                        </li>
                        <li class="pc-item">
                            <a class="pc-link {{ $activeMenu == 'riwayatDataDHT' ? 'active' : '' }}"
                                href="{{ route('riwayatDataDHT.index') }}">Sensor DHT</a>
                        </li>
                    </ul>
                </li>
                <li class="pc-item pc-caption">
                    <label>Cuaca</label>
                    <i class="ti ti-dashboard"></i>
                </li>
                <li class="pc-item">
                    <a href="{{ route('monitoringCuaca.index') }}"
                        class="pc-link {{ $activeMenu == 'monitoringCuaca' ? 'active' : '' }}">
                        <span class="pc-micon">
                            <i class="ti ti-cloud"></i>
                        </span>
                        <span class="pc-mtext">Pemantauan Cuaca</span>
                    </a>
                </li>
                <li class="pc-item">
                    <a href="{{ route('riwayatDataCuaca.index') }}"
                        class="pc-link {{ $activeMenu == 'riwayatDataCuaca' ? 'active' : '' }}">
                        <span class="pc-micon">
                            <i class="ti ti-history"></i>
                        </span>
                        <span class="pc-mtext">Riwayat Cuaca</span>
                    </a>
                </li>
                @if (session('role_code') === 'ADMN')
                    <li class="pc-item pc-caption">
                        <label>Manajemen</label>
                        <i class="ti ti-dashboard"></i>
                    </li>
                    <li class="pc-item">
                        <a href="{{ route('kelolaPengguna.index') }}"
                            class="pc-link {{ $activeMenu == 'kelolaPengguna' ? 'active' : '' }}">
                            <span class="pc-micon">
                                <i class="ti ti-user-check"></i>
                            </span>
                            <span class="pc-mtext">Kelola Pengguna</span>
                        </a>
                    </li>
                @endif
                {{-- <li class="pc-item">
                    <a href="../elements/bc_color.html" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-color-swatch"></i></span>
                        <span class="pc-mtext">Color</span>
                    </a>
                </li>
                <li class="pc-item">
                    <a href="../elements/icon-tabler.html" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-plant-2"></i></span>
                        <span class="pc-mtext">Icons</span>
                    </a>
                </li>

                <li class="pc-item pc-caption">
                    <label>Pages</label>
                    <i class="ti ti-news"></i>
                </li>
                <li class="pc-item">
                    <a href="../pages/login.html" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-lock"></i></span>
                        <span class="pc-mtext">Login</span>
                    </a>
                </li>
                <li class="pc-item">
                    <a href="../pages/register.html" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-user-plus"></i></span>
                        <span class="pc-mtext">Register</span>
                    </a>
                </li>

                <li class="pc-item pc-caption">
                    <label>Other</label>
                    <i class="ti ti-brand-chrome"></i>
                </li>
                <li class="pc-item pc-hasmenu">
                    <a href="#!" class="pc-link"><span class="pc-micon"><i class="ti ti-menu"></i></span><span
                            class="pc-mtext">Menu
                            levels</span><span class="pc-arrow"><i data-feather="chevron-right"></i></span></a>
                    <ul class="pc-submenu">
                        <li class="pc-item"><a class="pc-link" href="#!">Level 2.1</a></li>
                        <li class="pc-item pc-hasmenu">
                            <a href="#!" class="pc-link">Level 2.2<span class="pc-arrow"><i
                                        data-feather="chevron-right"></i></span></a>
                            <ul class="pc-submenu">
                                <li class="pc-item"><a class="pc-link" href="#!">Level 3.1</a></li>
                                <li class="pc-item"><a class="pc-link" href="#!">Level 3.2</a></li>
                                <li class="pc-item pc-hasmenu">
                                    <a href="#!" class="pc-link">Level 3.3<span class="pc-arrow"><i
                                                data-feather="chevron-right"></i></span></a>
                                    <ul class="pc-submenu">
                                        <li class="pc-item"><a class="pc-link" href="#!">Level 4.1</a></li>
                                        <li class="pc-item"><a class="pc-link" href="#!">Level 4.2</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li class="pc-item pc-hasmenu">
                            <a href="#!" class="pc-link">Level 2.3<span class="pc-arrow"><i
                                        data-feather="chevron-right"></i></span></a>
                            <ul class="pc-submenu">
                                <li class="pc-item"><a class="pc-link" href="#!">Level 3.1</a></li>
                                <li class="pc-item"><a class="pc-link" href="#!">Level 3.2</a></li>
                                <li class="pc-item pc-hasmenu">
                                    <a href="#!" class="pc-link">Level 3.3<span class="pc-arrow"><i
                                                data-feather="chevron-right"></i></span></a>
                                    <ul class="pc-submenu">
                                        <li class="pc-item"><a class="pc-link" href="#!">Level 4.1</a></li>
                                        <li class="pc-item"><a class="pc-link" href="#!">Level 4.2</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li class="pc-item">
                    <a href="../other/sample-page.html" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-brand-chrome"></i></span>
                        <span class="pc-mtext">Sample page</span>
                    </a>
                </li>
            </ul> --}}
        </div>
    </div>
</nav>
