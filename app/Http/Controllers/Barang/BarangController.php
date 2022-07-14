<?php

namespace App\Http\Controllers\Barang;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Kategori;
use DataTables;
use File;

class BarangController extends Controller
{
    public function index(Request $request) {
        $kategori_barang = Kategori::pluck('nama_kategori', 'id');
        $data = Barang::with('kategoris')->orderBy('nama_barang', 'ASC')->get();
        if ($request->ajax()) {
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('kondisi_barang', function($row){
                    if ($row->kondisi == 'baik') {
                        $kondisi = '<span class="badge badge-lg badge-success">Baik</span>';
                    } else if ($row->kondisi == 'kurang baik') {
                        $kondisi = '<span class="badge badge-lg badge-warning">Kurang Baik</span>';
                    } else {
                        $kondisi = '<span class="badge badge-lg badge-danger">Rusak</span>';
                    }
                    return $kondisi;
                })
                ->addColumn('action', function($row){
                    $btn = '<a href="javascript:void(0)" class="table-action edit_barang" data-id="'.$row->id.'" data-toggle="tooltip" data-original-title="Edit Barang"><i class="fas fa-user-edit"></i></a>';
                    $btn .= '<a href="javascript:void(0)" class="table-action delete_barang" data-id="'.$row->id.'" data-toggle="tooltip" data-original-title="Delete Barang"><i class="fas fa-trash"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action', 'kondisi_barang'])
                ->make(true);
        }
        
        return view('barang.barang', ['kategori_barang' => $kategori_barang]);
    }

    public function fetchBarang($id) {
        $kategori = Barang::with('kategoris')->find($id);
        return response()->json($kategori);
    }

    public function storeBarang(Request $request) {
        $validator = $this->validate(
            $request,
            [
                'nama_barang' => 'required',
                'stok_barang' => 'required',
            ]
        );

        $foto_barang = $request->file('foto_barang');
        if ($foto_barang) {
            $nama_file = time()."_".$foto_barang->getClientOriginalName();
            $tujuan_upload = 'img_barang';
            $foto_barang->move($tujuan_upload, $nama_file);

            Barang::updateOrCreate(
                ['id' => $request->barang_id],
                [
                    'nama_barang' => $request->nama_barang,
                    'foto_barang' => $nama_file,
                    'kategori_id' => $request->kategori_id,
                    'stok' => $request->stok_barang,
                    'kondisi' => $request->kondisi_barang,
                    'deskripsi' => $request->deskripsi,
                ]
            );
        } else {
            Barang::updateOrCreate(
                ['id' => $request->barang_id],
                [
                    'nama_barang' => $request->nama_barang,
                    'kategori_id' => $request->kategori_id,
                    'stok' => $request->stok_barang,
                    'kondisi' => $request->kondisi_barang,
                    'deskripsi' => $request->deskripsi,
                ]
            );
        }
   
        return response()->json(
            ['success'=>'Data saved successfully.']
        );
    }

    public function deleteBarang($id) {
        $barang = Barang::where('id',$id)->first();
		File::delete('img_barang/'.$barang->foto_barang);
        Barang::find($id)->delete();
        return response()->json(['success' => 'Data deleted successfully.']);
    }
}
