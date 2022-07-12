<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;
    protected $table = "peminjaman";
    protected $fillable = [
        'user_id',
        'peminjam_id',
        'tgl_peminjaman',
        'tgl_pengembalian',
        'keterangan',
    ];
    protected $primaryKey = 'id';
}
