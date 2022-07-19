<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;
    protected $table = "barang";
    protected $fillable = [
        'kategori_id',
        'nama_barang',
        'stok',
        'deskripsi',
        'kondisi',
        'foto_barang',
        'status'
    ];
    protected $primaryKey = 'id';

    public function kategoris() {
    	return $this->belongsTo('App\Models\Kategori', 'kategori_id');
    }

    public function detail_peminjaman() {
        return $this->hasOne('App\Models\DetailPeminjaman');
    }
}
