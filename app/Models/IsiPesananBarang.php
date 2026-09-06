<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IsiPesananBarang extends Model
{
    protected $table = 'isi_pesanan_barang';

    protected $fillable = [
        'kode',
        'nama',
        'id_barang',
        'stok_sekarang',
        'stok_pesan',
        'stok_terima',
        'harga_beli',
        'total_beli',
        'status',
        'id_cabang',
    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'id_barang');
    }

    public function pesanan()
    {
        return $this->belongsTo(PesananBarang::class, 'kode', 'kode');
    }

    public function cabang()
    {
        return $this->belongsTo(Cabang::class, 'id_cabang');
    }
}
