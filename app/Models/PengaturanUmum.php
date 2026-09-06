<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengaturanUmum extends Model
{
    protected $table = 'pengaturan_umum';

    protected $fillable = [
        'nama_perusahaan',
        'pemilik',
        'alamat_perusahaan',
        'title',
        'footer',
        'favicon',
    ];
}
