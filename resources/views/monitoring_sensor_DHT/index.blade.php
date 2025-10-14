@extends('layout.template')
@section('title', 'Monitoring DHT | Agrilink Vocpro')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="form-group col-12 col-lg-3 ms-auto">
                <label for="start_date" class="form-label">Daily Average Date Range:</label>
                <input type="text" class="form-control" name="daterange" id="daterange" placeholder="Enter the date">
            </div>
        </div>
        @php
            $defaultDataDHT = collect([
                ['label' => 'Latest Update', 'value' => 'Null', 'unit' => '', 'icon' => 'bi-calendar'],
                ['label' => 'Room Temperature', 'value' => 'Null', 'unit' => '°C', 'icon' => 'bi-thermometer-half'],
                ['label' => 'Room Humidity', 'value' => 'Null', 'unit' => '%', 'icon' => 'bi-droplet-half'],
                [
                    'label' => 'Light Intensity',
                    'value' => 'Null',
                    'unit' => 'lux',
                    'icon' => 'bi-brightness-high-fill',
                ],
            ]);
            // Jika dataDHT tidak kosong, timpa default-nya
            if ($dataDHT->isNotEmpty()) {
                $defaultDataDHT = $dataDHT;
            }
        @endphp
        <div class="row">
            @foreach ($defaultDataDHT->slice(0, 4) as $item)
                <div class="col-12 col-lg-3">
                    <div class="card text-center p-3 shadow-sm">
                        <div class="mb-2">
                            <i class="{{ $item['icon'] }} fs-1" style="color: #227066"></i>
                        </div>
                        <div class="fw-bold">{{ $item['label'] }}</div>
                        <div class="fs-4">{{ $item['value'] ?? 'null' }} {{ $item['unit'] }}</div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="row">
            <div class="col-12 col-lg-6">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h6 id="titleTemperature" data-original="Room Temperature">Room Temperature</h6>
                        <div class="ratio ratio-16x9">
                            <iframe id="grafanaIframeTemperature"
                                src="http://labai.polinema.ac.id:3010/d-solo/eempvyqjk5csgf/website-visualisasi-data?orgId=1&timezone=browser&var-get_location={{ $locationId }}&var-sensor_npk=2&refresh=5s&theme=light&panelId=1&__feature.dashboardSceneSolo"
                                allowfullscreen style="display: none"></iframe>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-6">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h6 id="titleHumidity" data-original="Room Humidity">Room Humidity</h6>
                        <div class="ratio ratio-16x9">
                            <iframe id="grafanaIframeHumidity"
                                src="http://labai.polinema.ac.id:3010/d-solo/eempvyqjk5csgf/website-visualisasi-data?orgId=1&timezone=browser&var-get_location={{ $locationId }}&var-sensor_npk=2&refresh=5s&theme=light&panelId=3&__feature.dashboardSceneSolo"
                                allowfullscreen style="display: none"></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-lg-6">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h6 id="titleLuminosity" data-original="Light Density">Intensitas Cahaya</h6>
                        <div class="ratio ratio-16x9">
                            <iframe id="grafanaIframeLuminosity"
                                src="http://labai.polinema.ac.id:3010/d-solo/eempvyqjk5csgf/website-visualisasi-data?orgId=1&timezone=browser&var-get_location={{ $locationId }}&var-sensor_npk=2&refresh=5s&theme=light&panelId=4&__feature.dashboardSceneSolo"
                                allowfullscreen style="display: none"></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('css')
