@extends('backend.app')
@push('style')
    <link rel="stylesheet" href="https://cdn.datatables.net/fixedcolumns/4.2.2/css/fixedColumns.dataTables.min.css">
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
        }

        th,
        td {
            border: 1px solid #dddddd;
            text-align: center;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }

        .biru {
            background-color: blue;
            color: white;
        }

        .hijau {
            background-color: green;
            color: white;
        }

        .kuning {
            background-color: yellow;
        }

        .oren {
            background-color: orange;
        }

        .merah {
            background-color: red;
            color: white;
        }

        .rotate-text {
            white-space: nowrap;
            transform: rotate(-90deg);
            transform-origin: 50% 50%;
        }
    </style>
@endpush
@section('content')
    @php
        @$data_user = Auth::user();
    @endphp

    <div class="row" style="margin-top: -200px;">
        <div class="col-md-12 grid-margin">
            <div class="row">
                <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                    <h3 class="font-weight-bold">Dashboard</h3>
                    <h6 class="font-weight-normal mb-0">Hi, {{ Auth::user()->name }}.
                        Welcome back to SIstem Informasi SPI</h6>
                </div>
            </div>
            <div class="row mt-4">
                <div class="accordion col-lg-12" id="accordionExample">
                    <div class="card shadow">
                        <div class="card-header bg-secondary p-1"
                            style="border-bottom-left-radius: 0 !important; border-bottom-right-radius: 0 !important;"
                            id="headingOne">
                            <h1 class="mb-2 mt-2">
                                <button class="btn btn-link btn-block text-left text-white" type="button"
                                    data-toggle="collapse" data-target="#collapseZero" aria-expanded="true"
                                    aria-controls="collapseOne">
                                    Summary Widget
                                </button>
                            </h1>
                        </div>

                        <div id="collapseZero" class="collapse" aria-labelledby="headingOne"
                            data-parent="#accordionExample">
                            <div class="card-body p-4">
                                <div class="row">
                                    <div class="col-lg-3">
                                        <div class="card card-tale text-white shadow pt-2 mb-2">
                                            <div class="card-body p-4">
                                                <h4 class="mb-4">Total User</h4>
                                                <h3 class="fs-30 mb-2">{{ $user }}</h3>
                                                <span>
                                                    <a href="{{ url('user') }}" class="text-white">
                                                        List User <i class="bi bi-arrow-right"></i>
                                                    </a>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="card card-dark-blue text-white shadow pt-2 mb-2">
                                            <div class="card-body p-4">
                                                <h4 class="mb-4">Total Unit</h4>
                                                <h3 class="fs-30 mb-2">{{ $unit }}</h3>
                                                <span>
                                                    <a href="{{ url('unit') }}" class="text-white">
                                                        List Unit <i class="bi bi-arrow-right"></i>
                                                    </a>
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-3">
                                        <div class="card card-light-blue text-white shadow pt-2 mb-2">
                                            <div class="card-body p-4">
                                                <h4 class="mb-4">Total Risiko</h4>
                                                <h3 class="fs-30 mb-2">{{ $risiko }}</h3>
                                                <span>
                                                    <a href="{{ url('risiko') }}" class="text-white">
                                                        List Risiko <i class="bi bi-arrow-right"></i>
                                                    </a>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="card card-light-danger text-white shadow pt-2 mb-2">
                                            <div class="card-body p-4">
                                                <h4 class="mb-4">Renc Penanganan</h4>
                                                <h3 class="fs-30 mb-2">{{ $rp }}</h3>
                                                <span>
                                                    <a href="{{ url('rencana-penanganan') }}" class="text-white">
                                                        List Rencana <i class="bi bi-arrow-right"></i>
                                                    </a>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card shadow">
                        <div class="card-header bg-secondary p-1"
                            style="border-bottom-left-radius: 0 !important; border-bottom-right-radius: 0 !important;"
                            id="headingOne">
                            <h1 class="mb-2 mt-2">
                                <button class="btn btn-link btn-block text-left text-white" type="button"
                                    data-toggle="collapse" data-target="#collapseRisk" aria-expanded="true"
                                    aria-controls="collapseOne">
                                    Peta Risiko
                                </button>
                            </h1>
                        </div>

                        <div id="collapseRisk" class="collapse" aria-labelledby="headingOne"
                            data-parent="#accordionExample">
                            <div class="card-body p-4">
                                <div class="row">
                                    <div class="table-responsive">
                                        <table width="100%" class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <td colspan="8"><b>Tingkat Dampak</b></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3"></td>
                                                    <td style="font-weight: bold">1</td>
                                                    <td style="font-weight: bold">2</td>
                                                    <td style="font-weight: bold">3</td>
                                                    <td style="font-weight: bold">4</td>
                                                    <td style="font-weight: bold">5</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3"></td>
                                                    <td>
                                                        <span style="font-weight: bold; font-size: 12px">Tidak <br />
                                                            Signifikan</span>
                                                    </td>
                                                    <td>
                                                        <span style="font-weight: bold; font-size: 12px">Minor</span>
                                                    </td>
                                                    <td>
                                                        <span style="font-weight: bold; font-size: 12px">Moderat</span>
                                                    </td>
                                                    <td>
                                                        <span style="font-weight: bold; font-size: 12px">Signifikan</span>
                                                    </td>
                                                    <td>
                                                        <span style="font-weight: bold; font-size: 12px">Sangat <br />
                                                            Signifikan</span>
                                                    </td>
                                                </tr>
                                            </thead>
                                            <tbody id="matriksBody">
                                                <!-- Data dari MySQL akan ditampilkan di sini menggunakan JavaScript -->
                                                <!-- <td></td> -->
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card shadow">
                        <div class="card-header bg-secondary p-1"
                            style="border-bottom-left-radius: 0 !important; border-bottom-right-radius: 0 !important;"
                            id="headingOne">
                            <h1 class="mb-2 mt-2">
                                <button class="btn btn-link btn-block text-left collapsed text-white" type="button"
                                    data-toggle="collapse" data-target="#collapseOne" aria-expanded="true"
                                    aria-controls="collapseOne">
                                    Progress Semua Berkas Unit
                                </button>
                            </h1>
                        </div>

                        <div id="collapseOne" class="collapse" aria-labelledby="headingOne"
                            data-parent="#accordionExample">
                            <div class="card-body p-4">
                                <div class="row">
                                    <div class="col-lg-3">
                                        <div class="card bg-warning text-white shadow pt-2 mb-2">
                                            <div class="card-body p-4">
                                                <h4 class="mb-4">Belum Proses</h4>
                                                <h3 class="mb-2">{{ $audit }} Berkas</h3>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="card bg-info text-white shadow pt-2 mb-2">
                                            <div class="card-body p-4">
                                                <h4 class="mb-4">Tahap Review</h4>
                                                <h3 class="mb-2">{{ $review }} Berkas</h3>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="card bg-success text-white shadow pt-2 mb-2">
                                            <div class="card-body p-4">
                                                <h4 class="mb-4">Evaluasi</h4>
                                                <h3 class="mb-2">{{ $evaluasi }} Berkas</h3>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="card bg-danger text-white shadow pt-2 mb-2">
                                            <div class="card-body p-4">
                                                <h4 class="mb-4">Berkas Ditolak</h4>
                                                <h3 class="mb-2">{{ $ditolak }} Berkas</h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card shadow">
                        <div class="card-header bg-secondary p-1"
                            style="border-bottom-left-radius: 0 !important; border-bottom-right-radius: 0 !important;"
                            id="headingTwo">
                            <h2 class="mb-2 mt-2">
                                <button class="btn btn-link btn-block text-left collapsed text-white" type="button"
                                    data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false"
                                    aria-controls="collapseTwo">
                                    Dokumen dan Panduan SPI
                                </button>
                            </h2>
                        </div>
                        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo"
                            data-parent="#accordionExample">
                            <div class="card-body p-4">
                                <table id="myTable" class="table table-bordered table-striped" style="width: 100%;">
                                    <thead class="bg-primary">
                                        <tr>
                                            <th width="5%">No</th>
                                            <th>Nama Berkas</th>
                                            <th>Status</th>
                                            <th>Tanggal Upload</th>
                                            <th>Tanggal Update</th>
                                            <th width="5%"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($dokumen as $k => $item)
                                            <tr>
                                                <td>{{ $k+1 }}</td>
                                                <th>{{ $item->nama_dokumen }}</th>
                                                <td>{{ $item->status }}</td>
                                                <td>{{ $item->created_at }}</td>
                                                <td>{{ $item->updated_at }}</td>
                                                <td>
                                                    <a href="/dokumen_spi/"{{ $item->file_dokumen }}>
                                                        <i class="text-info bi bi-file-earmark-arrow-down-fill"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            getData()
        })

        function getData() {
            $("#myTable").DataTable({
                "ordering": false,
            })
        }
    </script>
    <script>
        var dataFromMySQL
        var matriksBody = document.getElementById("matriksBody");

        // Membuat objek untuk menyimpan nilai matriks berdasarkan tingkat frekuensi dan tingkat dampak
        let matrixValues = {};

        axios.get('/data-matrik').then(function(res) {
            res.data.forEach(function(data) {
                var key = `${parseInt(data.tingkat_frekuensi)}_${parseInt(data.tingkat_dampak)}`;
                matrixValues[key] = data.nilai_matrik;
            });

            // Tampilkan data dari MySQL ke dalam tabel
            var tingkatFrekuensi = [5, 4, 3, 2, 1];
            tingkatFrekuensi.forEach(function(tf, index) {
                var row = document.createElement("tr");
                row.innerHTML = `
              ${
                index === 0
                  ? `<td style="width: 20px;" rowspan="5" class="rotate-text">
                                                          <b>Tingkat Frekuensi</b>
                                                      </td>`
                  : ``
              }
              <td><b>${tf}</b></td>
              <td><b>${
                tf === 5
                  ? '<span style="font-size: 12px;">Hampir Pasti <br> Terjadi</span>'
                  : tf === 4
                  ? '<span style="font-size: 12px;">Sering <br> Terjadi</span>'
                  : tf === 3
                  ? '<span style="font-size: 12px;">Kadang <br> Terjadi</span>'
                  : tf === 2
                  ? '<span style="font-size: 12px;">Jarang <br> Terjadi</span>'
                  : '<span style="font-size: 12px;">Hampir Tidak <br> Terjadi'
              }</b></td>
              <td class="${getColorClass(matrixValues[`${tf}_1`])}">${matrixValues[`${tf}_1`] || 0} </td>
              <td class="${getColorClass(matrixValues[`${tf}_2`])}">${matrixValues[`${tf}_2`] || 0} </td>
              <td class="${getColorClass(matrixValues[`${tf}_3`])}">${matrixValues[`${tf}_3`] || 0} </td>
              <td class="${getColorClass(matrixValues[`${tf}_4`])}">${matrixValues[`${tf}_4`] || 0} </td>
              <td class="${getColorClass(matrixValues[`${tf}_5`])}">${matrixValues[`${tf}_5`] || 0} </td>
          `;

                matriksBody.appendChild(row);
            });
        })


        function getColorClass(nilai) {
            if (nilai >= 20) {
                return "merah";
            } else if (nilai >= 16 && nilai <= 19) {
                return "oren";
            } else if (nilai >= 12 && nilai <= 15) {
                return "kuning";
            } else if (nilai >= 6 && nilai <= 11) {
                return "hijau";
            } else {
                return "biru";
            }
        }
    </script>
@endpush
