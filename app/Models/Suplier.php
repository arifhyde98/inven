<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Suplier extends Model
{
    protected $table = 'suplier';

    protected $fillable = [
        'id_suplier',
        'nama_suplier',
        'alamat_suplier',
        'telp',
    ];

    public function barangs()
    {
        return $this->hasMany(Barang::class, 'id_suplier');
    }

    public function pesananBarangs()
    {
        return $this->hasMany(PesananBarang::class, 'suplier', 'id_suplier');
    }
}
