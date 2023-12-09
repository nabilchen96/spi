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
    <div class="row" style="margin-top: -200px;">
        <div class="col-md-12">
            <div class="row">
                <div class="col-12 col-xl-8 mb-xl-0">
                    <h3 class="font-weight-bold">Data Matrik</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 mt-4">
            <div class="card w-100">
                <div class="card-body">
                    <button type="button" class="btn btn-primary btn-sm mb-4" data-toggle="modal" data-target="#modal">
                        Tambah
                    </button>
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

        {{-- <table style="float: right;" width="35%">
            <tr>
                <td>Level Risiko</td>
                <td>Besaran Risiko</td>
                <td>Warna</td>
            </tr>
            <tr style="background-color: red;">
                <td>Sangat Tinggi (5)</td>
                <td>20 sd. 25</td>
                <td>Merah</td>
            </tr>
            <tr style="background-color: orange;">
                <td>Tinggi (4)</td>
                <td>16 sd. 19</td>
                <td>Orange</td>
            </tr>
            <tr style="background-color: yellow;">
                <td>Sedang (4)</td>
                <td>12 sd. 15</td>
                <td>Orange</td>
            </tr>
        </table> --}}

        <div class="modal fade" id="modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form id="form">
                        <div class="modal-header p-3">
                            <h5 class="modal-title m-2" id="exampleModalLabel">Unit Form</h5>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="id" id="id">
                            <div class="form-group">
                                <label>Tingkat Dampak</label>
                                <select name="tingkat_dampak" id="tingkat_dampak" class="form-control form-control-sm">
                                    <option>1</option>
                                    <option>2</option>
                                    <option>3</option>
                                    <option>4</option>
                                    <option>5</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Tingkat Frekuensi</label>
                                <select name="tingkat_frekuensi" id="tingkat_frekuensi"
                                    class="form-control form-control-sm">
                                    <option>1</option>
                                    <option>2</option>
                                    <option>3</option>
                                    <option>4</option>
                                    <option>5</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Nilai Matrik</label>
                                <input type="number" max=25 name="nilai_matrik" id="nilai_matrik"
                                    class="form-control form-control-sm">
                            </div>
                        </div>
                        <div class="modal-footer p-3">
                            <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
                            <button id="tombol_kirim" class="btn btn-primary btn-sm">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script>
        // Dummy data, karena kita tidak dapat mengakses database di sini
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

        form.onsubmit = (e) => {

            let formData = new FormData(form);

            e.preventDefault();

            document.getElementById("tombol_kirim").disabled = true;

            axios({
                    method: 'post',
                    url: '/store-matrik',
                    data: formData,
                })
                .then(function(res) {
                    //handle success         
                    if (res.data.responCode == 1) {

                        Swal.fire({
                            icon: 'success',
                            title: 'Sukses',
                            text: res.data.respon,
                            timer: 3000,
                            showConfirmButton: false
                        })

                        location.reload()
                    } else {

                        console.log('terjadi error');
                    }

                    document.getElementById("tombol_kirim").disabled = false;
                })
                .catch(function(res) {
                    document.getElementById("tombol_kirim").disabled = false;
                    //handle error
                    console.log(res);
                });
        }
    </script>
@endpush
