@extends('layouts.app')

@section('content')
    <!-- Header -->
    <div class="header bg-primary pb-6">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-center py-4">
                    <div class="col-lg-6 col-7">
                        <h6 class="h2 text-white d-inline-block mb-0">Barang</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Page content -->
    <div class="container-fluid mt--6">
        {{-- Put Content Here --}}
        <div class="row">
            <div class="col-xl-12">
                <div class="card mb-4">
                    <div class="card-body">
                        <a class="btn btn-icon btn-success" href="#" id="add_barang">
                            <span class="btn-inner--icon"><i class="ni ni-fat-add"></i></span>
                            <span class="btn-inner--text">Tambah Barang</span>
                        </a>
                        <div class="table-responsive py-4">
                            <table class="table table-flush" id="tbl_barang">
                                <thead class="thead-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Foto Barang</th>
                                        <th>Nama Barang</th>
                                        <th>Kategori</th>
                                        <th>Stok</th>
                                        <th>Deskripsi</th>
                                        <th>Kondisi</th>
                                        <th>Aktif</th>
                                        <th>*</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- Put Content Here --}}
    </div>
    <div class="modal fade" id="modal-add" tabindex="-1" role="dialog" aria-labelledby="modal-add" aria-hidden="true">
        <form id="barang" name="barang" class="form-horizontal">
            @csrf
            <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title" id="modal-title-default">Tambah Data Barang</h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12" id="form_error" style="display: none">
                                <div class="alert alert-danger" role="alert">
                                    <strong>Error!</strong>
                                    <ul id="error_list">
                                                    
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-control-label">Nama Barang</label>
                                    <input type="hidden" id="barang_id" name="barang_id" value="">
                                    <input type="text" class="form-control" id="nama_barang" name="nama_barang" value="" placeholder="Nama Barang">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-control-label">Foto Barang</label>
                                    <input type="file" class="form-control" id="foto_barang" name="foto_barang" value="">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-control-label">Kategori Barang</label>
                                    {!! Form::select('kategori_id', $kategori_barang, null,['class' => 'form-control', 'id' => 'kategori_id']) !!}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-control-label">Stok</label>
                                    <input type="number" class="form-control" id="stok_barang" name="stok_barang" value="0" min="0">
                                </div>
                            </div>
                            <div class="col-md-6" id="kondisi">
                                <div class="form-group">
                                    <label class="form-control-label">Kondisi</label>
                                    <select name="kondisi_barang" id="kondisi_barang" class="form-control">
                                        <option value="baik">Baik</option>
                                        <option value="kurang_baik">Kurang Baik</option>
                                        <option value="rusak">Rusak</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6" id="sts">
                                <div class="form-group">
                                    <label class="form-control-label">Status</label><br>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="status_aktif" name="status_barang" checked value="1" class="custom-control-input">
                                        <label class="custom-control-label" for="status_aktif">Aktif</label>
                                    </div>
                                    <br>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="status_noaktif" name="status_barang" value="0" class="custom-control-input">
                                        <label class="custom-control-label" for="status_noaktif">Tidak Aktif</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-control-label">Deskripsi Barang</label>
                                    <textarea name="deskripsi" id="deskripsi" rows="5" class="form-control" placeholder="Deskripsi Barang"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" id="submit_barang" value="create">Submit</button>
                        <button type="button" class="btn btn-link  ml-auto" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <script>
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#add_barang').click(function () {
                $('#submit_barang').val("create");
                $('#barang_id').val('');
                $('#barang').trigger("reset");
                $('.modal-title').html("Tambah Data Barang");
                $('#form_error').hide();
                $('#modal-add').modal('show');
                $('#kondisi').removeClass('col-md-6');
                $('#kondisi').addClass('col-md-12');
                $('#sts').hide();
            });

            let tbl_barang = $('#tbl_barang').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('barang') }}",
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                    { 
                        data: 'foto_barang', 
                        name: 'foto_barang',
                        render: function(data, type, full, meta) {
                            return "<img src='{{ asset('img_barang/').'/' }}"+data+"' width='100px'>";
                        },
                    },
                    { data: 'nama_barang', name: 'nama_barang' },
                    { data: 'kategoris.nama_kategori', name: 'nama_kategori' },
                    { data: 'stok', name: 'stok' },
                    { data: 'deskripsi', name: 'deskripsi' },
                    { data: 'kondisi_barang', name: 'kondisi_barang' },
                    { data: 'status_barang', name: 'status_barang '},
                    { data: 'action', name: 'action', orderable: false, searchable: false },
                ],
                language: {
                    paginate: {
                        next: '<i class="fas fa-angle-right"></i>', // or '→'
                        previous: '<i class="fas fa-angle-left"></i>' // or '←' 
                    }
                },
                columnDefs: [
                    {
                        targets: [1,6],  
                        className: 'text-center',
                    }
                ],
            });

            $('#barang').on('submit', function (e) {
                e.preventDefault();
                $('#submit_barang').html('Saving Data..');

                $.ajax({
                    data: new FormData(this),
                    url: "{{ route('barang.store') }}",
                    method: "POST",
                    dataType: 'json',
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function (data) {
                        swal({
                            title: "Success", 
                            text: "Data Berhasil Disimpan", 
                            icon: "success"
                        }).then(function() {
                            $('#barang').trigger("reset");
                            $('#submit_barang').html('Submit');
                            $('#modal-add').modal('hide');
                            $('.modal-title').html("Tambah Data Barang");
                            $('#barang_id').val('');
                            tbl_barang.ajax.reload(null, false);
                        });
                    },
                    error: function (data) {
                        console.log('Error:', data);
                        $('#submit_barang').html('Submit');
                        swal("Error", "Error", "error")
                        $('#error_list').html('');
                        $.each(data.responseJSON.errors, function(key, value){
                            $('#form_error').show();
                            $('#error_list').append('<li>'+value+'</li>');
                        });
                    }
                });
            });

            $('body').on('click', '.edit_barang', function () {
                let barang_id = $(this).data('id');
                $('#kondisi').addClass('col-md-6');
                $('#kondisi').removeClass('col-md-12');
                $('#sts').show();

                $.get("{{ route('barang') }}" +'/edit/' + barang_id, function (data) {
                    console.log(data);
                    $('.modal-title').html("Edit Data Barang");
                    $('#submit_barang').val("edit");
                    $('#modal-add').modal('show');
                    $('#form_error').hide();
                    // show data
                    $('#barang_id').val(data.id);
                    $('#nama_barang').val(data.nama_barang);
                    $('#kategori_id').val(data.kategori_id);
                    $('#stok_barang').val(data.stok);
                    $('#kondisi_barang').val(data.kondisi);
                    $('#deskripsi').val(data.deskripsi);
                    if (data.status == '1') {
                        $("#status_aktif").prop("checked", true); 
                    } else {
                        $("#status_noaktif").prop("checked", true);
                    }
                })
            });

            $('body').on('click', '.delete_barang', function () {
                let barang_id = $(this).data('id');
                // confirm("Are You sure want to delete !");
                
                swal({
                    title: 'Apakah anda yakin?',
                    text: 'Data akan dihapus secara permanen',
                    icon: 'warning',
                    buttons: ["Cancel", "Yes!"],
                }).then(function(value) {
                    if (value) {
                        $.ajax({
                            url: "{{ route('barang') }}" + '/delete/' + barang_id,
                            success: function (data) {
                                tbl_barang.ajax.reload(null, false);
                                swal("Success", "Data Berhasil Dihapus", "success")
                            },
                            error: function (data) {
                                console.log('Error:', data);
                            }
                        });
                    }
                });
            });
        });
    </script>
@endsection