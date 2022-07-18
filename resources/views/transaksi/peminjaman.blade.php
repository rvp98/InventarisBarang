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

            let tbl_peminjaman = $('#tbl_peminjaman').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('peminjaman') }}",
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                    { data: 'peminjam.nama_peminjam', name: 'peminjam' },
                    { data: 'list_barang', name: 'list_barang' },
                    { data: 'tgl_peminjaman', name: 'tgl_peminjaman' },
                    { data: 'tgl_pengembalian', name: 'tgl_pengembalian' },
                    { data: 'keterangan', name: 'keterangan' },
                    { data: 'action', name: 'action', orderable: false, searchable: false },
                ],
                language: {
                    paginate: {
                        next: '<i class="fas fa-angle-right"></i>', // or '→'
                        previous: '<i class="fas fa-angle-left"></i>' // or '←' 
                    }
                },
            });
        });
    </script>
@endsection