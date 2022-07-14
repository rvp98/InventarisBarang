@extends('layouts.app')

@section('content')
    <!-- Header -->
    <div class="header bg-primary pb-6">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-center py-4">
                    <div class="col-lg-6 col-7">
                        <h6 class="h2 text-white d-inline-block mb-0">Data Admin</h6>
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
                        <a class="btn btn-icon btn-success" href="#" id="add_admin">
                            <span class="btn-inner--icon"><i class="ni ni-fat-add"></i></span>
                            <span class="btn-inner--text">Tambah Admin</span>
                        </a>
                        <div class="table-responsive py-4">
                            <table class="table table-flush" id="tbl_admin">
                                <thead class="thead-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Nama</th>
                                        <th>Username</th>
                                        <th>Email</th>
                                        <th>No HP</th>
                                        <th>Alamat</th>
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
        <form id="admin" name="admin" class="form-horizontal">
            @csrf
            <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title" id="modal-title-default">Tambah Data Admin</h6>
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
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-control-label">Nama Admin</label>
                                    <input type="hidden" id="admin_id" name="admin_id" value="">
                                    <input type="text" class="form-control" id="nama_admin" name="nama_admin" value="" placeholder="Nama Admin">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-control-label">Username</label>
                                    <input type="text" class="form-control" id="username" name="username" value="" placeholder="Username">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-control-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" value="" placeholder="Email">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-control-label">No HP</label>
                                    <input type="text" class="form-control" id="phone" name="phone" value="" placeholder="No Hp">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-control-label">Password</label>
                                    <input type="password" class="form-control" id="password" name="password" value="" placeholder="Password">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-control-label">Password Confirmation</label>
                                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" value="" placeholder="Password Confirmation">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-control-label">Alamat</label>
                                    <textarea name="alamat" id="alamat" class="form-control" rows="5" placeholder="Alamat"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" id="action" name="action" value="create">
                        <button type="submit" class="btn btn-primary" id="submit_admin" value="create">Submit</button>
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

            $('#add_admin').click(function () {
                $('#action').val("create");
                $('#admin_id').val('');
                $('#admin').trigger("reset");
                $('.modal-title').html("Tambah Data Admin");
                $('#form_error').hide();
                $('#modal-add').modal('show');
            });

            let tbl_admin = $('#tbl_admin').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('data_admin') }}",
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                    { data: 'name', name: 'name' },
                    { data: 'username', name: 'username' },
                    { data: 'email', name: 'email' },
                    { data: 'phone', name: 'phone' },
                    { data: 'address', name: 'address' },
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

            $('#submit_admin').click(function (e) {
                e.preventDefault();
                $(this).html('Saving Data..');
                
                $.ajax({
                    data: $('#admin').serialize(),
                    url: "{{ route('data_admin.store') }}",
                    type: "POST",
                    dataType: 'json',
                    success: function (data) {
                        $('#admin').trigger("reset");
                        $('#submit_admin').html('Submit');
                        $('#modal-add').modal('hide');
                        $('.modal-title').html("Tambah Data Admin");
                        $('#admin_id').val('');
                        tbl_admin.ajax.reload(null, false);
                        
                        swal("Success", "Data Berhasil Disimpan", "success")
                    },
                    error: function (data) {
                        console.log('Error:', data);
                        $('#submit_admin').html('Submit');
                        $('#error_list').html('');
                        $.each(data.responseJSON.errors, function(key, value){
                            $('#form_error').show();
                            $('#error_list').append('<li>'+value+'</li>');
                        });
                    }
                });
            });

            $('body').on('click', '.edit_admin', function () {
                let admin_id = $(this).data('id');
                $.get("{{ route('data_admin') }}" +'/edit/' + admin_id, function (data) {
                    $('.modal-title').html("Edit Data Admin");
                    $('#action').val("edit");
                    $('#modal-add').modal('show');
                    $('#form_error').hide();
                    // show data
                    $('#admin_id').val(data.id);
                    $('#nama_admin').val(data.name);
                    $('#username').val(data.username);
                    $('#email').val(data.email);
                    $('#phone').val(data.phone);
                    $('#alamat').val(data.address);
                })
            });

            $('body').on('click', '.delete_admin', function () {
                let admin_id = $(this).data('id');
                // confirm("Are You sure want to delete !");
                
                swal({
                    title: 'Apakah anda yakin?',
                    text: 'Data akan dihapus secara permanen',
                    icon: 'warning',
                    buttons: ["Cancel", "Yes!"],
                }).then(function(value) {
                    if (value) {
                        $.ajax({
                            url: "{{ route('data_admin') }}" + '/delete/' + admin_id,
                            success: function (data) {
                                tbl_admin.ajax.reload(null, false);
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