@extends('backend.app')
@push('style')
    <style>
        #myTable_filter input {
            height: 29.67px !important;
        }

        #myTable_length select {
            height: 29.67px !important;
        }

        .btn {
            border-radius: 50px !important;
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: #9e9e9e21 !important;
        }

        th,
        td {
            white-space: nowrap !important;
            vertical-align: middle !important;
        }
    </style>
@endpush
@section('content')
    <div class="row" style="margin-top: -200px;">
        <div class="col-md-12">
            <div class="row">
                <div class="col-12 col-xl-8 mb-xl-0">
                    <h3 class="font-weight-bold">Data Nilai Risiko</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 mt-4">
            <div class="card w-100">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="myTable" class="table table-bordered table-striped" style="width: 100%;">
                            <thead class="bg-primary text-white">
                                <tr>
                                    <th width="5%" rowspan="2">No</th>
                                    <th colspan="4" class="border-bottom text-center">Pernyataan Risiko</th>
                                    <th rowspan="2" class="border-bottom">Sistem Pengendalian</th>
                                    <th colspan="4" class="border-bottom text-center">Level</th>
                                    <th rowspan="2" class="text-center">Mitigasi <br> (Y/T)</th>
                                </tr>
                                <tr>
                                    <th>Peristiwa</th>
                                    <th>Penyebab</th>
                                    <th>Dampak</th>
                                    <th>Kategori Risiko</th>

                                    <th>E/KE/TE</th>
                                    <th>Kemungkinan</th>
                                    <th>Dampak</th>
                                    <th>Risiko</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script src="https://cdn.datatables.net/fixedcolumns/4.2.2/js/dataTables.fixedColumns.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            getData()
        })

        function getData() {
            $("#myTable").DataTable({
                "ordering": false,
                ajax: '/data-nilai-risk',
                processing: true,
                scrollX: true,
                scrollCollapse: true,
                'language': {
                    'loadingRecords': '&nbsp;',
                    'processing': 'Loading...'
                },

                columns: [{
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        render: function(data, type, row, meta) {
                            return `<span style="
                            width: 200px !important;
                            white-space: normal;
                            display: inline-block !important;
                            ">
                            ${row.identifikasi_risiko}
                            </span>`
                        }
                    },
                    {
                        render: function(data, type, row, meta) {
                            return `<span style="
                            width: 200px !important;
                            white-space: normal;
                            display: inline-block !important;
                            ">
                            ${row.penyebab}
                            </span>`
                        }
                    },
                    {
                        render: function(data, type, row, meta) {
                            return `<span style="
                            width: 230px !important;
                            white-space: normal;
                            display: inline-block !important;
                            ">
                            ${row.dampak}
                            </span>`
                        }
                    },
                    {
                        data: 'kategori_risiko'
                    },
                    {
                        render: function(data, type, row, meta) {
                            return `<span style="
                            width: 200px !important;
                            white-space: normal;
                            display: inline-block !important;
                            ">
                            ${row.sistem_pengendalian}
                            </span>`
                        }
                    },
                    {
                        render: function(data, type, row, meta) {
                            if (row.jumlah <= 3) {
                                return 'E'
                            } else if (row.jumlah < 8) {
                                return 'KE'
                            } else if (row.jumlah >= 8) {
                                return 'TE'
                            }
                        }
                    },
                    {
                        data: 'level_kemungkinan'
                    },
                    {
                        data: 'kriteria_dampak'
                    },
                    {
                        render: function(data, type, row, meta) {
                            return row.level_kemungkinan + row.kriteria_dampak
                        }
                    },
                    {
                        render: function(data, type, row, meta) {
                            if (row.level_kemungkinan + row.kriteria_dampak > 6) {
                                return `Ya`
                            } else {
                                return 'Tidak'
                            }
                        }
                    }

                ]
            })
        }
    </script>
@endpush