@endpush
@push('js')
    <script>
        window.locationId = @json($locationId);
    </script>
    <script>
        const iframeIds = [
            'grafanaIframeTemperature',
            'grafanaIframeHumidity',
            'grafanaIframeLuminosity',
        ];

        let loadedCount = 0;
        const totalIframes = iframeIds.length;

        function showAllIframes() {
            iframeIds.forEach(id => {
                const iframe = document.getElementById(id);
                if (iframe) iframe.style.display = 'block';
            });
        }

        iframeIds.forEach(id => {
            const iframe = document.getElementById(id);
            if (iframe) {
                iframe.onload = function() {
                    loadedCount++;
                    if (loadedCount === totalIframes) {
                        showAllIframes();
                    }
                };
            }
        });
    </script>

    <script>
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
            const startDate = picker.startDate.format('YYYY-MM-DD');
            const endDate = picker.endDate.format('YYYY-MM-DD');
            const today = moment().format('YYYY-MM-DD');

            if (endDate > today) {
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'error',
                    title: 'The date cannot be later than today',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                });
                $(this).val(''); // Reset input
                return;
            }

            $(this).val(picker.startDate.format('DD-MM-YY') + ' → ' + picker.endDate.format('DD-MM-YY'));
            const currentUrl = new URL(window.location.href);
            currentUrl.searchParams.set('start_date', startDate);
            currentUrl.searchParams.set('end_date', endDate);

            window.history.replaceState({}, '', currentUrl); // Update URL tanpa reload

            updateGrafanaIframe(startDate, endDate);
        });

        $('#daterange').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
            const currentUrl = new URL(window.location.href);
            currentUrl.searchParams.delete('start_date');
            currentUrl.searchParams.delete('end_date');
            window.history.replaceState({}, '', currentUrl); // Update URL tanpa reload
            defaultGrafanaIframe();
        });
    </script>

    <script>
        function updateGrafanaIframe(startDate, endDate) {
            const locationId = window.locationId;
            // Mulai dari jam 00:00:00
            const fromDate = new Date(startDate);
            fromDate.setHours(0, 0, 0, 0);
            const fromTimestamp = fromDate.getTime();

            // Sampai jam 23:00:00
            const toDate = new Date(endDate);
            toDate.setHours(23, 0, 0, 0);
            const toTimestamp = toDate.getTime();
            const baseGrafanaUrl =
                `http://labai.polinema.ac.id:3010/d-solo/aembuxu4ks5q8c/rata-rata-harian?orgId=1&from=${fromTimestamp}&to=${toTimestamp}&timezone=browser&var-location_id=${locationId}&var-sensor_npk=2&refresh=1d&theme=light&__feature.dashboardSceneSolo`;

            const panels = [{
                    id: 6,
                    elementId: "grafanaIframeTemperature"
                },
                {
                    id: 7,
                    elementId: "grafanaIframeHumidity"
                },
                {
                    id: 8,
                    elementId: "grafanaIframeLuminosity"
                }
            ];

            panels.forEach(panel => {
                const url = `${baseGrafanaUrl}&panelId=${panel.id}`;
                const iframe = document.getElementById(panel.elementId);
                if (iframe) {
                    iframe.src = url;
                }
            });

            const titleIframeIds = [
                'titleTemperature',
                'titleHumidity',
                'titleLuminosity',
            ];

            titleIframeIds.forEach(id => {
                const el = document.getElementById(id);
                if (el) {
                    const original = el.dataset.original;
                    el.innerText = 'Daily Average ' + original;
                }
            });
        }
    </script>
    <script>
        function defaultGrafanaIframe() {
            const baseGrafanaUrl =
                "http://labai.polinema.ac.id:3010/d-solo/eempvyqjk5csgf/website-visualisasi-data?orgId=1&timezone=browser&var-get_location={{ $locationId }}&var-sensor_npk=2&refresh=5s&theme=light&__feature.dashboardSceneSolo";
            const panels = [{
                    id: 1,
                    elementId: "grafanaIframeTemperature"
                },
                {
                    id: 3,
                    elementId: "grafanaIframeHumidity"
                },
                {
                    id: 4,
                    elementId: "grafanaIframeLuminosity"
                }
            ];

            panels.forEach(panel => {
                const iframe = document.getElementById(panel.elementId);
                if (iframe) {
                    iframe.src = `${baseGrafanaUrl}&panelId=${panel.id}`;
                }
            });

            const titleIframeIds = [
                'titleTemperature',
                'titleHumidity',
                'titleLuminosity',
            ];

            titleIframeIds.forEach(id => {
                const el = document.getElementById(id);
                if (el) {
                    el.innerText = el.dataset.original;
                }
            });
        }
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(window.location.search);
            const startDateParam = urlParams.get('start_date');
            const endDateParam = urlParams.get('end_date');

            if (startDateParam && endDateParam) {
                const start = moment(startDateParam, "YYYY-MM-DD");
                const end = moment(endDateParam, "YYYY-MM-DD");

                $('#daterange').data('daterangepicker').setStartDate(start);
                $('#daterange').data('daterangepicker').setEndDate(end);
                $('#daterange').val(start.format('DD-MM-YY') + ' → ' + end.format('DD-MM-YY'));

                // Ini penting agar iframe langsung update
                setTimeout(() => {
                    updateGrafanaIframe(startDateParam, endDateParam);
                }, 1000); // tambahkan delay kecil untuk memastikan iframe ada di DOM
            } else {
                defaultGrafanaIframe();
            }
        });
    </script>
@endpush
