<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PembayaranHutang extends Model
{
    protected $table = 'pembayaran_hutang';

    protected $fillable = [
        'kode',
        'nama',
        'id_cabang',
        'tanggal',
        'sisa_hutang',
        'uang',
        'sisa_hutang_akhir',
        'kembalian',
    ];

    public function hutang()
    {
        return $this->belongsTo(DataHutang::class, 'kode', 'kode');
    }

    public function cabang()
    {
        return $this->belongsTo(Cabang::class, 'id_cabang');
    }
}
