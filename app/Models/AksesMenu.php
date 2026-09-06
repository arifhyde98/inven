<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AksesMenu extends Model
{
    protected $table = 'akses_menu';

    protected $fillable = [
        'role_id',
        'menu_id',
    ];
}
