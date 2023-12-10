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
                    <h3 class="font-weight-bold">Data Kemungkinan</h3>
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
                                    <th class="border-bottom text-center" colspan="8">Kriteria Kemungkinan Dalam 1 Tahun
                                    </th>
                                    <th rowspan="3">Level Kemungkinan</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                                <tr>
                                    <th rowspan="2">Peristiwa</th>
                                    <th colspan="4" class="border-bottom text-center">Persentasi Dalam 1 Tahun</th>
                                    <th colspan="2" class="border-bottom text-center">Frekuensi Dalam 1 Tahun</th>
                                    <th colspan="2" class="border-bottom text-center">Kejadian Toleransi Rendah</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                                <tr>
                                    
                                    <th>Kemungkinan</th>
                                    <th>Total Aktivitas</th>
                                    <th>Persentase</th>
                                    <th>Angka</th>

                                    <th>Frekuensi</th>
                                    <th>Angka</th>

                                    <th>Kejadian</th>
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
                        <h5 class="modal-title m-2" id="exampleModalLabel">Kemungkinan Form</h5>
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
                            <label>Jumlah Kemungkinan</label>
                            <input type="number" placeholder="Jumlah Kemungkinan" class="form-control form-control-sm"
                                required name="jumlah_kemungkinan" id="jumlah_kemungkinan">
                        </div>
                        <div class="form-group">
                            <label>Total Aktivitas</label>
                            <input type="number" placeholder="Total Aktivitas" class="form-control form-control-sm"
                                required name="total_aktivitas" id="total_aktivitas">
                        </div>
                        <div class="form-group">
                            <label>Frekuensi</label>
                            <select name="frekuensi" id="frekuensi" class="form-control form-control-sm" required>
                                <option>2 kali dalam 1 tahun</option>
                                <option>2 sd 5 kali dalam 1 tahun</option>
                                <option>6 sd 9 kali dalam 1 tahun</option>
                                <option>10 sd 12 kali dalam 1 tahun</option>
                                <option>Lebih dari 12 kali dalam 1 tahun</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Kejadian</label>
                            <select name="kejadian" id="kejadian" class="form-control form-control-sm" required>
                                <option>1 kejadian dalam 1 tahun terakhir</option>
                                <option>1 kejadian dalam 2 tahun terakhir</option>
                                <option>1 kejadian dalam 3 tahun terakhir</option>
                                <option>1 kejadian dalam 4 tahun terakhir</option>
                                <option>1 kejadian dalam 5 tahun terakhir</option>
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
                ajax: '/data-kemungkinan',
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
                        data: "jumlah_kemungkinan"
                    },
                    {
                        data: "total_aktivitas"
                    },
                    {
                        render: function(data, type, row, meta) {
                            return (row.jumlah_kemungkinan / row.total_aktivitas).toFixed(2) + "%"
                        }
                    },
                    {
                        render: function(data, type, row, meta) {
                            if ((row.jumlah_kemungkinan / row.total_aktivitas) <= 0.05) {
                                return "1";
                            } else if ((row.jumlah_kemungkinan / row.total_aktivitas) <= 0.1) {
                                return "2";
                            } else if ((row.jumlah_kemungkinan / row.total_aktivitas) <= 0.2) {
                                return "3";
                            } else if ((row.jumlah_kemungkinan / row.total_aktivitas) <= 0.5) {
                                return "4";
                            } else if ((row.jumlah_kemungkinan / row.total_aktivitas) <= 1) {
                                return "5";
                            } else if ((row.jumlah_kemungkinan / row.total_aktivitas) === "") {
                                return "0";
                            }
                        }
                    },
                    {
                        data: 'frekuensi'
                    },
                    {
                        render: function(data, type, row, meta) {
                            if (row.frekuensi <= 0) {
                                return "0";
                            } else if (row.frekuensi == "< 2 kali dalam 1 tahun") {
                                return "1";
                            } else if (row.frekuensi == "2 sd 5 kali dalam 1 tahun") {
                                return "2";
                            } else if (row.frekuensi == "6 sd 9 kali dalam 1 tahun") {
                                return "3";
                            } else if (row.frekuensi == "10 sd 12 kali dalam 1 tahun") {
                                return "4";
                            } else if (row.frekuensi == "Lebih dari 12 kali dalam 1 tahun") {
                                return "5";
                            } else {
                                return "0";
                            }
                        }
                    },
                    {
                        data: "kejadian"
                    },
                    {
                        render: function(data, type, row, meta) {
                            if (row.kejadian <= 0) {
                                return "0";
                            } else if (row.kejadian === "1 kejadian dalam 1 tahun terakhir") {
                                return "5";
                            } else if (row.kejadian === "1 kejadian dalam 2 tahun terakhir") {
                                return "4";
                            } else if (row.kejadian === "1 kejadian dalam 3 tahun terakhir") {
                                return "3";
                            } else if (row.kejadian === "1 kejadian dalam 4 tahun terakhir") {
                                return "2";
                            } else if (row.kejadian === "1 kejadian dalam 5 tahun terakhir") {
                                return "1";
                            }
                        }
                    },
                    {
                        data: "level_kemungkinan"
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
                modal.find('#id_profil_risiko').val(cokData[0].id_profil_risiko)
                modal.find('#jumlah_kemungkinan').val(cokData[0].jumlah_kemungkinan)
                modal.find('#total_aktivitas').val(cokData[0].total_aktivitas)
                modal.find('#frekuensi').val(cokData[0].frekuensi)
                modal.find('#kejadian').val(cokData[0].kejadian)
            }
        })

        form.onsubmit = (e) => {

            let formData = new FormData(form);

            e.preventDefault();

            document.getElementById("tombol_kirim").disabled = true;

            axios({
                    method: 'post',
                    url: formData.get('id') == '' ? '/store-kemungkinan' : '/update-kemungkinan',
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
                    axios.post('/delete-kemungkinan', {
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
