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
    </style>
@endpush
@section('content')
    <div class="row" style="margin-top: -200px;">
        <div class="col-md-12">
            <div class="row">
                <div class="col-12 col-xl-8 mb-xl-0">
                    <h3 class="font-weight-bold">Data Risiko</h3>
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
                                    <th width="5%">No</th>
                                    <th>Proses Bisnis</th>
                                    <th>Identifikasi Risiko</th>
                                    <th>Pengelola Risiko</th>
                                    <th>Kategori Risiko</th>
                                    <th>Uraian</th>
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
                        <h5 class="modal-title m-2" id="exampleModalLabel">User Form</h5>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id" id="id">
                        <div class="form-group">
                            <label>Proses Bisnis</label>
                            <textarea placeholder="Proses Bisnis" required name="proses_bisnis" id="proses_bisnis" cols="30" rows="5" class="form-control form-control-sm"></textarea>
                        </div>
                        <div class="form-group">
                            <label>Identifikasi Risiko</label>
                            <textarea placeholder="Identifikasi Risiko" required name="identifikasi_risiko" id="identifikasi_risiko" cols="30" rows="5" class="form-control form-control-sm"></textarea>
                        </div>
                        <div class="form-group">
                            <label>Pengelola Risiko</label>
                            <select name="pengelola_risiko" id="pengelola_risiko" class="form-control form-control-sm" required>
                                <?php $unit = DB::table('units')->get(); ?>
                                @foreach ($unit as $item)
                                    <option>{{ $item->unit }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Kategori Risiko</label>
                            <select name="kategori_risiko" id="kategori_risiko" class="form-control form-control-sm" required>
                                <option>Risiko Hukum</option>
                                <option>Risiko Bencana</option>
                                <option>Risiko Kecurangan</option>
                                <option>Risiko Kepatuhan</option>
                                <option>Risiko Operasional</option>
                                <option>Risiko Reputasi</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Uraian</label>
                            <select name="uraian" id="uraian" class="form-control form-control-sm" required>
                                <option>Orang (Man)</option>
                                <option>Dana (Money)</option>
                                <option>Metode (Method)</option>
                                <option>Bahan (Material)</option>
                                <option>Mesin (Machine)</option>
                                <option>Eksternal</option>
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
                ajax: '/data-risiko',
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
                            ${row.proses_bisnis}
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
                            ${row.identifikasi_risiko}
                            </span>`
                        }
                    },
                    {
                        data: 'pengelola_risiko'
                    },
                    {
                        data: 'kategori_risiko'
                    },
                    {
                        data: 'uraian'
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
                modal.find('#proses_bisnis').val(cokData[0].proses_bisnis)
                modal.find('#identifikasi_risiko').val(cokData[0].identifikasi_risiko)
                modal.find('#pengelola_risiko').val(cokData[0].pengelola_risiko)
                modal.find('#kategori_risiko').val(cokData[0].kategori_risiko)
                modal.find('#uraian').val(cokData[0].uraian)
            }
        })

        form.onsubmit = (e) => {

            let formData = new FormData(form);

            e.preventDefault();

            document.getElementById("tombol_kirim").disabled = true;

            axios({
                    method: 'post',
                    url: formData.get('id') == '' ? '/store-risiko' : '/update-risiko',
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
                    axios.post('/delete-risiko', {
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
