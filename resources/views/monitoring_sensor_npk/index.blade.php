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
                                <h6 style="color: #227066">Cloud Cover</h6>
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
                                <h6 style="color: #227066">Wind Speed</h6>
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
                                <h6 style="color: #227066">Weather</h6>
                            </div>
                            <div class="row">
                                <h3 style="color: #227066; font-weight: 700">Sunny</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
