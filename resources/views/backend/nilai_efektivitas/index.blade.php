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
                    <h3 class="font-weight-bold">Data Nilai Efektivitas</h3>
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
                                    <th rowspan="2">No</th>
                                    <th colspan="3" class="text-center border-bottom">Pernyataan Risiko</th>
                                    <th colspan="2" class="text-center border-bottom">Nilai A</th>
                                    <th colspan="2" class="text-center border-bottom">Nilai B</th>
                                    <th colspan="2" class="text-center border-bottom">Nilai C</th>
                                    <th rowspan="2">Jumlah</th>
                                    <th rowspan="2">Hasil</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                                <tr>
                                    <th>Peristiwa</th>
                                    <th>Penyebab</th>
                                    <th>Dampak</th>
                                    <th>Choice</th>
                                    <th>Nilai</th>

                                    <th>Choice</th>
                                    <th>Nilai</th>

                                    <th>Choice</th>
                                    <th>Nilai</th>
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
                        <h5 class="modal-title m-2" id="exampleModalLabel">Unit Form</h5>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id" id="id">
                        <div class="form-group">
                            <label>Peristiwa</label>
                            <?php 
                                $peristiwa = DB::table('risikos as r')
                                             ->join('profil_risikos as pr', 'pr.id_risiko', '=', 'r.id')
                                             ->select(
                                                'pr.id', 
                                                'r.identifikasi_risiko'
                                             )
                                             ->get(); 
                            ?>
                            <select name="id_profil_risiko" id="id_profil_risiko" class="form-control form-control-sm" required>
                                @foreach ($peristiwa as $item)
                                    <option value="{{ $item->id }}">{{ $item->identifikasi_risiko }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Nilai A</label>
                            <select name="nilai_a" id="nilai_a" class="form-control form-control-sm" required>
                                <option value=1>Ya</option>
                                <option value=3>Sebagian</option>
                                <option value=6>Tidak</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Nilai B</label>
                            <select name="nilai_b" id="nilai_b" class="form-control form-control-sm" required>
                                <option value=1>Ya</option>
                                <option value=3>Sebagian</option>
                                <option value=6>Tidak</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Nilai C</label>
                            <select name="nilai_c" id="nilai_c" class="form-control form-control-sm" required>
                                <option value=1>Ya</option>
                                <option value=3>Sebagian</option>
                                <option value=6>Tidak</option>
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
                ajax: '/data-nilai-efektivitas',
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
                            width: 200px !important;
                            white-space: normal;
                            display: inline-block !important;
                            ">
                            ${row.dampak}
                            </span>`
                        }
                    },
                    {
                        render: function(data, type, row, meta) {
                            if(row.nilai_a == '1'){
                                return 'Ya'
                            }else if(row.nilai_a == '3'){
                                return 'Sebagian'
                            }else if(row.nilai_a == '6'){
                                return 'Tidak'
                            }
                        }
                    },
                    {
                        data: "nilai_a"
                    },
                    {
                        render: function(data, type, row, meta) {
                            if(row.nilai_b == '1'){
                                return 'Ya'
                            }else if(row.nilai_b == '3'){
                                return 'Sebagian'
                            }else if(row.nilai_b == '6'){
                                return 'Tidak'
                            }
                        }
                    },
                    {
                        data: "nilai_b"
                    },
                    {
                        render: function(data, type, row, meta) {
                            if(row.nilai_c == '1'){
                                return 'Ya'
                            }else if(row.nilai_c == '3'){
                                return 'Sebagian'
                            }else if(row.nilai_c == '6'){
                                return 'Tidak'
                            }
                        }
                    },
                    {
                        data: "nilai_c"
                    },
                    {
                        data: "jumlah"
                    },
                    {
                        render: function(data, type, row, meta) {
                            if(row.jumlah <= 3){
                                return 'E'
                            }else if(row.jumlah < 8){
                                return 'KE'
                            }else if(row.jumlah >= 8){
                                return 'TE'
                            }
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
                modal.find('#id_profil_risiko').val(cokData[0].id_profil_risiko)
                modal.find('#nilai_a').val(cokData[0].nilai_a)
                modal.find('#nilai_b').val(cokData[0].nilai_b)
                modal.find('#nilai_c').val(cokData[0].nilai_c)

            }
        })

        form.onsubmit = (e) => {

            let formData = new FormData(form);

            e.preventDefault();

            document.getElementById("tombol_kirim").disabled = true;

            axios({
                    method: 'post',
                    url: formData.get('id') == '' ? '/store-nilai-efektivitas' : '/update-nilai-efektivitas',
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
                    axios.post('/delete-nilai-efektivitas', {
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
