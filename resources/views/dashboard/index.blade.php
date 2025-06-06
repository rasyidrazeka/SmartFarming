@extends('layout.template')
@section('title', 'Dashboard - Agrilink Vocpro')
@section('content')
    <div class="container-fluid">
        <div class="row">
            @foreach ($dataDHT->slice(0, 4) as $item)
                <div class="col-12 col-lg-3">
                    <div class="card text-center p-3" style="border-color: #CED4DA">
                        <div class="mb-2">
                            <i class="{{ $item['icon'] }} fs-1" style="color: #227066"></i>
                        </div>
                        <div class="fw-bold">{{ $item['label'] }}</div>
                        <div class="fs-4">{{ $item['value'] }} {{ $item['unit'] }}</div>
                    </div>
                </div>
            @endforeach
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
