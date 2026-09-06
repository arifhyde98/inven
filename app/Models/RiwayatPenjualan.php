<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RiwayatPenjualan extends Model
{
    protected $table = 'riwayat_penjualan';

    protected $fillable = [
        'id_pembelian',
        'id_pembayaran_cicilan',
        'id_user',
        'id_keranjang',
        'id_cabang',
        'total_pembayaran',
        'tanggal',
        'tanggal_ind',
        'bulan_ind',
        'single_bulan',
        'single_tahun',
        'uang',
        'kembalian',
        'pendapatan',
        'hari',
        'metode_bayar',
        'status_utang',
    ];

    public function items()
    {
        return $this->hasMany(SemuaDataKeranjang::class, 'id_keranjang', 'id_keranjang');
    }

    public function cabang()
    {
        return $this->belongsTo(Cabang::class, 'id_cabang');
    }

    public function customer()
    {
        return $this->belongsTo(UserLangganan::class, 'id_user', 'id_user');
    }

    public function cicilans()
    {
        return $this->hasMany(PembayaranCicilan::class, 'id_pembelian', 'id_pembelian');
    }
}
