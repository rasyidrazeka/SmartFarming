@extends('layout.template')
@section('title', 'Riwayat NPK - Agrilink Vocpro')
@section('content')
    <div class="container-fluid">
        <div class="row">
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
        <div class="card">
            <div class="card-body">
                <table class="table align-middle table-striped table-bordered" id="table_riwayat_data_npk">
                    <thead>
                        <tr class="text-center">
                            <th class="text-center">No</th>
                            <th class="text-center">Temperature</th>
                            <th class="text-center">Humidity</th>
                            <th class="text-center">Conductivity</th>
                            <th class="text-center">pH</th>
                            <th class="text-center">Nitrogen</th>
                            <th class="text-center">Phosphorus</th>
                            <th class="text-center">Potassium</th>
                            <th class="text-center">Sensor</th>
                            <th class="text-center">Tanggal</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        $(document).ready(function() {
            let startDate = '';
            let endDate = '';

            var datadhts = $('#table_riwayat_data_npk').DataTable({
                searching: false,
                processing: true,
                serverSide: true,
                responsive: true,
                responsive: true,
                ajax: {
                    url: "{{ route('riwayatDataNPK.list') }}",
                    type: "POST",
                    data: function(d) {
                        d.start_date = startDate;
                        d.end_date = endDate;
                        d.selected_sensor_npk = $('#selected_sensor_npk').val();
                    }
                },
                columns: [{
                        data: "DT_RowIndex",
                        className: "text-center",
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: "temperature",
                        className: "text-center",
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: "humidity",
                        className: "text-center",
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: "conductivity",
                        className: "text-center",
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: "ph",
                        className: "text-center",
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: "nitrogen",
                        className: "text-center",
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: "phosphorus",
                        className: "text-center",
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: "potassium",
                        className: "text-center",
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: "sensors.sensor_name",
                        className: "text-center",
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: "created_at",
                        className: "text-center",
                        orderable: false,
                        searchable: false
                    }
                ]
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
                $(this).val(picker.startDate.format('DD-MM-YY') + ' → ' + picker.endDate.format(
                    'DD-MM-YY'));
                datadhts.draw();
            });

            $('#daterange').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
                startDate = '';
                endDate = '';
                datadhts.draw();
            });
            $('#selected_sensor_npk').on('change', function() {
                datadhts.draw(); // Reload tabel dengan filter baru
            });
        });
    </script>
@endpush
