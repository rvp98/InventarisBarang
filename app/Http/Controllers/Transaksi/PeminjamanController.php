<?php

namespace App\Http\Controllers\Transaksi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\DetailPeminjaman;
use App\Models\Peminjam;
use App\Models\Barang;
use App\Models\User;
use DataTables;
use Auth;

class PeminjamanController extends Controller
{
    public function index(Request $request) {
        if (Auth::user()->role == 'superadmin') {
            $data = Peminjaman::with(['peminjam'])->orderBy('id', 'DESC')->get();
        } else {
            $data = Peminjaman::with(['peminjam'])->where('user_id', Auth::user()->id)->orderBy('id', 'DESC')->get();
        }
        
        if ($request->ajax()) {
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('list_barang', function($row){
                    $detail = DetailPeminjaman::with('barang')->where('peminjaman_id', $row->id)->get();
                    $list = '<ul>';
                    foreach ($detail as $d) {
                        $list .= '<li>'.$d->barang->nama_barang.' x '.$d->jumlah.'</li>';
                    }
                    $list .= '</ul>';
                    return $list;
                })
                ->addColumn('dilayani', function($row){
                    $admin = User::where('id', $row->user_id)->first();
                    return $admin->name;
                })
                ->addColumn('action', function($row){
                    $btn = '<a href="'.route('edit_peminjaman', ['id' => $row->id]).'" class="table-action edit_peminjaman" data-id="'.$row->id.'" data-toggle="tooltip" data-original-title="Edit Peminjaman"><i class="fas fa-user-edit"></i></a>';
                    $btn .= '<a href="javascript:void(0)" class="table-action delete_peminjaman" data-id="'.$row->id.'" data-toggle="tooltip" data-original-title="Delete Peminjaman"><i class="fas fa-trash"></i></a>';
                    return $btn;
                })
                ->rawColumns(['list_barang','dilayani','action'])
                ->make(true);
        }

        return view('transaksi.peminjaman');
    }

    public function addPeminjaman(Request $request) {
        $peminjam = Peminjam::pluck('nama_peminjam', 'id');
        $barang = Barang::where('stok', '!=', 0)->pluck('nama_barang', 'id');

        return view('transaksi.add_peminjaman', ['peminjam' => $peminjam, 'barang' => $barang]);
    }

    public function editPeminjaman(Request $request, $id) {
        $peminjam = Peminjam::pluck('nama_peminjam', 'id');
        $peminjaman = Peminjaman::with(['peminjam'])->where('id', $id)->first();
        $detail_peminjaman = DetailPeminjaman::where('peminjaman_id', $id)->get();
        $barang = Barang::pluck('nama_barang', 'id');

        return view('transaksi.edit_peminjaman', ['barang' => $barang, 'peminjam' => $peminjam, 'peminjaman' => $peminjaman, 'detail_peminjaman' => $detail_peminjaman]);
    }

    public function storePeminjaman(Request $request) {
        $validator = $this->validate(
            $request,
            [
                'peminjam' => 'required',
                'tgl_peminjaman' => 'required',
            ]
        );

        $barang = $request->barang;
        $jumlah = $request->jumlah;

        if ($request->keterangan) {
            $peminjaman = Peminjaman::updateOrCreate(
                ['id' => $request->peminjaman_id],
                [
                    'user_id' => Auth::user()->id,
                    'peminjam_id' => $request->peminjam,
                    'tgl_peminjaman' => $request->tgl_peminjaman,
                    'keterangan' => $request->keterangan,
                ]
            );
        } else {
            $peminjaman = Peminjaman::updateOrCreate(
                ['id' => $request->peminjaman_id],
                [
                    'user_id' => Auth::user()->id,
                    'peminjam_id' => $request->peminjam,
                    'tgl_peminjaman' => $request->tgl_peminjaman,
                ]
            );
        }
        

        if ($peminjaman) {
            for($count = 0; $count < count($barang); $count++) {
                Barang::find($barang[$count])->decrement('stok', $jumlah[$count]);
                $data = array(
                    'peminjaman_id' => $peminjaman->id,
                    'barang_id' => $barang[$count],
                    'jumlah'  => $jumlah[$count]
                );
                $insert_data[] = $data; 
            }

            DetailPeminjaman::insert($insert_data);
        }

        return response()->json([
            'success'  => 'Data Added successfully.'
        ]);
    }

    public function storeEditPeminjaman(Request $request) {
        $validator = $this->validate(
            $request,
            [
                'peminjam' => 'required',
                'tgl_peminjaman' => 'required',
            ]
        );

        $barang = $request->barang;
        $jumlah = $request->jumlah;

        if ($request->keterangan) {
            $peminjaman = Peminjaman::updateOrCreate(
                ['id' => $request->peminjaman_id],
                [
                    'user_id' => Auth::user()->id,
                    'peminjam_id' => $request->peminjam,
                    'tgl_peminjaman' => $request->tgl_peminjaman,
                    'tgl_pengembalian' => $request->tgl_pengembalian,
                    'keterangan' => $request->keterangan,
                ]
            );
        } else {
            $peminjaman = Peminjaman::updateOrCreate(
                ['id' => $request->peminjaman_id],
                [
                    'user_id' => Auth::user()->id,
                    'peminjam_id' => $request->peminjam,
                    'tgl_peminjaman' => $request->tgl_peminjaman,
                    'tgl_pengembalian' => $request->tgl_pengembalian,
                ]
            );
        }
        

        if ($peminjaman) {
            if ($peminjaman->tgl_pengembalian) {
                $detail_peminjaman = DetailPeminjaman::where('peminjaman_id', $request->peminjaman_id)->get();
                foreach ($detail_peminjaman as $dp) {
                    Barang::find($dp->barang_id)->increment('stok', $dp->jumlah);
                }
            } else {
                $detail_peminjaman = DetailPeminjaman::where('peminjaman_id', $request->peminjaman_id)->get();
                foreach ($detail_peminjaman as $dp) {
                    Barang::find($dp->barang_id)->increment('stok', $dp->jumlah);
                }
                DetailPeminjaman::where('peminjaman_id', $request->peminjaman_id)->delete();

                for($count = 0; $count < count($barang); $count++) {
                    Barang::find($barang[$count])->decrement('stok', $jumlah[$count]);
                    $data = array(
                        'peminjaman_id' => $peminjaman->id,
                        'barang_id' => $barang[$count],
                        'jumlah'  => $jumlah[$count]
                    );
                    $insert_data[] = $data; 
                }

                DetailPeminjaman::insert($insert_data);
            }
        }

        return response()->json([
            'success'  => 'Data Added successfully.'
        ]);
    }

    public function deletePeminjaman($id) {
        $detail_peminjaman = DetailPeminjaman::where('peminjaman_id', $id)->get();
        foreach ($detail_peminjaman as $dp) {
            Barang::find($dp->barang_id)->increment('stok', $dp->jumlah);
        }
        Peminjaman::find($id)->delete();
        DetailPeminjaman::where('peminjaman_id', $id)->delete();
        return response()->json(['success' => 'Data deleted successfully.']);
    }
}
