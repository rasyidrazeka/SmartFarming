@extends('layout.template')
@section('title', 'Monitoring NPK - Agrilink Vocpro')
@section('content')
    <div class="container-fluid">
        <div class="d-flex align-items-end form-group row mb-0">
            <div class="form-group col-12 col-lg-3 mb-0">
                <label for="sensor_npk" class="form-label">Sensor NPK:</label>
                <div class="form-group">
                    <select class="choices form-select" name="selected_sensor_npk" id="selected_sensor_npk" required>
                        <option value="">- Semua Sensor -</option>
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
                <label for="start_date" class="form-label">Filter Tanggal:</label>
                <input type="text" class="form-control" name="daterange" id="daterange" placeholder="Masukkan tanggal">
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
                </div>

                {{-- Slide Kedua --}}
                <div class="carousel-item">
                    <div class="row">
                        @foreach ($dataNPK->slice(4, 4) as $item)
                            <div class="col-md-3">
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
            @else
                @include('visualisasiNPK.sensorAll')
            @endif
        </div>
    </div>
@endsection
@push('css')
@endpush
@push('js')
    <script>
        const npkFilter = document.getElementById('selected_sensor_npk');

        npkFilter.addEventListener('change', function() {
            const selectedValue = this.value;
            const currentUrl = new URL(window.location.href);
            currentUrl.searchParams.set('selected_sensor_npk', selectedValue);
            window.location.href = currentUrl.toString(); // Redirect ke URL baru dengan param
        });

        $('#daterange').daterangepicker({
            opens: 'left',
            autoUpdateInput: false,
            locale: {
                applyLabel: 'Pilih',
                cancelLabel: 'Batal',
                format: 'DD-MM-YYYY',
                daysOfWeek: ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'],
                monthNames: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                    'Juli', 'Agustus', 'September', 'Oktober', 'November',
                    'Desember'
                ],
            }
        });

        $('#daterange').on('apply.daterangepicker', function(ev, picker) {
            startDate = picker.startDate.format('YYYY-MM-DD');
            endDate = picker.endDate.format('YYYY-MM-DD');
            $(this).val(picker.startDate.format('DD-MM-YY') + ' ==> ' + picker.endDate.format(
                'DD-MM-YY'));
            datadhts.draw();
        });

        $('#daterange').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
            startDate = '';
            endDate = '';
            datadhts.draw();
        });
    </script>
@endpush
