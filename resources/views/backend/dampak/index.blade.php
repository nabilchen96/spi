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
                    <h3 class="font-weight-bold">Data Dampak</h3>
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
                        <table id="myTable" class="table table-bordered table-striped" style="width: 100%;">
                            <thead class="bg-primary text-white">
                                <tr>
                                    <th rowspan="3" width="5%">No</th>
                                    <th class="border-bottom">Pernyataan Risiko</th>
                                    <th class="border-bottom text-center" colspan="10">Area/Level Dampak</th>
                                    <th rowspan="3">Kriteria Dampak</th>

                                    <th></th>
                                    <th></th>
                                </tr>
                                <tr>
                                    <th rowspan="2">Peristiwa</th>

                                    <th colspan="2" class="border-bottom text-center">Beban Keuangan Negara</th>
                                    <th colspan="2" class="border-bottom text-center">Penurunan Reputasi</th>
                                    <th colspan="2" class="border-bottom text-center">Dampak Hukum</th>
                                    <th colspan="2" class="border-bottom text-center">Sasaran Kinerja</th>
                                    <th colspan="2" class="border-bottom text-center">Keselamatan Transportasi</th>

                                    <th></th>
                                    <th></th>
                                </tr>
                                <tr>

                                    <th>Kriteria</th>
                                    <th>Angka</th>

                                    <th>Kriteria</th>
                                    <th>Angka</th>

                                    <th>Kriteria</th>
                                    <th>Angka</th>

                                    <th>Kriteria</th>
                                    <th>Angka</th>

                                    <th>Kriteria</th>
                                    <th>Angka</th>

                                    <th width="5%"></th>
                                    <th width="5%"></th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="form">
                    <div class="modal-header p-3">
                        <h5 class="modal-title m-2" id="exampleModalLabel">Dampak Form</h5>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id" id="id">
                        <div class="form-group">
                            <label>Peristiwa</label>
                            <?php
                            $peristiwa = DB::table('risikos as r')
                                ->join('profil_risikos as pr', 'pr.id_risiko', '=', 'r.id')
                                ->select('pr.id', 'r.identifikasi_risiko');

                                if(Auth::user()->role == 'Admin'){
                                    $peristiwa = $peristiwa->get();
                                }else{
                                    $peristiwa = $peristiwa->where('r.id_user', Auth::id())->get();
                                }
                            ?>
                            <select name="id_profil_risiko" id="id_profil_risiko" class="form-control form-control-sm"
                                required>
                                @foreach ($peristiwa as $item)
                                    <option value="{{ $item->id }}">{{ $item->identifikasi_risiko }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Beban Keuangan Negara</label>
                            <select name="beban_keuangan_negara" id="beban_keuangan_negara" required class="form-control form-control-sm">
                                <option>Tidak Signifikan</option>
                                <option>Minor</option>
                                <option>Moderat</option>
                                <option>Signifikan</option>
                                <option>Sangat Signifikan</option>
                                <option>Tidak Termasuk Kriteria</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Penurunan Reputasi</label>
                            <select name="penurunan_reputasi" id="penurunan_reputasi" required class="form-control form-control-sm">
                                <option>Tidak Signifikan</option>
                                <option>Minor</option>
                                <option>Moderat</option>
                                <option>Signifikan</option>
                                <option>Sangat Signifikan</option>
                                <option>Tidak Termasuk Kriteria</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Dampak Hukum</label>
                            <select name="dampak_hukum" id="dampak_hukum" required class="form-control form-control-sm">
                                <option>Tidak Signifikan</option>
                                <option>Minor</option>
                                <option>Moderat</option>
                                <option>Signifikan</option>
                                <option>Sangat Signifikan</option>
                                <option>Tidak Termasuk Kriteria</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Sasaran_kinerja</label>
                            <select name="sasaran_kinerja" id="sasaran_kinerja" required class="form-control form-control-sm">
                                <option>Tidak Signifikan</option>
                                <option>Minor</option>
                                <option>Moderat</option>
                                <option>Signifikan</option>
                                <option>Sangat Signifikan</option>
                                <option>Tidak Termasuk Kriteria</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Keselamatan Transportasi</label>
                            <select name="keselamatan_transportasi" id="keselamatan_transportasi" required class="form-control form-control-sm">
                                <option>Tidak Signifikan</option>
                                <option>Minor</option>
                                <option>Moderat</option>
                                <option>Signifikan</option>
                                <option>Sangat Signifikan</option>
                                <option>Tidak Termasuk Kriteria</option>
                            </select>
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
                ajax: '/data-dampak',
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
                        data: "beban_keuangan_negara"
                    },
                    {
                        render: function(data, type, row, meta) {
                            if (row.beban_keuangan_negara === "Tidak Signifikan") {
                                return  1;
                            } else if (row.beban_keuangan_negara === "Minor") {
                                return  2;
                            } else if (row.beban_keuangan_negara === "Moderat") {
                                return  3;
                            } else if (row.beban_keuangan_negara === "Signifikan") {
                                return  4;
                            } else if (row.beban_keuangan_negara === "Sangat Signifikan") {
                                return  5;
                            } else if (row.beban_keuangan_negara === "Tidak termasuk kriteria") {
                                return  0;
                            } else {
                                return  null; // Jika nilai tidak cocok dengan opsi yang diberikan
                            }
                        }
                    },
                    {
                        data: "penurunan_reputasi"
                    },
                    {
                        render: function(data, type, row, meta) {
                            if (row.penurunan_reputasi === "Tidak Signifikan") {
                                return  1;
                            } else if (row.penurunan_reputasi === "Minor") {
                                return  2;
                            } else if (row.penurunan_reputasi === "Moderat") {
                                return  3;
                            } else if (row.penurunan_reputasi === "Signifikan") {
                                return  4;
                            } else if (row.penurunan_reputasi === "Sangat Signifikan") {
                                return  5;
                            } else if (row.penurunan_reputasi === "Tidak termasuk kriteria") {
                                return  0;
                            } else {
                                return  null; // Jika nilai tidak cocok dengan opsi yang diberikan
                            }
                        }
                    },
                    {
                        data: "dampak_hukum"
                    },
                    {
                        render: function(data, type, row, meta) {
                            if (row.dampak_hukum === "Tidak Signifikan") {
                                return  1;
                            } else if (row.dampak_hukum === "Minor") {
                                return  2;
                            } else if (row.dampak_hukum === "Moderat") {
                                return  3;
                            } else if (row.dampak_hukum === "Signifikan") {
                                return  4;
                            } else if (row.dampak_hukum === "Sangat Signifikan") {
                                return  5;
                            } else if (row.dampak_hukum === "Tidak termasuk kriteria") {
                                return  0;
                            } else {
                                return  null; // Jika nilai tidak cocok dengan opsi yang diberikan
                            }
                        }
                    },
                    {
                        data: "sasaran_kinerja"
                    },
                    {
                        render: function(data, type, row, meta) {
                            if (row.sasaran_kinerja === "Tidak Signifikan") {
                                return  1;
                            } else if (row.sasaran_kinerja === "Minor") {
                                return  2;
                            } else if (row.sasaran_kinerja === "Moderat") {
                                return  3;
                            } else if (row.sasaran_kinerja === "Signifikan") {
                                return  4;
                            } else if (row.sasaran_kinerja === "Sangat Signifikan") {
                                return  5;
                            } else if (row.sasaran_kinerja === "Tidak termasuk kriteria") {
                                return  0;
                            } else {
                                return  null; // Jika nilai tidak cocok dengan opsi yang diberikan
                            }
                        }
                    },
                    {
                        data: "keselamatan_transportasi"
                    },
                    {
                        render: function(data, type, row, meta) {
                            if (row.keselamatan_transportasi === "Tidak Signifikan") {
                                return  1;
                            } else if (row.keselamatan_transportasi === "Minor") {
                                return  2;
                            } else if (row.keselamatan_transportasi === "Moderat") {
                                return  3;
                            } else if (row.keselamatan_transportasi === "Signifikan") {
                                return  4;
                            } else if (row.keselamatan_transportasi === "Sangat Signifikan") {
                                return  5;
                            } else if (row.keselamatan_transportasi === "Tidak termasuk kriteria") {
                                return  0;
                            } else {
                                return  null; // Jika nilai tidak cocok dengan opsi yang diberikan
                            }
                        }
                    },
                    {
                        data: "kriteria_dampak"
                    },
                    {
                        render: function(data, type, row, meta) {
                            return `<a data-toggle="modal" data-target="#modal"
                                    data-bs-id=` + (row.id) + ` href="javascript:void(0)">
                                    <i style="font-size: 1.5rem;" class="text-success bi bi-grid"></i>
                                </a>`
                        }
                    },
                    {
                        render: function(data, type, row, meta) {
                            return `<a href="javascript:void(0)" onclick="hapusData(` + (row
                                .id) + `)">
                                    <i style="font-size: 1.5rem;" class="text-danger bi bi-trash"></i>
                                </a>`
                        }
                    },
                ]
            })
        }

        $('#modal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var recipient = button.data('bs-id') // Extract info from data-* attributes
            var cok = $("#myTable").DataTable().rows().data().toArray()

            let cokData = cok.filter((dt) => {
                return dt.id == recipient;
            })

            document.getElementById("form").reset();
            document.getElementById('id').value = ''
            $('.error').empty();

            if (recipient) {
                var modal = $(this)
                modal.find('#id').val(cokData[0].id)
                modal.find('#beban_keuangan_negara').val(cokData[0].beban_keuangan_negara)
                modal.find('#penurunan_reputasi').val(cokData[0].penurunan_reputasi)
                modal.find('#dampak_hukum').val(cokData[0].dampak_hukum)
                modal.find('#sasaran_kinerja').val(cokData[0].sasaran_kinerja)
                modal.find('#keselamatan_transportasi').val(cokData[0].keselamatan_transportasi)
                modal.find('#kriteria_dampak').val(cokData[0].kriteria_dampak)

            }
        })

        form.onsubmit = (e) => {

            let formData = new FormData(form);

            e.preventDefault();

            document.getElementById("tombol_kirim").disabled = true;

            axios({
                    method: 'post',
                    url: formData.get('id') == '' ? '/store-dampak' : '/update-dampak',
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

                        $("#modal").modal("hide");
                        $('#myTable').DataTable().clear().destroy();
                        getData()

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

        hapusData = (id) => {
            Swal.fire({
                title: "Yakin hapus data?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                confirmButtonText: 'Ya',
                cancelButtonColor: '#3085d6',
                cancelButtonText: "Batal"

            }).then((result) => {

                if (result.value) {
                    axios.post('/delete-dampak', {
                            id
                        })
                        .then((response) => {
                            if (response.data.responCode == 1) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    timer: 2000,
                                    showConfirmButton: false
                                })

                                $('#myTable').DataTable().clear().destroy();
                                getData();

                            } else {
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'Gagal...',
                                    text: response.data.respon,
                                })
                            }
                        }, (error) => {
                            console.log(error);
                        });
                }

            });
        }
    </script>
@endpush
