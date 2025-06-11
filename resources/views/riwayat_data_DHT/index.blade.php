@extends('layout.template')
@section('title', 'Riwayat DHT - Agrilink Vocpro')
@section('content')
    <div class="container-fluid">
        <div class="form-group col-6 col-lg-3 ms-auto">
            <label for="start_date" class="form-label">Filter Tanggal:</label>
            <input type="text" class="form-control" name="daterange" id="daterange" placeholder="Masukkan tanggal">
        </div>
        <div class="card">
            <div class="card-body">
                <table class="table align-middle table-striped table-bordered" id="table_riwayat_data_dht">
                    <thead>
                        <tr class="text-center">
                            <th class="text-center">No</th>
                            <th class="text-center">Temperature</th>
                            <th class="text-center">Humidity</th>
                            <th class="text-center">Luminosity</th>
                            <th class="text-center">sensor</th>
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

            var datadhts = $('#table_riwayat_data_dht').DataTable({
                searching: false,
                processing: true,
                serverSide: true,
                responsive: true,
                responsive: true,
                ajax: {
                    url: "{{ url('riwayatDataDHT/list') }}",
                    type: "POST",
                    data: function(d) {
                        d.start_date = startDate;
                        d.end_date = endDate;
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
                        data: "luminosity",
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
        });
    </script>
@endpush
