@extends('layout.template')
@section('title', 'Contoh')
@section('content')
    <div class="container-fluid">
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
            var datadhts = $('#table_riwayat_data_dht').DataTable({
                searching: false,
                processing: true,
                serverSide: true, // serverSide: true, jika ingin menggunakan server side processing
                responsive: true,
                ajax: {
                    "url": "{{ url('riwayatDataDHT/list') }}",
                    "dataType": "json",
                    "type": "POST",
                    // "data": function(d) {
                    //     d.barang_id = $('#barang_id').val();
                    // }
                },
                columns: [{
                    data: "DT_RowIndex", // nomor urut dari laravel datatable addIndexColumn()
                    className: "text-center",
                    orderable: false,
                    searchable: false
                }, {
                    data: "temperature",
                    className: "text-center",
                    orderable: false, // orderable: true, jika ingin kolom ini bisa diurutkan
                    searchable: false // searchable: true, jika ingin kolom ini bisa dicari
                }, {
                    data: "humidity",
                    className: "text-center",
                    orderable: false, // orderable: true, jika ingin kolom ini bisa diurutkan
                    searchable: false // searchable: true, jika ingin kolom ini bisa dicari
                }, {
                    data: "luminosity",
                    className: "text-center",
                    orderable: false, // orderable: true, jika ingin kolom ini bisa diurutkan
                    searchable: false // searchable: true, jika ingin kolom ini bisa dicari
                }, {
                    data: "sensors.sensor_name",
                    className: "text-center",
                    orderable: false, // orderable: true, jika ingin kolom ini bisa diurutkan
                    searchable: false // searchable: true, jika ingin kolom ini bisa dicari
                }, {
                    data: "created_at",
                    className: "text-center",
                    orderable: false, // orderable: true, jika ingin kolom ini bisa diurutkan
                    searchable: false // searchable: true, jika ingin kolom ini bisa dicari
                }]
            });
            // $('#barang_id').on('change', function() {
            //     dataTransaksiKeluar.ajax.reload();
            // });
        });
    </script>
@endpush
