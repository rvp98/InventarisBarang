<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Peminjam;
use App\Models\Peminjaman;
use Auth;

class DashboardController extends Controller
{
    public function index() {
        $barang = Barang::get();
        $peminjam = Peminjam::get();
        $sudah = Peminjaman::whereNotNull('tgl_pengembalian')->get();
        $belum = Peminjaman::whereNull('tgl_pengembalian')->get();

        return view('dashboard.dashboard', ['barang' => $barang, 'peminjam' => $peminjam, 'sudah' => $sudah, 'belum' => $belum]);
    }
}
