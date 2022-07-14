<?php

namespace App\Http\Controllers\Barang;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kategori;
use DataTables;

class KategoriBarangController extends Controller
{
    public function index(Request $request) {
        $data = Kategori::orderBy('nama_kategori', 'ASC')->get();
        // dd($data);
        if ($request->ajax()) {
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<a href="javascript:void(0)" class="table-action edit_kategori" data-id="'.$row->id.'" data-toggle="tooltip" data-original-title="Edit Kategori"><i class="fas fa-user-edit"></i></a>';
                    $btn .= '<a href="javascript:void(0)" class="table-action delete_kategori" data-id="'.$row->id.'" data-toggle="tooltip" data-original-title="Delete Kategori"><i class="fas fa-trash"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('barang.kategori');
    }

    public function fetchKategori($id) {
        $kategori = Kategori::find($id);
        return response()->json($kategori);
    }

    public function storeKategori(Request $request) {
        $validator = $this->validate(
            $request,
            [
                'nama_kategori' => 'required',
            ]
        );

        Kategori::updateOrCreate(
            ['id' => $request->kategori_id],
            [
                'nama_kategori' => $request->nama_kategori
            ]
        );

        return response()->json(
            ['success' => 'Data saved successfully.']
        );
    }

    public function deleteKategori($id) {
        Kategori::find($id)->delete();
        return response()->json(['success' => 'Data deleted successfully.']);
    }
}
