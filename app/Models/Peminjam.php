<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjam extends Model
{
    use HasFactory;
    protected $table = "peminjam";
    protected $fillable = [
        'nama_peminjam',
        'alamat',
        'phone',
        'divisi',
    ];
    protected $primaryKey = 'id';

    public function peminjaman() {
    	return $this->hasOne('App\Models\Peminjaman');
    }
}
