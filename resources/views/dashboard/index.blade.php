@extends('layout.template')
@section('title', 'Dashboard | Agrilink Vocpro')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="form-group col-12 col-lg-3 ms-auto">
                <label for="start_date" class="form-label">Daily Average Date Range:</label>
                <input type="text" class="form-control" name="daterange" id="daterange" placeholder="Enter the date">
            </div>
        </div>
        <div class="row">
            @foreach ($weatherData->slice(0, 4) as $item)
                <div class="col-12 col-lg-3">
                    <div class="card text-center p-3 shadow-sm">
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
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6 id="titleDht" data-original="DHT Sensor">DHT Sensor</h6>
                    <div class="ratio ratio-16x9">
                        <iframe id="grafanaIframeDhts"
                            src="http://labai.polinema.ac.id:3010/d-solo/eempvyqjk5csgf/website-visualisasi-data?orgId=1&timezone=browser&var-get_location={{ $locationId }}&refresh=5s&var-query0=&var-sensor_npk=3&theme=light&panelId=7&__feature.dashboardSceneSolo"
                            allowfullscreen style="display: none"></iframe>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6 id="titleNpk1" data-original="NPK Sensor 1">NPK Sensor 1</h6>
                    <div class="ratio ratio-16x9">
                        <iframe id="grafanaIframeNpks1"
                            src="http://labai.polinema.ac.id:3010/d-solo/eempvyqjk5csgf/website-visualisasi-data?orgId=1&timezone=browser&var-get_location={{ $locationId }}&refresh=5s&var-query0=&editIndex=1&var-sensor_npk=2&theme=light&panelId=10&__feature.dashboardSceneSolo"
                            allowfullscreen style="display: none">
                        </iframe>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6 id="titleNpk2" data-original="NPK Sensor 2">NPK Sensor 2</h6>
                    <div class="ratio ratio-16x9">
                        <iframe id="grafanaIframeNpks2"
                            src="http://labai.polinema.ac.id:3010/d-solo/eempvyqjk5csgf/website-visualisasi-data?orgId=1&timezone=browser&var-get_location={{ $locationId }}&refresh=5s&var-query0=&editIndex=1&var-sensor_npk=3&theme=light&panelId=10&__feature.dashboardSceneSolo"
                            allowfullscreen style="display: none"></iframe>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6 id="titleCuaca" data-original="Cuaca">Current Weather</h6>
                    <div class="ratio ratio-16x9">
                        <iframe id="grafanaIframeCuaca"
                            src="http://labai.polinema.ac.id:3010/d-solo/8e8fc548-1ffd-4056-bc61-b38357d2d30a/cuaca-terkini?orgId=1&timezone=browser&refresh=1h&var-location_id={{ $locationId }}&editIndex=0&theme=light&panelId=6&__feature.dashboardSceneSolo"
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
        $('#daterange').daterangepicker({
            opens: 'left',
            autoUpdateInput: false,
            locale: {
                applyLabel: 'Apply',
                cancelLabel: 'Cancel',
                format: 'DD-MM-YYYY',
                daysOfWeek: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
                monthNames: ['January', 'February', 'March', 'April', 'May', 'June',
                    'July', 'August', 'September', 'October', 'November',
                    'December'
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
        const iframeIds = [
            'grafanaIframeDhts',
            'grafanaIframeNpks1',
            'grafanaIframeNpks2',
            'grafanaIframeCuaca',
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

            const dhtsIframe = document.getElementById('grafanaIframeDhts');
            if (dhtsIframe) {
                const dhtsUrl =
                    `http://labai.polinema.ac.id:3010/d-solo/aembuxu4ks5q8c/rata-rata-harian?orgId=1&from=${fromTimestamp}&to=${toTimestamp}&timezone=browser&var-location_id=${locationId}&refresh=1d&var-query0=&editIndex=1&var-sensor_npk=2&theme=light&panelId=1&__feature.dashboardSceneSolo`;
                dhtsIframe.src = dhtsUrl;
            }

            const npks1Iframe = document.getElementById('grafanaIframeNpks1');
            if (npks1Iframe) {
                const npks1Url =
                    `http://labai.polinema.ac.id:3010/d-solo/aembuxu4ks5q8c/rata-rata-harian?orgId=1&from=${fromTimestamp}&to=${toTimestamp}&timezone=browser&var-location_id=${locationId}&refresh=1d&var-query0=&editIndex=1&var-sensor_npk=2&theme=light&panelId=3&__feature.dashboardSceneSolo`;
                npks1Iframe.src = npks1Url;
            }

            const npks2Iframe = document.getElementById('grafanaIframeNpks2');
            if (npks2Iframe) {
                const npks2Url =
                    `http://labai.polinema.ac.id:3010/d-solo/aembuxu4ks5q8c/rata-rata-harian?orgId=1&from=${fromTimestamp}&to=${toTimestamp}&timezone=browser&var-location_id=${locationId}&refresh=1d&var-query0=&editIndex=1&var-sensor_npk=3&theme=light&panelId=3&__feature.dashboardSceneSolo`;
                npks2Iframe.src = npks2Url;
            }

            const cuacaIframe = document.getElementById('grafanaIframeCuaca');
            if (cuacaIframe) {
                const cuacaUrl =
                    `http://labai.polinema.ac.id:3010/d-solo/8e8fc548-1ffd-4056-bc61-b38357d2d30a/cuaca-terkini` +
                    `?orgId=1&timezone=browser&from=${fromTimestamp}&to=${toTimestamp}` +
                    `&refresh=1h&var-location_id=${locationId}&editIndex=0&theme=light&panelId=6&__feature.dashboardSceneSolo`;
                cuacaIframe.src = cuacaUrl;
            }

            const titleIframeIds = ['titleNpk1', 'titleNpk2', 'titleDht'];
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
            const locationId = window.locationId;
            const grafanaEmbedUrlDhts =
                "http://labai.polinema.ac.id:3010/d-solo/eempvyqjk5csgf/website-visualisasi-data?orgId=1&timezone=browser&var-get_location={{ $locationId }}&refresh=5s&var-query0=&var-sensor_npk=3&theme=light&panelId=7&__feature.dashboardSceneSolo"; // URL dasbor Grafana
            // Update URL iframe dengan parameter waktu
            document.getElementById('grafanaIframeDhts').src = grafanaEmbedUrlDhts;

            const grafanaEmbedUrlNpks1 =
                "http://labai.polinema.ac.id:3010/d-solo/eempvyqjk5csgf/website-visualisasi-data?orgId=1&timezone=browser&var-get_location={{ $locationId }}&refresh=5s&var-query0=&editIndex=1&var-sensor_npk=2&theme=light&panelId=10&__feature.dashboardSceneSolo"; // URL dasbor Grafana
            // Update URL iframe dengan parameter waktu
            document.getElementById('grafanaIframeNpks1').src = grafanaEmbedUrlNpks1;

            const grafanaEmbedUrlNpks2 =
                "http://labai.polinema.ac.id:3010/d-solo/eempvyqjk5csgf/website-visualisasi-data?orgId=1&timezone=browser&var-get_location={{ $locationId }}&refresh=5s&var-query0=&editIndex=1&var-sensor_npk=3&theme=light&panelId=10&__feature.dashboardSceneSolo"; // URL dasbor Grafana
            // Update URL iframe dengan parameter waktu
            document.getElementById('grafanaIframeNpks2').src = grafanaEmbedUrlNpks2;

            const grafanaEmbedUrlCuaca =
                "http://labai.polinema.ac.id:3010/d-solo/8e8fc548-1ffd-4056-bc61-b38357d2d30a/cuaca-terkini?orgId=1&timezone=browser&refresh=1h&var-location_id={{ $locationId }}&editIndex=0&theme=light&panelId=6&__feature.dashboardSceneSolo"; // URL dasbor Grafana
            document.getElementById('grafanaIframeCuaca').src = grafanaEmbedUrlCuaca;

            const titleIframeIds = [
                'titleDht',
                'titleNpk1',
                'titleNpk2',
            ];

            titleIframeIds.forEach(id => {
                const el = document.getElementById(id);
                if (el) {
                    el.innerText = el.dataset.original;
                }
            });
        }
    </script>
    {{-- <script>
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
    </script> --}}
@endpush
