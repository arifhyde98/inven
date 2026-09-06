<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    protected $table = 'barang';

    protected $fillable = [
        'barcode',
        'nama_barang',
        'gambar',
        'kategori',
        'harga_beli',
        'harga_jual',
        'profit',
        'stok',
        'satuan',
        'id_cabang',
        'keterangan',
        'id_suplier',
        'kode_penjualan',
        'kode_pembelian',
        'exp_date',
    ];

    public function cabang()
    {
        return $this->belongsTo(Cabang::class, 'id_cabang');
    }

    public function suplier()
    {
        return $this->belongsTo(Suplier::class, 'id_suplier');
    }

    public function stokLogs()
    {
        return $this->hasMany(StokBarang::class, 'id_barang');
    }
}
