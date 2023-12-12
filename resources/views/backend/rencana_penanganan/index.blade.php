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
                    <h3 class="font-weight-bold">Data Penanganan</h3>
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
                                    <th rowspan="2" width="5%">No</th>
                                    <th rowspan="2" class="border-bottom">Peristiwa</th>
                                    <th rowspan="2" class="border-bottom">Sistem Pengendalian yang Ada</th>
                                    <th colspan="5" class="border-bottom text-center">Rencana Penanganan Risiko</th>
                                    <th colspan="4" class="border-bottom text-center">Level Risiko Harapan Setelah Mitigasi</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                                <tr>
                                    <th>Opsi Penanganan Risiko</th>
                                    <th>
                                        Uraian Penanganan Risiko 
                                        {{-- <br> <span class="text-danger">
                                            Diisi dengan penanganan  berbeda dengan 
                                            penanganan yang sudah ada --}}
                                        </span>
                                    </th>
                                    <th>Target Output</th>
                                    <th>Jadwal Implementasi</th>
                                    <th>Pengelola Risiko</th>
                                    <th>Kemungkinan</th>
                                    <th>Dampak</th>
                                    <th>Keputusan Mitigasi</th>
                                    <th>Risiko</th>
                                    <th></th>
                                    <th></th>
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
                        <h5 class="modal-title m-2" id="exampleModalLabel">Rencana Penanganan Form</h5>
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
                            <label>Opsi Penanganan</label>
                            <select name="opsi_penanganan" id="opsi_penanganan" class="form-control form-control-sm" required>
                                <option>Mengurangi Kemungkinan</option>
                                <option>Mengurangi Dampak</option>
                                <option>Mengurangi Kemungkinan dan Dampak</option>
                                <option>Berbagi Risiko</option>
                                <option>Menghindari Risiko</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Penanganan Lain</label>
                            <textarea placeholder="Penanganan Lain" name="penanganan_lain" id="penanganan_lain" class="form-control form-control-sm" cols="30" rows="5"></textarea>
                        </div>
                        <div class="form-group">
                            <label>Jumlah Kegiatan</label>
                            <input type="number" class="form-control form-control-sm" required name="jumlah_kegiatan" id="jumlah_kegiatan" placeholder="Jumlah Kegiatan">
                        </div>
                        <div class="form-group">
                            <label>Jadwal</label>
                            <input type="date" class="form-control form-control-sm" required name="jadwal" id="jadwal">
                        </div>
                        <div class="form-group">
                            <label>Level Harapan Kemungkinan</label>
                            <input type="number" class="form-control form-control-sm" required 
                            name="level_kemungkinan" id="level_kemungkinan" placeholder="Jumlah Kemungkinan">
                        </div>
                        <div class="form-group">
                            <label>Level Harapan Dampak</label>
                            <input type="number" class="form-control form-control-sm" required 
                            name="level_dampak" id="level_dampak"  placeholder="Jumlah Dampak">
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
                ajax: '/data-rencana-penanganan',
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
                        data: "sistem_pengendalian"
                    },
                    {
                        render: function(data, type, row, meta) {
                            return `<span style="
                            width: 200px !important;
                            white-space: normal;
                            display: inline-block !important;
                            ">
                            ${row.opsi_penanganan}
                            </span>`
                        }
                    },
                    {
                        render: function(data, type, row, meta) {
                            return `<span style="
                            width: 250px !important;
                            white-space: normal;
                            display: inline-block !important;
                            ">
                            ${row.penanganan_lain}
                            </span>`
                        }
                    },
                    {
                        data: "jumlah_kegiatan"
                    },
                    {
                        data: "jadwal"
                    },
                    {
                        data: "level_kemungkinan"
                    },
                    {
                        data: "level_dampak"
                    },
                    {
                        data: "nilai_risiko"
                    },
                    {
                        render: function(data, type, row, meta) {
                            return `YA`
                        }
                    },
                    {
                        render: function(data, type, row, meta) {
                            return row.level_kemungkinan + row.level_dampak
                        }
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
                modal.find('#opsi_penanganan').val(cokData[0].opsi_penanganan)
                modal.find('#penanganan_lain').val(cokData[0].penanganan_lain)
                modal.find('#jumlah_kegiatan').val(cokData[0].jumlah_kegiatan)
                modal.find('#jadwal').val(cokData[0].jadwal)
                modal.find('#level_kemungkinan').val(cokData[0].level_kemungkinan)
                modal.find('#level_dampak').val(cokData[0].level_dampak)

            }
        })

        form.onsubmit = (e) => {

            let formData = new FormData(form);

            e.preventDefault();

            document.getElementById("tombol_kirim").disabled = true;

            axios({
                    method: 'post',
                    url: formData.get('id') == '' ? '/store-rencana-penanganan' : '/update-rencana-penanganan',
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
                    axios.post('/delete-rencana-penanganan', {
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
