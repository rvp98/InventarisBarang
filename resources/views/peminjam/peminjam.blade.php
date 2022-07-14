@extends('layouts.app')

@section('content')
    <!-- Header -->
    <div class="header bg-primary pb-6">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-center py-4">
                    <div class="col-lg-6 col-7">
                        <h6 class="h2 text-white d-inline-block mb-0">Peminjam</h6>
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
                        <a class="btn btn-icon btn-success" href="#" id="add_peminjam">
                            <span class="btn-inner--icon"><i class="ni ni-fat-add"></i></span>
                            <span class="btn-inner--text">Tambah Data Peminjam</span>
                        </a>
                        <div class="table-responsive py-4">
                            <table class="table table-flush" id="tbl_peminjam">
                                <thead class="thead-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Nama</th>
                                        <th>Alamat</th>
                                        <th>No Hp</th>
                                        <th>Divisi</th>
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
        <form id="peminjam" name="peminjam" class="form-horizontal">
            @csrf
            <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title" id="modal-title-default">Tambah Data Peminjam</h6>
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
                                    <label class="form-control-label">Nama</label>
                                    <input type="hidden" id="peminjam_id" name="peminjam_id" value="">
                                    <input type="text" class="form-control" id="nama_peminjam" name="nama_peminjam" value="" placeholder="Nama Peminjam">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-control-label">No Hp</label>
                                    <input type="text" class="form-control" id="no_peminjam" name="no_peminjam" value="" placeholder="No Hp">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-control-label">Divisi</label>
                                    <select name="divisi_peminjam" id="divisi_peminjam" class="form-control">
                                        <option value="Software Engineer">Software Engineer</option>
                                        <option value="Administrasi">Administrasi</option>
                                        <option value="Marketing">Marketing</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-control-label">Alamat</label>
                                    <textarea name="alamat_peminjam" id="alamat_peminjam" rows="5" class="form-control" placeholder="Alamat"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" id="submit_peminjam" value="create">Submit</button>
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

            $('#add_peminjam').click(function () {
                $('#submit_peminjam').val("create");
                $('#peminjam_id').val('');
                $('#peminjam').trigger("reset");
                $('.modal-title').html("Tambah Data Peminjam");
                $('#form_error').hide();
                $('#modal-add').modal('show');
            });

            let tbl_peminjam = $('#tbl_peminjam').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('peminjam') }}",
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                    { data: 'nama_peminjam', name: 'nama_peminjam' },
                    { data: 'alamat', name: 'alamat' },
                    { data: 'phone', name: 'phone' },
                    { data: 'divisi_peminjam', name: 'divisi_peminjam' },
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
                        targets: [4],  
                        className: 'text-center',
                    }
                ],
            });

            $('#submit_peminjam').click(function (e) {
                e.preventDefault();
                $(this).html('Saving Data..');
                
                $.ajax({
                    data: $('#peminjam').serialize(),
                    url: "{{ route('peminjam.store') }}",
                    type: "POST",
                    dataType: 'json',
                    success: function (data) {
                        $('#peminjam').trigger("reset");
                        $('#submit_peminjam').html('Submit');
                        $('#modal-add').modal('hide');
                        $('.modal-title').html("Tambah Data Peminjam");
                        $('#peminjam_id').val('');
                        tbl_peminjam.ajax.reload(null, false);
                        
                        swal("Success", "Data Berhasil Disimpan", "success")
                    },
                    error: function (data) {
                        console.log('Error:', data);
                        $('#submit_peminjam').html('Submit');
                        $('#error_list').html('');
                        $.each(data.responseJSON.errors, function(key, value){
                            $('#form_error').show();
                            $('#error_list').append('<li>'+value+'</li>');
                        });
                    }
                });
            });

            $('body').on('click', '.edit_peminjam', function () {
                let peminjam_id = $(this).data('id');
                $.get("{{ route('peminjam') }}" +'/edit/' + peminjam_id, function (data) {
                    $('.modal-title').html("Edit Data Peminjam");
                    $('#submit_peminjam').val("edit");
                    $('#modal-add').modal('show');
                    $('#form_error').hide();
                    // show data
                    $('#peminjam_id').val(data.id);
                    $('#nama_peminjam').val(data.nama_peminjam);
                    $('#no_peminjam').val(data.phone);
                    $('#divisi_peminjam').val(data.divisi);
                    $('#alamat_peminjam').val(data.alamat);
                })
            });

            $('body').on('click', '.delete_peminjam', function () {
                let peminjam_id = $(this).data('id');
                // confirm("Are You sure want to delete !");
                
                swal({
                    title: 'Apakah anda yakin?',
                    text: 'Data akan dihapus secara permanen',
                    icon: 'warning',
                    buttons: ["Cancel", "Yes!"],
                }).then(function(value) {
                    if (value) {
                        $.ajax({
                            url: "{{ route('peminjam') }}" + '/delete/' + peminjam_id,
                            success: function (data) {
                                tbl_peminjam.ajax.reload(null, false);
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