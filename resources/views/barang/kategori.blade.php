@extends('layouts.app')

@section('content')
    <!-- Header -->
    <div class="header bg-primary pb-6">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-center py-4">
                    <div class="col-lg-6 col-7">
                        <h6 class="h2 text-white d-inline-block mb-0">Kategori Barang</h6>
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
                        <a class="btn btn-icon btn-success" href="#" id="add_kategori">
                            <span class="btn-inner--icon"><i class="ni ni-fat-add"></i></span>
                            <span class="btn-inner--text">Tambah Kategori</span>
                        </a>
                        <div class="table-responsive py-4">
                            <table class="table table-flush" id="tbl_kategori">
                                <thead class="thead-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Nama Kategori</th>
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
        <form id="kategori" name="kategori" class="form-horizontal">
            @csrf
            <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title" id="modal-title-default">Tambah Kategori Barang</h6>
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
                                    <label class="form-control-label">Nama Kategori</label>
                                    <input type="hidden" id="kategori_id" name="kategori_id" value="">
                                    <input type="text" class="form-control" id="nama_kategori" name="nama_kategori" value="" placeholder="Nama Kategori">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" id="submit_kategori" value="create">Submit</button>
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

            $('#add_kategori').click(function () {
                $('#submit_kategori').val("create");
                $('#kategori_id').val('');
                $('#kategori').trigger("reset");
                $('.modal-title').html("Tambah Kategori Barang");
                $('#form_error').hide();
                $('#modal-add').modal('show');
            });

            let tbl_kategori = $('#tbl_kategori').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('kategori_barang') }}",
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                    { data: 'nama_kategori', name: 'nama_kategori' },
                    { data: 'action', name: 'action', orderable: false, searchable: false },
                ],
                language: {
                    paginate: {
                        next: '<i class="fas fa-angle-right"></i>', // or '→'
                        previous: '<i class="fas fa-angle-left"></i>' // or '←' 
                    }
                }
                // columnDefs: [
                //     {
                //         targets: [4,10,11],  
                //         className: 'text-center',
                //     }
                // ],
            });

            $('#submit_kategori').click(function (e) {
                e.preventDefault();
                $(this).html('Saving Data..');
                
                $.ajax({
                    data: $('#kategori').serialize(),
                    url: "{{ route('kategori_barang.store') }}",
                    type: "POST",
                    dataType: 'json',
                    success: function (data) {
                        $('#kategori').trigger("reset");
                        $('#submit_kategori').html('Submit');
                        $('#modal-add').modal('hide');
                        $('.modal-title').html("Tambah Kategori Barang");
                        $('#kategori_id').val('');
                        tbl_kategori.ajax.reload(null, false);
                        
                        swal("Success", "Data Berhasil Disimpan", "success")
                    },
                    error: function (data) {
                        console.log('Error:', data);
                        $('#submit_kategori').html('Submit');
                        $('#error_list').html('');
                        $.each(data.responseJSON.errors, function(key, value){
                            $('#form_error').show();
                            $('#error_list').append('<li>'+value+'</li>');
                        });
                    }
                });
            });

            $('body').on('click', '.edit_kategori', function () {
                let kategori_id = $(this).data('id');
                $.get("{{ route('kategori_barang') }}" +'/edit/' + kategori_id, function (data) {
                    $('.modal-title').html("Edit Kategori Barang");
                    $('#submit_kategori').val("edit");
                    $('#modal-add').modal('show');
                    $('#form_error').hide();
                    // show data
                    $('#kategori_id').val(data.id);
                    $('#nama_kategori').val(data.nama_kategori);
                })
            });

            $('body').on('click', '.delete_kategori', function () {
                let kategori_id = $(this).data('id');
                // confirm("Are You sure want to delete !");
                
                swal({
                    title: 'Apakah anda yakin?',
                    text: 'Data akan dihapus secara permanen',
                    icon: 'warning',
                    buttons: ["Cancel", "Yes!"],
                }).then(function(value) {
                    if (value) {
                        $.ajax({
                            url: "{{ route('kategori_barang') }}" + '/delete/' + kategori_id,
                            success: function (data) {
                                tbl_kategori.ajax.reload(null, false);
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