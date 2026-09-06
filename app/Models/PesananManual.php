<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PesananManual extends Model
{
    protected $table = 'pesanan_manual';

    protected $fillable = [
        'kode',
        'nama_barang',
        'kategori',
        'satuan',
        'harga_beli',
        'jumlah',
        'harga_total',
        'id_user',
        'id_cabang',
    ];

    public function pesanan()
    {
        return $this->belongsTo(PesananBarang::class, 'kode', 'kode');
    }

    public function cabang()
    {
        return $this->belongsTo(Cabang::class, 'id_cabang');
    }
}
