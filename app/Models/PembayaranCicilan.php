<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PembayaranCicilan extends Model
{
    protected $table = 'pembayaran_cicilan';

    protected $fillable = [
        'id_cicilan',
        'id_pembelian',
        'id_user',
        'id_cabang',
        'tanggal',
        'sisa_cicilan',
        'uang',
        'sisa_cicilan_akhir',
        'kembalian',
    ];

    public function penjualan()
    {
        return $this->belongsTo(RiwayatPenjualan::class, 'id_pembelian', 'id_pembelian');
    }

    public function cabang()
    {
        return $this->belongsTo(Cabang::class, 'id_cabang');
    }

    public function customer()
    {
        return $this->belongsTo(UserLangganan::class, 'id_user', 'id_user');
    }
}
