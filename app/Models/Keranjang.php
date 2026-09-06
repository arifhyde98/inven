<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Keranjang extends Model
{
    protected $table = 'keranjang';

    protected $fillable = [
        'barcode',
        'id_barang',
        'id_cabang',
        'jumlah',
        'satuan',
        'harga',
        'profit',
        'harga_total',
        'id_pembelian',
        'id_user',
    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'id_barang');
    }

    public function cabang()
    {
        return $this->belongsTo(Cabang::class, 'id_cabang');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
