@extends('layouts.app')

@section('content')
    <!-- Header -->
    <div class="header bg-primary pb-6">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-center py-4">
                    <div class="col-lg-6 col-7">
                        <h6 class="h2 text-white d-inline-block mb-0">Transaksi Peminjaman</h6>
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
                        <a class="btn btn-icon btn-success" href="{{ route('add_peminjaman') }}" id="add_peminjaman">
                            <span class="btn-inner--icon"><i class="ni ni-fat-add"></i></span>
                            <span class="btn-inner--text">Tambah Peminjaman</span>
                        </a>
                        <div class="table-responsive py-4">
                            <table class="table table-flush" id="tbl_peminjaman">
                                <thead class="thead-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Peminjam</th>
                                        <th>Barang</th>
                                        <th>Tgl Peminjaman</th>
                                        <th>Tgl Pengembalian</th>
                                        <th>Keterangan</th>
                                        <th>Dilayani Oleh</th>
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
    <script>
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            function convertDateDBtoIndo(string) {
                bulanIndo = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September' , 'Oktober', 'November', 'Desember'];

                tanggal = string.split("-")[2];
                bulan = string.split("-")[1];
                tahun = string.split("-")[0];

                return tanggal + " " + bulanIndo[Math.abs(bulan)] + " " + tahun;
            }

            let tbl_peminjaman = $('#tbl_peminjaman').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('peminjaman') }}",
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                    { data: 'peminjam.nama_peminjam', name: 'peminjam' },
                    { data: 'list_barang', name: 'list_barang' },
                    { 
                        data: 'tgl_peminjaman', 
                        name: 'tgl_peminjaman',
                        render: function ( data, type, row, meta ) {
                            return convertDateDBtoIndo(data);
                        } 
                    },
                    { 
                        data: 'tgl_pengembalian', 
                        name: 'tgl_pengembalian',
                        render: function ( data, type, row, meta ) {
                            if (data) {
                                return convertDateDBtoIndo(data);
                            }
                            return '';
                        } 
                    },
                    { data: 'keterangan', name: 'keterangan' },
                    { data: 'dilayani', name: 'dilayani' },
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
                        targets: [3,4],  
                        className: 'text-center',
                    }
                ],
            });

            $('body').on('click', '.delete_peminjaman', function () {
                let peminjaman_id = $(this).data('id');
                // confirm("Are You sure want to delete !");
                
                swal({
                    title: 'Apakah anda yakin?',
                    text: 'Data akan dihapus secara permanen',
                    icon: 'warning',
                    buttons: ["Cancel", "Yes!"],
                }).then(function(value) {
                    if (value) {
                        $.ajax({
                            url: "{{ route('peminjaman') }}" + '/delete/' + peminjaman_id,
                            success: function (data) {
                                tbl_peminjaman.ajax.reload(null, false);
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