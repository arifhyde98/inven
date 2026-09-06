<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PesananBarang extends Model
{
    protected $table = 'pesanan_barang';

    protected $fillable = [
        'kode',
        'nama',
        'suplier',
        'tempat',
        'tanggal_pesan',
        'tanggal_terima',
        'status', // 0 = pending, 1 = received
        'jenis_pesanan', // 1 = restock, 2 = manual
    ];

    public function cabang()
    {
        return $this->belongsTo(Cabang::class, 'tempat');
    }

    public function suplierRelasi()
    {
        return $this->belongsTo(Suplier::class, 'suplier', 'id_suplier');
    }

    public function items()
    {
        return $this->hasMany(IsiPesananBarang::class, 'kode', 'kode');
    }

    public function itemsManual()
    {
        return $this->hasMany(PesananManual::class, 'kode', 'kode');
    }
}
