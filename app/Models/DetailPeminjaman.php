<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPeminjaman extends Model
{
    use HasFactory;
    protected $table = "detail_peminjaman";
    protected $fillable = [
        'peminjaman_id',
        'barang_id',
        'jumlah'
    ];
    protected $primaryKey = 'id';

    public function peminjaman() {
    	return $this->belongsTo('App\Models\Peminjaman');
    }

    public function barang() {
    	return $this->belongsTo('App\Models\Barang');
    }
}
