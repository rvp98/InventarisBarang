<?php

namespace App\Http\Controllers\Peminjam;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Peminjam;
use DataTables;

class PeminjamController extends Controller
{
    public function index(Request $request) {
        $data = Peminjam::orderBy('nama_peminjam', 'ASC')->get();
        // dd($data);
        if ($request->ajax()) {
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('divisi_peminjam', function($row){
                    $divisi = '<span class="badge badge-lg badge-primary">'.$row->divisi.'</span>';
                    return $divisi;
                })
                ->addColumn('action', function($row){
                    $btn = '<a href="javascript:void(0)" class="table-action edit_peminjam" data-id="'.$row->id.'" data-toggle="tooltip" data-original-title="Edit Peminjam"><i class="fas fa-user-edit"></i></a>';
                    $btn .= '<a href="javascript:void(0)" class="table-action delete_peminjam" data-id="'.$row->id.'" data-toggle="tooltip" data-original-title="Delete Peminjam"><i class="fas fa-trash"></i></a>';
                    return $btn;
                })
                ->rawColumns(['divisi_peminjam','action'])
                ->make(true);
        }

        return view('peminjam.peminjam');
    }

    public function fetchPeminjam($id) {
        $peminjam = Peminjam::find($id);
        return response()->json($peminjam);
    }

    public function storePeminjam(Request $request) {
        $validator = $this->validate(
            $request,
            [
                'nama_peminjam' => 'required',
                'no_peminjam' => 'required|numeric',
                'alamat_peminjam' => 'required'
            ]
        );

        Peminjam::updateOrCreate(
            ['id' => $request->peminjam_id],
            [
                'nama_peminjam' => $request->nama_peminjam,
                'phone' => $request->no_peminjam,
                'divisi' => $request->divisi_peminjam,
                'alamat' => $request->alamat_peminjam
            ]
        );

        return response()->json(
            ['success' => 'Data saved successfully.']
        );
    }

    public function deletePeminjam($id) {
        Peminjam::find($id)->delete();
        return response()->json(['success' => 'Data deleted successfully.']);
    }
}
