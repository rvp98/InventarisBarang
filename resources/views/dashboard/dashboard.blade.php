@extends('layouts.app')

@section('content')
    <!-- Header -->
    <div class="header bg-primary pb-6">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-center py-4">
                    <div class="col-lg-6 col-7">
                        <h6 class="h2 text-white d-inline-block mb-0">Dashboard</h6>
                    </div>
                </div>
                <!-- Card stats -->
                <div class="row">
                    <div class="col-xl-3 col-md-6">
                        <div class="card card-stats">
                        <!-- Card body -->
                        <div class="card-body">
                            <div class="row">
                            <div class="col">
                                <h5 class="card-title text-uppercase text-muted mb-0">Total Barang</h5>
                                <span class="h2 font-weight-bold mb-0">{{ count($barang) }}</span>
                            </div>
                            <div class="col-auto">
                                <div class="icon icon-shape bg-gradient-red text-white rounded-circle shadow">
                                <i class="ni ni-active-40"></i>
                                </div>
                            </div>
                            </div>
                        </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <div class="card card-stats">
                        <!-- Card body -->
                        <div class="card-body">
                            <div class="row">
                            <div class="col">
                                <h5 class="card-title text-uppercase text-muted mb-0">Total Peminjam</h5>
                                <span class="h2 font-weight-bold mb-0">{{ count($peminjam) }}</span>
                            </div>
                            <div class="col-auto">
                                <div class="icon icon-shape bg-gradient-orange text-white rounded-circle shadow">
                                <i class="ni ni-chart-pie-35"></i>
                                </div>
                            </div>
                            </div>
                        </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <div class="card card-stats">
                        <!-- Card body -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h5 class="card-title text-uppercase text-muted mb-0">Transaksi Peminjaman Yang Sudah Kembali</h5>
                                    <span class="h2 font-weight-bold mb-0">{{ count($sudah) }}</span>
                                </div>
                                <div class="col-auto">
                                    <div class="icon icon-shape bg-gradient-green text-white rounded-circle shadow">
                                    <i class="ni ni-money-coins"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <div class="card card-stats">
                        <!-- Card body -->
                        <div class="card-body">
                            <div class="row">
                            <div class="col">
                                <h5 class="card-title text-uppercase text-muted mb-0">Transaksi Peminjaman Yang Belum Kembali</h5>
                                <span class="h2 font-weight-bold mb-0">{{ count($belum) }}</span>
                            </div>
                            <div class="col-auto">
                                <div class="icon icon-shape bg-gradient-info text-white rounded-circle shadow">
                                <i class="ni ni-chart-bar-32"></i>
                                </div>
                            </div>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Page content -->
    <div class="container-fluid mt--6">
        
    </div>
@endsection