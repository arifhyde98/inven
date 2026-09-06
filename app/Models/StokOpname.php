<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StokOpname extends Model
{
    protected $table = 'stok_opname';

    protected $fillable = [
        'kode',
        'nama',
        'tanggal',
        'tempat',
        'status',
        'catatan',
        'disabled',
    ];

    public function cabang()
    {
        return $this->belongsTo(Cabang::class, 'tempat');
    }

    public function items()
    {
        return $this->hasMany(IsiStokOpname::class, 'kode', 'kode');
    }
}
