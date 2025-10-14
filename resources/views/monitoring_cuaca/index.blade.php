@extends('layout.template')
@section('title', 'Monitoring Cuaca | Agrilink Vocpro')
@section('content')
    <div class="container-fluid">
        @php
            $fromPrediksi = now()->startOfDay()->timestamp * 1000;
            $toPrediksi = now()->addDays(3)->endOfDay()->timestamp * 1000;

            // URL dasar tanpa var-lokasi
            $temperatureUrl =
                'http://labai.polinema.ac.id:3010/d-solo/cept647sue8e8f/cuaca' .
                '?orgId=1' .
                "&from={$fromPrediksi}" .
                "&to={$toPrediksi}" .
                '&timezone=browser' .
                '&theme=light' .
                '&panelId=1' .
                '&__feature.dashboardSceneSolo';

            $cloudCoverUrl =
                'http://labai.polinema.ac.id:3010/d-solo/cept647sue8e8f/cuaca' .
                '?orgId=1' .
                "&from={$fromPrediksi}" .
                "&to={$toPrediksi}" .
                '&timezone=browser' .
                '&theme=light' .
                '&panelId=2' .
                '&__feature.dashboardSceneSolo';

            $windSpeedUrl =
                'http://labai.polinema.ac.id:3010/d-solo/cept647sue8e8f/cuaca' .
                '?orgId=1' .
                "&from={$fromPrediksi}" .
                "&to={$toPrediksi}" .
                '&timezone=browser' .
                '&theme=light' .
                '&panelId=3' .
                '&__feature.dashboardSceneSolo';

            $weatherUrl =
                'http://labai.polinema.ac.id:3010/d-solo/cept647sue8e8f/cuaca' .
                '?orgId=1' .
                "&from={$fromPrediksi}" .
                "&to={$toPrediksi}" .
                '&timezone=browser' .
                '&theme=light' .
                '&panelId=4' .
                '&__feature.dashboardSceneSolo';
        @endphp
        <div class="row">
            <div class="form-group col-12 col-lg-3 ms-auto">
                <label for="start_date" class="form-label">Date Range:</label>
                <input type="text" class="form-control" name="daterange" id="daterange" placeholder="Enter the date">
            </div>
        </div>
        {{-- <div class="row">
            @foreach ($weatherData->slice(0, 4) as $item)
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
        </div> --}}
        <div class="row">
            <div class="col-12 col-lg-7">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="d-flex flex-column mb-1">
                            <div class="p-0">
                                <h6 class="m-0 p-0" style="font-weight: 600">Current Weather</h6>
                            </div>
                            <div class="p-0">
                                <small class="m-0 p-0" id="currentTime"></small>
                            </div>
                            <div class="p-0">
                                <div class="d-flex flex-row align-items-center p-0">
                                    <div class="p-0 pe-3">
                                        @if ($latestData)
                                            <i class="bi {{ $ikonCuaca }}" style="color: #227066; font-size: 90px"></i>
                                        @endif
                                    </div>
                                    <div class="p-0 pe-0">
                                        <h1 class="m-0" style="font-size: 60px; font-weight: 500;">
                                            {{ intval($latestData->temperature_2m) }}</h1>
                                    </div>
                                    <div class="ps-0 pb-0 pe-3 align-self-start" style="padding-top: 2.4rem">
                                        <h1 class="m-0" style="font-size: 30px; font-weight: 500;">°C</h1>
                                    </div>
                                    <div class="border-start border-3 border-secondary" style="height: 65px;"></div>
                                    <div class="d-flex align-items-start flex-column p-0 pe-2 ps-3">
                                        <h2>{{ $deskripsiCuaca }}</h2>
                                        <h5>Greenhouse {{ $locationName }}</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="container text-center">
                            <div class="row">
                                <div class="col p-0">
                                    <div class="d-flex flex-column mb-1 align-items-start">
                                        <div class="p-1 pb-0">Temperature</div>
                                        <div class="p-1">{{ $latestData->temperature_2m }}° C</div>
                                    </div>
                                </div>
                                <div class="col p-0">
                                    <div class="d-flex flex-column mb-1 align-items-start">
                                        <div class="p-1 pb-0">Cloud Cover</div>
                                        <div class="p-1">{{ $latestData->cloud_cover }}%</div>
                                    </div>
                                </div>
                                <div class="col p-0">
                                    <div class="d-flex flex-column mb-1 align-items-start">
                                        <div class="p-1 pb-0">Wind Speed</div>
                                        <div class="p-1">{{ $latestData->wind_speed_10m }} km/h</div>
                                    </div>
                                </div>
                                <div class="col p-0">
                                    <div class="d-flex flex-column mb-1 align-items-start">
                                        <div class="p-1 pb-0">Weather</div>
                                        <div class="p-1">{{ $deskripsiCuaca }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-5">
                <div class="card shadow-sm">
                    <div class="card-body p-0">
                        <div class="ratio ratio-16x9" style="height: 285px">
                            <iframe
                                src="http://labai.polinema.ac.id:3010/d-solo/cept647sue8e8f/cuaca?orgId=1&timezone=browser&refresh=1h&theme=light&panelId=6&__feature.dashboardSceneSolo"
                                allowfullscreen></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row row-cols-2 row-cols-md-3 row-cols-lg-6 g-2">
            @foreach ($forecastData as $data)
                <div class="col">
                    <div class="card text-center shadow-sm" style="border-radius: 15px;">
                        <div class="card-body p-2">
                            <h6 class="mb-1">{{ \Carbon\Carbon::parse($data->date)->format('D') }}</h6>
                            <i class="bi {{ $data->icon }}" style="font-size: 35px; color:#227066;"></i>
                            <h5 class="my-1">{{ $data->avg_temp }}°C</h5>
                            <small class="text-muted">{{ $data->description }}</small>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="row">
            <div class="col-12 col-lg-6">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h6 id="titleTemperature" data-original="Temperature">Temperature</h6>
                        <div class="ratio ratio-16x9">
                            <iframe id="grafanaIframeTemperature" allowfullscreen style="display:none"></iframe>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-6">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h6 id="titleCloudCover" data-original="Cloud Cover">Cloud Cover</h6>
                        <div class="ratio ratio-16x9">
                            {{-- <iframe id="grafanaIframeCloudCover"
                                src="http://labai.polinema.ac.id:3010/d-solo/cept647sue8e8f/cuaca?orgId=1&timezone=browser&var-location_id={{ $locationId }}&refresh=1h&theme=light&panelId=2&__feature.dashboardSceneSolo"
                                allowfullscreen style="display: none"></iframe> --}}
                            <iframe id="grafanaIframeCloudCover" allowfullscreen style="display:none"></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-lg-6">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h6 id="titleWindSpeed" data-original="Wind Speed">Wind Speed</h6>
                        <div class="ratio ratio-16x9">
                            {{-- <iframe id="grafanaIframeWindSpeed"
                                src="http://labai.polinema.ac.id:3010/d-solo/cept647sue8e8f/cuaca?orgId=1&timezone=browser&var-location_id={{ $locationId }}&refresh=1h&theme=light&panelId=3&__feature.dashboardSceneSolo"
                                allowfullscreen style="display: none"></iframe> --}}
                            <iframe id="grafanaIframeWindSpeed" allowfullscreen style="display:none"></iframe>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-6">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h6 id="titleWeather" data-original="Weather">Weather</h6>
                        <div class="ratio ratio-16x9">
                            {{-- <iframe id="grafanaIframeWeather"
                                src="http://labai.polinema.ac.id:3010/d-solo/cept647sue8e8f/cuaca?orgId=1&timezone=browser&var-location_id={{ $locationId }}&refresh=1h&theme=light&panelId=4&__feature.dashboardSceneSolo"
                                allowfullscreen style="display: none"></iframe> --}}
                            <iframe id="grafanaIframeWeather" allowfullscreen style="display:none"></iframe>
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

        document.addEventListener("DOMContentLoaded", function() {
            let tempUrl = @json($temperatureUrl) + "&var-location_id=" + window.locationId;
            document.getElementById("grafanaIframeTemperature").src = tempUrl;

            let cloudCoverUrl = @json($cloudCoverUrl) + "&var-location_id=" + window.locationId;
            document.getElementById("grafanaIframeCloudCover").src = cloudCoverUrl;

            let windSpeedUrl = @json($windSpeedUrl) + "&var-location_id=" + window.locationId;
            document.getElementById("grafanaIframeWindSpeed").src = windSpeedUrl;

            let weatherUrl = @json($weatherUrl) + "&var-location_id=" + window.locationId;
            document.getElementById("grafanaIframeWeather").src = weatherUrl;
        });
    </script>
    <script>
        const iframeIds = [
            'grafanaIframeTemperature',
            'grafanaIframeCloudCover',
            'grafanaIframeWindSpeed',
            'grafanaIframeWeather'
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

            // if (endDate > today) {
            //     Swal.fire({
            //         toast: true,
            //         position: 'top-end',
            //         icon: 'error',
            //         title: 'Tanggal tidak boleh lebih dari hari ini',
            //         showConfirmButton: false,
            //         timer: 3000,
            //         timerProgressBar: true,
            //     });
            //     $(this).val(''); // Reset input
            //     return;
            // }

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
                `http://labai.polinema.ac.id:3010/d-solo/cept647sue8e8f/cuaca?orgId=1&from=${fromTimestamp}&to=${toTimestamp}&timezone=browser&var-location_id=${locationId}&refresh=1h&theme=light&__feature.dashboardSceneSolo`;

            const panels = [{
                    id: 1,
                    elementId: "grafanaIframeTemperature"
                },
                {
                    id: 2,
                    elementId: "grafanaIframeCloudCover"
                },
                {
                    id: 3,
                    elementId: "grafanaIframeWindSpeed"
                },
                {
                    id: 4,
                    elementId: "grafanaIframeWeather"
                }
            ];

            panels.forEach(panel => {
                const url = `${baseGrafanaUrl}&panelId=${panel.id}`;
                const iframe = document.getElementById(panel.elementId);
                if (iframe) {
                    iframe.src = url;
                }
            });
        }
    </script>

    <script>
        function defaultGrafanaIframe() {
            const fromPrediksi = {{ $fromPrediksi }};
            const toPrediksi = {{ $toPrediksi }};
            const locationId = window.locationId;

            const baseGrafanaUrl =
                "http://labai.polinema.ac.id:3010/d-solo/cept647sue8e8f/cuaca" +
                `?orgId=1&timezone=browser&var-location_id=${locationId}&refresh=1h&theme=light` +
                `&from=${fromPrediksi}&to=${toPrediksi}&__feature.dashboardSceneSolo`;

            const panels = [{
                    id: 1,
                    elementId: "grafanaIframeTemperature"
                },
                {
                    id: 2,
                    elementId: "grafanaIframeCloudCover"
                },
                {
                    id: 3,
                    elementId: "grafanaIframeWindSpeed"
                },
                {
                    id: 4,
                    elementId: "grafanaIframeWeather"
                }
            ];

            panels.forEach(panel => {
                const iframe = document.getElementById(panel.elementId);
                if (iframe) {
                    iframe.src = `${baseGrafanaUrl}&panelId=${panel.id}`;
                }
            });
        }

        // jalan otomatis ketika halaman selesai load
        document.addEventListener("DOMContentLoaded", defaultGrafanaIframe);
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
    <script>
        function updateTime() {
            const now = new Date();
            const options = {
                weekday: 'long',
                day: '2-digit',
                month: 'long',
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            };
            const formatted = now.toLocaleString('en-US', options);
            document.getElementById('currentTime').textContent = formatted;
        }

        setInterval(updateTime, 1000);
        updateTime(); // Jalankan saat pertama kali
    </script>
@endpush
