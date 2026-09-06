<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataHutang extends Model
{
    protected $table = 'data_hutang';

    protected $fillable = [
        'nama',
        'tanggal',
        'kode',
        'id_cabang',
        'total_hutang',
        'sisa_hutang',
        'catatan',
        'bukti',
        'status', // 0 = unpaid, 1 = paid
    ];

    public function cabang()
    {
        return $this->belongsTo(Cabang::class, 'id_cabang');
    }

    public function payments()
    {
        return $this->hasMany(PembayaranHutang::class, 'kode', 'kode');
    }
}
