@extends('layout.template')
@section('title', 'Contoh')
@section('content')
    <div class="container-fluid">
        <div class="d-flex align-items-end form-group row">
            <div class="form-group col-12 col-lg-3 mb-0">
                <label for="sensor_npk" class="form-label">Sensor NPK:</label>
                <div class="form-group">
                    <select class="choices form-select @error('id') is-invalid @enderror" name="selected_sensor_npk"
                        id="selected_sensor_npk" required>
                        <option value="">- Pilih Sensor -</option>
                        @foreach ($sensor_npk as $item)
                            <option value="{{ $item->id }}">
                                {{ $item->sensor_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                {{-- @if ($errors->has('id_detail_alat'))
                    <span class="text-danger">{{ $errors->first('id_detail_alat') }}</span>
                @endif --}}
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
        </div>
    </div>
    <script>
        const npkFilter = document.getElementById('selected_sensor_npk');
        const content = document.getElementById('visualisasi_data');

        npkFilter.addEventListener('change', function() {
            const selectedValue = this.value;

            if (selectedValue === '2') {
                content.innerHTML = `
                <div class="row">
            <div class="col-12 col-lg-6">
                <div class="card" style="border-color: #CED4DA">
                    <div class="card-body">
                        <h6>Soil Temperature</h6>
                        <div class="ratio ratio-16x9">
                            <iframe
                                src="http://localhost:3000/d-solo/eempvyqjk5csgf/website-visualisasi-data?orgId=1&timezone=browser&theme=light&panelId=12&__feature.dashboardSceneSolo"
                                allowfullscreen></iframe>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-6">
                <div class="card" style="border-color: #CED4DA">
                    <div class="card-body">
                        <h6>Soil Humidity</h6>
                        <div class="ratio ratio-16x9">
                            <iframe
                                src="http://localhost:3000/d-solo/eempvyqjk5csgf/website-visualisasi-data?orgId=1&timezone=browser&theme=light&panelId=13&__feature.dashboardSceneSolo"
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
                        <h6>Soil Conductivity</h6>
                        <div class="ratio ratio-16x9">
                            <iframe
                                src="http://localhost:3000/d-solo/eempvyqjk5csgf/website-visualisasi-data?orgId=1&timezone=browser&theme=light&panelId=14&__feature.dashboardSceneSolo"
                                allowfullscreen></iframe>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-6">
                <div class="card" style="border-color: #CED4DA">
                    <div class="card-body">
                        <h6>Soil pH</h6>
                        <div class="ratio ratio-16x9">
                            <iframe
                                src="http://localhost:3000/d-solo/eempvyqjk5csgf/website-visualisasi-data?orgId=1&timezone=browser&theme=light&panelId=15&__feature.dashboardSceneSolo"
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
                        <h6>Soil Nitrogen</h6>
                        <div class="ratio ratio-16x9">
                            <iframe
                                src="http://localhost:3000/d-solo/eempvyqjk5csgf/website-visualisasi-data?orgId=1&timezone=browser&theme=light&panelId=16&__feature.dashboardSceneSolo"
                                allowfullscreen></iframe>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-6">
                <div class="card" style="border-color: #CED4DA">
                    <div class="card-body">
                        <h6>Soil Phosphorus</h6>
                        <div class="ratio ratio-16x9">
                            <iframe
                                src="http://localhost:3000/d-solo/eempvyqjk5csgf/website-visualisasi-data?orgId=1&timezone=browser&theme=light&panelId=18&__feature.dashboardSceneSolo"
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
                        <h6>Soil Potassium</h6>
                        <div class="ratio ratio-16x9">
                            <iframe
                                src="http://localhost:3000/d-solo/eempvyqjk5csgf/website-visualisasi-data?orgId=1&timezone=browser&theme=light&panelId=17&__feature.dashboardSceneSolo"
                                allowfullscreen></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>`;
            } else if (selectedValue === '3') {
                content.innerHTML = `
        <div class="row">
            <div class="col-12 col-lg-6">
                <div class="card" style="border-color: #CED4DA">
                    <div class="card-body">
                        <h6>Soil Temperature</h6>
                        <div class="ratio ratio-16x9">
                            <iframe
                                src="http://localhost:3000/d-solo/eempvyqjk5csgf/website-visualisasi-data?orgId=1&timezone=browser&theme=light&panelId=19&__feature.dashboardSceneSolo"
                                allowfullscreen></iframe>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-6">
                <div class="card" style="border-color: #CED4DA">
                    <div class="card-body">
                        <h6>Soil Humidity</h6>
                        <div class="ratio ratio-16x9">
                            <iframe
                                src="http://localhost:3000/d-solo/eempvyqjk5csgf/website-visualisasi-data?orgId=1&timezone=browser&theme=light&panelId=20&__feature.dashboardSceneSolo"
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
                        <h6>Soil Conductivity</h6>
                        <div class="ratio ratio-16x9">
                            <iframe
                                src="http://localhost:3000/d-solo/eempvyqjk5csgf/website-visualisasi-data?orgId=1&timezone=browser&theme=light&panelId=21&__feature.dashboardSceneSolo"
                                allowfullscreen></iframe>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-6">
                <div class="card" style="border-color: #CED4DA">
                    <div class="card-body">
                        <h6>Soil pH</h6>
                        <div class="ratio ratio-16x9">
                            <iframe
                                src="http://localhost:3000/d-solo/eempvyqjk5csgf/website-visualisasi-data?orgId=1&timezone=browser&theme=light&panelId=22&__feature.dashboardSceneSolo"
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
                        <h6>Soil Nitrogen</h6>
                        <div class="ratio ratio-16x9">
                            <iframe
                                src="http://localhost:3000/d-solo/eempvyqjk5csgf/website-visualisasi-data?orgId=1&timezone=browser&theme=light&panelId=23&__feature.dashboardSceneSolo"
                                allowfullscreen></iframe>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-6">
                <div class="card" style="border-color: #CED4DA">
                    <div class="card-body">
                        <h6>Soil Phosphorus</h6>
                        <div class="ratio ratio-16x9">
                            <iframe
                                src="http://localhost:3000/d-solo/eempvyqjk5csgf/website-visualisasi-data?orgId=1&timezone=browser&theme=light&panelId=24&__feature.dashboardSceneSolo"
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
                        <h6>Soil Potassium</h6>
                        <div class="ratio ratio-16x9">
                            <iframe
                                src="http://localhost:3000/d-solo/eempvyqjk5csgf/website-visualisasi-data?orgId=1&timezone=browser&theme=light&panelId=25&__feature.dashboardSceneSolo"
                                allowfullscreen></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>`;
            } else {
                content.innerHTML = ''; // Kosongkan konten jika tidak ada pilihan
            }
        });
    </script>
@endsection
