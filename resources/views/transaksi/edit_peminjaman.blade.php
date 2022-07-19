@extends('layouts.app')

@section('content')
    <!-- Header -->
    <div class="header bg-primary pb-6">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-center py-4">
                    <div class="col-lg-6 col-7">
                        <h6 class="h2 text-white d-inline-block mb-0">Edit Transaksi Peminjaman</h6>
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
                    <form method="post" id="dynamic_form">
                        @csrf
                        <span id="result"></span>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label">Peminjam</label>
                                        <input type="hidden" name="peminjaman_id" id="peminjaman_id" value="{{ $peminjaman->id }}">
                                        {!! Form::select('peminjam', $peminjam, $peminjaman->peminjam->id,['class' => 'form-control', 'id' => 'peminjam']) !!}
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-control-label">Tangal Peminjaman</label>
                                        <input type="date" name="tgl_peminjaman" id="tgl_peminjaman" class="form-control" value="{{ $peminjaman->tgl_peminjaman }}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-control-label">Tangal Pengembalian</label>
                                        <input type="date" name="tgl_pengembalian" id="tgl_pengembalian" class="form-control" value="{{ $peminjaman->tgl_pengembalian }}">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-control-label">List Barang</label>
                                        <table class="table table-bordered table-striped" id="barang_table">
                                            <thead>
                                                <tr>
                                                    <th width="35%">Nama Barang</th>
                                                    <th width="35%">Jumlah</th>
                                                    <th width="30%">&nbsp;</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $no = 1;
                                                @endphp
                                                @foreach ($detail_peminjaman as $dp)
                                                    <tr>
                                                        <td>{!! Form::select("barang[]", $barang, $dp->barang_id,["class" => "form-control", "id" => "barang"]) !!}</td>
                                                        <td><input type="number" name="jumlah[]" class="form-control" value="{{ $dp->jumlah }}" min="1" /></td>
                                                        @if ($no == 1)
                                                            <td><button type="button" name="add" id="add" class="btn btn-success">Tambah</button></td></tr>
                                                        @else
                                                            <td><button type="button" name="remove" id="" class="btn btn-danger remove">Hapus</button></td>
                                                        @endif
                                                        @php
                                                            $no++;
                                                        @endphp
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-control-label">Keterangan</label>
                                        <textarea name="keterangan" id="keterangan" rows="5" class="form-control">{{ $peminjaman->keterangan }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer" style="text-align: right">
                            <button type="submit" id="submit_peminjaman" class="btn btn-success">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#peminjam').select2();

            var count = 1;
            // dynamic_field(count);

            function dynamic_field(number) {
                html = '<tr>';
                html += '<td>{!! Form::select("barang[]", $barang, null,["class" => "form-control", "id" => "barang"]) !!}</td>';
                html += '<td><input type="number" name="jumlah[]" class="form-control" value="1" min="1" /></td>';
                if (number > 1) {
                    html += '<td><button type="button" name="remove" id="" class="btn btn-danger remove">Hapus</button></td></tr>';
                    $('tbody').append(html);
                } else {   
                    html += '<td><button type="button" name="add" id="add" class="btn btn-success">Tambah</button></td></tr>';
                    $('tbody').html(html);
                }
            }

            $('#add').on('click', function (e) {
                count++;
                dynamic_field(count);
            });

            $(document).on('click', '.remove', function(){
                count--;
                $(this).closest("tr").remove();
            });

            $('#dynamic_form').on('submit', function(event){
                event.preventDefault();
                $.ajax({
                    url:'{{ route("peminjaman.store_edit") }}',
                    method:'post',
                    data:$(this).serialize(),
                    dataType:'json',
                    beforeSend:function(){
                        $('#submit_peminjaman').html('Loading...');
                    },
                    success:function(data) {
                        dynamic_field(1);
                        $('#result').html('<div class="alert alert-success">'+data.success+'</div>');
                        
                        $('#submit_peminjaman').html('Submit');
                    },
                    error: function (data) {
                        $('#result').html('<div class="alert alert-danger">Please Try Again</div>');
                        $('#submit_peminjaman').html('Submit');
                    }
                })
            });
        });
    </script>
@endsection