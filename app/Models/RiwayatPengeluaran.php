<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RiwayatPengeluaran extends Model
{
    protected $table = 'riwayat_pengeluaran';

    protected $fillable = [
        'kode_pesanan',
        'id_cabang',
        'total_pengeluaran',
        'tanggal_ind',
        'bulan_ind',
        'single_bulan',
        'single_tahun',
        'bukti_pengeluaran',
        'status_bukti', // 0 = pending, 1 = approved, 2 = rejected
        'catatan',
        'jenis',
        'hari',
    ];

    public function cabang()
    {
        return $this->belongsTo(Cabang::class, 'id_cabang');
    }
}
