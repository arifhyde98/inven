<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserLangganan extends Model
{
    protected $table = 'user_langganan';

    protected $fillable = [
        'id_user',
        'nama_user',
        'tlp_user',
        'alamat',
        'penempatan',
    ];

    public function cabang()
    {
        return $this->belongsTo(Cabang::class, 'penempatan');
    }
}
