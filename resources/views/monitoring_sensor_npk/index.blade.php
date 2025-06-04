@extends('layout.template')
@section('title', 'Contoh')
@section('content')
    <div class="container-fluid">
        <div class="d-flex align-items-end form-group row">
            <div class="form-group col-12 col-lg-3 mb-0">
                <label for="sensor_npk" class="form-label">Sensor NPK:</label>
                <div class="form-group">
                    <select class="choices form-select" name="selected_sensor_npk" id="selected_sensor_npk" required>
                        <option value="">- Pilih Sensor -</option>
                        @foreach ($sensor_npk as $item)
                            <option value="{{ $item->id }}"
                                {{ request()->get('selected_sensor_npk') == $item->id ? 'selected' : '' }}>
                                {{ $item->sensor_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group col-6 col-lg-3 ms-auto">
                <label for="start_date" class="form-label">Start Date:</label>
                <input type="datetime-local" class="form-control" name="" id="">
            </div>
            <div class="form-group col-6 col-lg-3">
                <label for="start_date" class="form-label">End Date:</label>
                <input type="datetime-local" class="form-control" name="" id="">
            </div>
            <div class="form-group col-2 col-lg-1">
                <button class="btn btn-md btn-success mb-1"
                    style="color: white; background-color: #227066; border: none">Search</button>
            </div>
        </div>
        <!-- Carousel Mulai dari sini -->
        <div id="carouselNPK" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                {{-- Slide Pertama --}}
                <div class="carousel-item active">
                    <div class="row">
                        @foreach ($dataNPK->slice(0, 4) as $item)
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
                </div>

                {{-- Slide Kedua --}}
                <div class="carousel-item">
                    <div class="row">
                        @foreach ($dataNPK->slice(4, 4) as $item)
                            <div class="col-md-3">
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
                </div>
            </div>
            <!-- Navigasi -->
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselNPK" data-bs-slide="prev">
                <span class="carousel-control-prev-icon"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselNPK" data-bs-slide="next">
                <span class="carousel-control-next-icon"></span>
            </button>
        </div>
        <div id="visualisasi_data">
            @php
                $selectedSensor = request()->get('selected_sensor_npk');
            @endphp

            @if ($selectedSensor == '2')
                @include('visualisasiNPK.sensor1');
            @elseif ($selectedSensor == '3')
                @include('visualisasiNPK.sensor2')
            @endif
        </div>
    </div>
    <script>
        const npkFilter = document.getElementById('selected_sensor_npk');

        npkFilter.addEventListener('change', function() {
            const selectedValue = this.value;
            const currentUrl = new URL(window.location.href);
            currentUrl.searchParams.set('selected_sensor_npk', selectedValue);
            window.location.href = currentUrl.toString(); // Redirect ke URL baru dengan param
        });
    </script>
@endsection
