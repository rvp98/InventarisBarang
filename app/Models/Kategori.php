<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;
    protected $table = "kategori";
    protected $fillable = [
        'nama_kategori',
    ];
    protected $primaryKey = 'id';

    public function barangs() {
    	return $this->hasMany('App\Models\Barang');
    }
}
