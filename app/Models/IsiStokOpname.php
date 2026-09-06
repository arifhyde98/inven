<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IsiStokOpname extends Model
{
    protected $table = 'isi_stok_opname';

    protected $fillable = [
        'kode',
        'id_barang',
        'nama',
        'stok_aplikasi',
        'stok_fisik',
        'selisih_total',
        'selisih_harga',
        'id_cabang',
        'status',
    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'id_barang');
    }

    public function opname()
    {
        return $this->belongsTo(StokOpname::class, 'kode', 'kode');
    }

    public function cabang()
    {
        return $this->belongsTo(Cabang::class, 'id_cabang');
    }
}
