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
                        <span class="pc-mtext">Dashboard</span>
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
                        <span class="pc-mtext">Sensor Monitoring</span>
                        <span class="pc-arrow">
                            <i data-feather="chevron-right"></i>
                        </span>
                    </a>
                    <ul class="pc-submenu">
                        <li class="pc-item">
                            <a class="pc-link {{ $activeMenu == 'monitoringSensorNPK' ? 'active' : '' }}"
                                href="{{ route('monitoringSensorNPK.index') }}">NPK Sensor</a>
                        </li>
                        <li class="pc-item">
                            <a class="pc-link {{ $activeMenu == 'monitoringSensorDHT' ? 'active' : '' }}"
                                href="{{ route('monitoringSensorDHT.index') }}">DHT Sensor</a>
                        </li>
                    </ul>
                </li>
                <li class="pc-item pc-hasmenu">
                    <a href="#" class="pc-link">
                        <span class="pc-micon">
                            <i class="ti ti-history"></i>
                        </span>
                        <span class="pc-mtext">Sensor Data History</span>
                        <span class="pc-arrow">
                            <i data-feather="chevron-right"></i>
                        </span>
                    </a>
                    <ul class="pc-submenu">
                        <li class="pc-item">
                            <a class="pc-link {{ $activeMenu == 'riwayatDataNPK' ? 'active' : '' }}"
                                href="{{ route('riwayatDataNPK.index') }}">NPK Sensor</a>
                        </li>
                        <li class="pc-item">
                            <a class="pc-link {{ $activeMenu == 'riwayatDataDHT' ? 'active' : '' }}"
                                href="{{ route('riwayatDataDHT.index') }}">DHT Sensor</a>
                        </li>
                    </ul>
                </li>
                <li class="pc-item pc-caption">
                    <label>Weather</label>
                    <i class="ti ti-dashboard"></i>
                </li>
                <li class="pc-item pc-hasmenu">
                    <a href="#" class="pc-link">
                        <span class="pc-micon">
                            <i class="ti ti-cloud"></i>
                        </span>
                        <span class="pc-mtext">Weather Monitoring</span>
                        <span class="pc-arrow">
                            <i data-feather="chevron-right"></i>
                        </span>
                    </a>
                    <ul class="pc-submenu">
                        <li class="pc-item">
                            <a class="pc-link {{ $activeMenu == 'monitoringCuaca' ? 'active' : '' }}"
                                href="{{ route('monitoringCuaca.index') }}">Weather Forecast</a>
                        </li>
                        <li class="pc-item">
                            <a class="pc-link {{ $activeMenu == 'cuacaTerkini' ? 'active' : '' }}"
                                href="{{ route('cuacaTerkini.index') }}">Current Weather</a>
                        </li>
                    </ul>
                </li>
                <li class="pc-item">
                    <a href="{{ route('riwayatDataCuaca.index') }}"
                        class="pc-link {{ $activeMenu == 'riwayatDataCuaca' ? 'active' : '' }}">
                        <span class="pc-micon">
                            <i class="ti ti-history"></i>
                        </span>
                        <span class="pc-mtext">Weather Forecast History</span>
                    </a>
                </li>
                <li class="pc-item pc-caption">
                    <label>Commodity</label>
                    <i class="ti ti-dashboard"></i>
                </li>
                <li class="pc-item pc-hasmenu">
                    <a href="#" class="pc-link">
                        <span class="pc-micon">
                            <i class="bi bi-bar-chart-line"></i>
                        </span>
                        <span class="pc-mtext">Commodity Prices</span>
                        <span class="pc-arrow">
                            <i data-feather="chevron-right"></i>
                        </span>
                    </a>
                    <ul class="pc-submenu">
                        <li class="pc-item">
                            <a class="pc-link {{ $activeMenu == 'prediksiHarga' ? 'active' : '' }}"
                                href="{{ route('komoditas.prediksi') }}">Price Prediction</a>
                        </li>
                        <li class="pc-item">
                            <a class="pc-link {{ $activeMenu == 'trendHarga' ? 'active' : '' }}"
                                href="{{ route('komoditas.trend') }}">Price Trend</a>
                        </li>
                        <li class="pc-item">
                            <a class="pc-link {{ $activeMenu == 'riwayatHarga' ? 'active' : '' }}"
                                href="{{ route('komoditas.riwayat') }}">Price History</a>
                        </li>
                    </ul>
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
            </ul>
        </div>
    </div>
</nav>
