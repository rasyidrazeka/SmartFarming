@extends('layout.template')
@section('title', 'Contoh')
@section('content')
    <div class="container-fluid">
        <div class="row">
            @foreach ($dataDHT->slice(0, 4) as $item)
                <div class="col-12 col-lg-3">
                    <div class="card text-center p-3 border">
                        <div class="mb-2">
                            <i class="{{ $item['icon'] }} fs-1" style="color: #227066"></i>
                        </div>
                        <div class="fw-bold">{{ $item['label'] }}</div>
                        <div class="fs-4">{{ $item['value'] }} {{ $item['unit'] }}</div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="row">
            <div class="col-12 col-lg-6">
                <div class="card" style="border-color: #CED4DA">
                    <div class="card-body">
                        <h6>Room Temperature</h6>
                        <div class="ratio ratio-16x9">
                            <iframe
                                src="http://localhost:3000/d-solo/eempvyqjk5csgf/website-visualisasi-data?orgId=1&timezone=browser&theme=light&panelId=1&__feature.dashboardSceneSolo"
                                allowfullscreen></iframe>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-6">
                <div class="card" style="border-color: #CED4DA">
                    <div class="card-body">
                        <h6>Room Humidity</h6>
                        <div class="ratio ratio-16x9">
                            <iframe
                                src="http://localhost:3000/d-solo/eempvyqjk5csgf/website-visualisasi-data?orgId=1&timezone=browser&theme=light&panelId=3&__feature.dashboardSceneSolo"
                                allowfullscreen></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-lg-6">
                <div class="card" style="border-color: #CED4DA">
                    <div class="card-body">
                        <h6>Luminosity</h6>
                        <div class="ratio ratio-16x9">
                            <iframe
                                src="http://localhost:3000/d-solo/eempvyqjk5csgf/website-visualisasi-data?orgId=1&timezone=browser&theme=light&panelId=4&__feature.dashboardSceneSolo"
                                allowfullscreen></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
