<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SemuaDataKeranjang extends Model
{
    protected $table = 'semua_data_keranjang';

    protected $fillable = [
        'barcode',
        'id_keranjang',
        'nama',
        'jumlah',
        'satuan',
        'harga',
        'harga_total',
        'id_del',
        'harga_beli',
        'harga_jual',
        'profit',
        'id_user',
        'id_cabang',
        'id_barang',
    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'id_barang');
    }

    public function cabang()
    {
        return $this->belongsTo(Cabang::class, 'id_cabang');
    }
}
