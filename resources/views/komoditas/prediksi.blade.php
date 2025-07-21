@extends('layout.template')
@section('title', 'Monitoring NPK | Agrilink Vocpro')
@section('content')
    <div class="container-fluid">
        <div class="d-flex align-items-end form-group row mb-0">
            <div class="form-group col-12 col-lg-6 mb-0">
                <label for="sensor_npk" class="form-label">Komoditas :</label>
                <div class="form-group">
                    <div class="d-flex flex-wrap gap-2">
                        @php
                            // Mapping nama gambar (key = nama asli dari database, value = nama file svg)
                            $iconMap = [
                                'Bawang Merah' => 'bawang-merah.svg',
                                'Bawang Putih Sinco/Honan' => 'bawang-putih.svg',
                                'Tomat Merah' => 'tomat.svg',
                                'Cabe Merah Besar' => 'cabe-besar.svg',
                                'Cabe Rawit Merah' => 'cabe-rawit.svg',
                                // Tambahkan jika ada komoditas lain
                            ];
                        @endphp
                        @foreach ($data as $item)
                            @php
                                $displayName = $item === 'Bawang Putih Sinco/Honan' ? 'Bawang Putih' : $item;
                                $icon = $iconMap[$item] ?? 'default.svg';
                            @endphp
                            <button type="button"
                                class="btn d-flex align-items-center {{ $selectedKomoditas == $item ? 'btn-secondary' : 'btn-outline-secondary' }} komoditas-btn"
                                data-value="{{ $item }}">
                                <img src="{{ asset('storage/asset_web/' . $icon) }}" alt="{{ $displayName }}"
                                    width="24" class="me-2">
                                {{ $displayName }}
                            </button>
                        @endforeach
                    </div>

                </div>
            </div>
            <div class="form-group col-12 col-lg-3 ms-auto">
                <label for="start_date" class="form-label">Tanggal diprediksi:</label>
                <input type="text" class="form-control" name="daterange" id="daterange" placeholder="Masukkan tanggal">
            </div>
        </div>
        <div class="card" style="border-color: #CED4DA">
            <div class="card-body">
                <div class="ratio ratio-16x9">
                    <iframe id="grafanaFrame"
                        src="http://labai.polinema.ac.id:3010/d-solo/aekxvuuuvs1z4d/grafik-prediksi?orgId=1&from=1748044800000&to=1760054400000&timezone=browser&var-nama_komoditas=Cabe%20Merah%20Besar&var-limit=60&var-tanggal=2025-07-13&refresh=1d&theme=light&panelId=3&__feature.dashboardSceneSolo"
                        width="450" height="200" frameborder="0"></iframe>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <div class="responsive-table-wrapper">
                    <table class="table align-middle table-striped table-bordered" id="tabel_prediksi">
                        <thead>
                            <tr class="text-center">
                                <th class="text-center">No</th>
                                <th class="text-center">Tanggal</th>
                                <th class="text-center">Prediksi</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('css')
@endpush
@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let selectedKomoditas = '{{ $selectedKomoditas ?? 'Tomat Merah' }}';
            let selectedDate = moment().format('YYYY-MM-DD');
            const iframe = document.getElementById('grafanaFrame');
            let table;

            function updateIframe() {
                const baseGrafanaURL = "http://labai.polinema.ac.id:3010/d-solo/aekxvuuuvs1z4d/tes-grafik";

                const now = new Date();
                const fromDate = new Date(now);
                fromDate.setMonth(fromDate.getMonth() - 2);
                const toDate = new Date(now);
                toDate.setMonth(toDate.getMonth() + 4);

                const from = fromDate.getTime();
                const to = toDate.getTime();

                const params = new URLSearchParams({
                    orgId: 1,
                    from: from,
                    to: to,
                    timezone: "browser",
                    'var-nama_komoditas': selectedKomoditas,
                    'var-limit': 60,
                    'var-tanggal': selectedDate,
                    theme: "light",
                    panelId: 3,
                    __feature: "dashboardSceneSolo"
                });

                iframe.src = `${baseGrafanaURL}?${params.toString()}`;
            }

            function initTable() {
                table = $('#tabel_prediksi').DataTable({
                    processing: true,
                    serverSide: false,
                    ajax: {
                        url: "{{ route('prediksi.data') }}",
                        data: function(d) {
                            d.tanggal = selectedDate;
                            d.komoditas = selectedKomoditas;
                        }
                    },
                    columns: [{
                            data: 'no',
                            className: 'text-center'
                        },
                        {
                            data: 'tanggal',
                            className: 'text-center'
                        },
                        {
                            data: 'prediksi',
                            className: 'text-center',
                            render: function(data) {
                                if (data == null) return '-';
                                const rounded = Math.floor(data / 1000) * 1000;
                                const decimal = (data - rounded).toFixed(3).split('.')[1];
                                return 'Rp ' + rounded.toLocaleString('id-ID') + ',' + decimal;
                            }
                        }
                    ]
                });
            }

            function reloadTable() {
                if (table) {
                    table.ajax.reload();
                }
            }

            // Datepicker
            $('#daterange').daterangepicker({
                singleDatePicker: true,
                showDropdowns: true,
                autoUpdateInput: true,
                locale: {
                    format: 'YYYY-MM-DD',
                    applyLabel: 'Pilih',
                    cancelLabel: 'Batal'
                }
            });

            $('#daterange').on('apply.daterangepicker', function(ev, picker) {
                selectedDate = picker.startDate.format('YYYY-MM-DD');
                updateIframe();
                reloadTable();
            });

            // Tombol komoditas
            const komoditasButtons = document.querySelectorAll('.komoditas-btn');
            komoditasButtons.forEach(button => {
                button.addEventListener('click', function() {
                    selectedKomoditas = this.dataset.value;

                    // Highlight tombol aktif
                    komoditasButtons.forEach(btn => btn.classList.remove('btn-secondary'));
                    komoditasButtons.forEach(btn => btn.classList.add('btn-outline-secondary'));
                    this.classList.remove('btn-outline-secondary');
                    this.classList.add('btn-secondary');

                    updateIframe();
                    reloadTable();
                });
            });

            // Inisialisasi awal
            $('#daterange').val(selectedDate);
            updateIframe();
            initTable();
        });
    </script>
@endpush
