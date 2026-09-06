<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cabang extends Model
{
    protected $table = 'data_cabang';

    protected $fillable = [
        'nama_cabang',
        'alamat',
        'jumlah_barang',
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'penempatan_cabang');
    }

    public function barangs()
    {
        return $this->hasMany(Barang::class, 'id_cabang');
    }

    public function penjualans()
    {
        return $this->hasMany(RiwayatPenjualan::class, 'id_cabang');
    }

    public function pengeluarans()
    {
        return $this->hasMany(RiwayatPengeluaran::class, 'id_cabang');
    }

    public function pesananBarangs()
    {
        return $this->hasMany(PesananBarang::class, 'tempat');
    }
}
