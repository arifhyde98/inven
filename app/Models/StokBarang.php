<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StokBarang extends Model
{
    protected $table = 'stok_barang';

    protected $fillable = [
        'id_barang',
        'tgl',
        'tanggal',
        'jumlah',
        'keterangan',
        'status', // 1 = in, 2 = out
        'in_out',
    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'id_barang');
    }
}
