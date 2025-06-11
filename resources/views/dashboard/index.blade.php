@extends('layout.template')
@section('title', 'Dashboard - Agrilink Vocpro')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="form-group col-6 col-lg-3 ms-auto">
                <label for="start_date" class="form-label">Filter Tanggal:</label>
                <input type="text" class="form-control" name="daterange" id="daterange" placeholder="Masukkan tanggal">
            </div>
        </div>
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
                        <iframe id="grafanaIframeDhts"
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
                        <iframe id="grafanaIframeNpks1"
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
                        <iframe id="grafanaIframeNpks2"
                            src="http://localhost:3000/d-solo/eempvyqjk5csgf/website-visualisasi-data?orgId=1&timezone=browser&theme=light&panelId=11&__feature.dashboardSceneSolo"
                            allowfullscreen></iframe>
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
            $(this).val(picker.startDate.format('DD-MM-YY') + ' → ' + picker.endDate.format(
                'DD-MM-YY'));
            updateGrafanaIframe(startDate, endDate);
        });

        $('#daterange').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
            startDate = '';
            endDate = '';
            updateGrafanaIframe(startDate, endDate);
        });
    </script>
    <script>
        function updateGrafanaIframe(startDate, endDate) {
            const fromTimestamp = new Date(startDate).getTime(); // Konversi ke timestamp (ms)
            const toTimestamp = new Date(endDate).getTime(); // Konversi ke timestamp (ms)

            const grafanaEmbedUrlDhts =
                "http://localhost:3000/d-solo/aembuxu4ks5q8c/rata-rata-harian?orgId=1"; // URL dasbor Grafana
            // Update URL iframe dengan parameter waktu
            const dhtsGrafana =
                `${grafanaEmbedUrlDhts}&from=${fromTimestamp}&to=${toTimestamp}&timezone=browser&refresh=1d&theme=light&panelId=1&__feature.dashboardSceneSolo`;
            document.getElementById('grafanaIframeDhts').src = dhtsGrafana;

            const grafanaEmbedUrlNpks1 =
                "http://localhost:3000/d-solo/aembuxu4ks5q8c/rata-rata-harian?orgId=1"; // URL dasbor Grafana
            // Update URL iframe dengan parameter waktu
            const npks1Grafana =
                `${grafanaEmbedUrlDhts}&from=${fromTimestamp}&to=${toTimestamp}&timezone=browser&refresh=1d&theme=light&panelId=3&__feature.dashboardSceneSolo`;
            document.getElementById('grafanaIframeNpks1').src = npks1Grafana;

            const grafanaEmbedUrlNpks2 =
                "http://localhost:3000/d-solo/aembuxu4ks5q8c/rata-rata-harian?orgId=1"; // URL dasbor Grafana
            // Update URL iframe dengan parameter waktu
            const npks2Grafana =
                `${grafanaEmbedUrlDhts}&from=${fromTimestamp}&to=${toTimestamp}&timezone=browser&refresh=1d&theme=light&panelId=4&__feature.dashboardSceneSolo`;
            document.getElementById('grafanaIframeNpks2').src = npks2Grafana;
        }
    </script>
@endpush
