@extends('layout.template')
@section('title', 'Contoh')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-6 col-lg-3">
                <div class="card" style="border-color: #CED4DA">
                    <div class="d-flex align-items-center row card-body">
                        <div class="col-12 col-lg-5 mb-2">
                            <x-svg-icon icon="suhu" />
                        </div>
                        <div class="col-12 col-lg-7">
                            <div class="row">
                                <h6 style="color: #227066">Temperature</h6>
                            </div>
                            <div class="row">
                                <h2 style="color: #227066">23&deg; C</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="card" style="border-color: #CED4DA">
                    <div class="d-flex align-items-center row card-body">
                        <div class="col-12 col-lg-5 mb-2">
                            <x-svg-icon icon="awan" />
                        </div>
                        <div class="col-12 col-lg-7">
                            <div class="row">
                                <h6 style="color: #227066">Tutupan Awan</h6>
                            </div>
                            <div class="row">
                                <h2 style="color: #227066">35 %</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="card" style="border-color: #CED4DA">
                    <div class="d-flex align-items-center row card-body">
                        <div class="col-12 col-lg-5 mb-2">
                            <x-svg-icon icon="angin" />
                        </div>
                        <div class="col-12 col-lg-7">
                            <div class="row">
                                <h6 style="color: #227066">Kecepatan Angin</h6>
                            </div>
                            <div class="row">
                                <h2 style="color: #227066">5 km/h</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="card" style="border-color: #CED4DA">
                    <div class="d-flex align-items-center row card-body">
                        <div class="col-12 col-lg-5 mb-2">
                            <x-svg-icon icon="cuaca" />
                        </div>
                        <div class="col-12 col-lg-7">
                            <div class="row">
                                <h6 style="color: #227066">Cuaca</h6>
                            </div>
                            <div class="row">
                                <h3 style="color: #227066">Berawan</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-12">
            <div class="card" style="border-color: #CED4DA">
                <div class="card-body">
                    <h6>Sensor DHT</h6>
                    <div class="ratio ratio-16x9">
                        <iframe
                            src="http://localhost:3000/d-solo/eempvyqjk5csgf/website-visualisasi-data?orgId=1&timezone=browser&theme=light&panelId=7&__feature.dashboardSceneSolo"
                            allowfullscreen></iframe>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-12">
            <div class="card" style="border-color: #CED4DA">
                <div class="card-body">
                    <h6>Sensor NPK 1</h6>
                    <div class="ratio ratio-16x9">
                        <iframe
                            src="http://localhost:3000/d-solo/eempvyqjk5csgf/website-visualisasi-data?orgId=1&timezone=browser&theme=light&panelId=10&__feature.dashboardSceneSolo"
                            allowfullscreen></iframe>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-12">
            <div class="card" style="border-color: #CED4DA">
                <div class="card-body">
                    <h6>Sensor NPK 2</h6>
                    <div class="ratio ratio-16x9">
                        <iframe
                            src="http://localhost:3000/d-solo/eempvyqjk5csgf/website-visualisasi-data?orgId=1&timezone=browser&theme=light&panelId=11&__feature.dashboardSceneSolo"
                            allowfullscreen></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
