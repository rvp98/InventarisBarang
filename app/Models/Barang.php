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
        'foto_barang'
    ];
    protected $primaryKey = 'id';
}
