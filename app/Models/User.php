<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users';

    protected $fillable = [
        'nama',
        'username',
        'email',
        'jenis_kelamin',
        'password',
        'foto_profile',
        'penempatan_cabang',
        'role_id',
        'status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'status' => 'integer',
            'role_id' => 'integer',
            'penempatan_cabang' => 'integer',
        ];
    }

    public function getNameAttribute(): string
    {
        return $this->nama ?? $this->username ?? '';
    }

    public function setNameAttribute($value): void
    {
        $this->attributes['nama'] = $value;
    }

    public function isSuperAdmin(): bool
    {
        return $this->role_id === 1;
    }

    public function isAdmin(): bool
    {
        return $this->role_id === 2;
    }

    public function isActive(): bool
    {
        return (int) $this->status === 1;
    }

    public function role()
    {
        return $this->belongsTo(RoleUser::class, 'role_id');
    }

    public function cabang()
    {
        return $this->belongsTo(Cabang::class, 'penempatan_cabang');
    }

    public function penjualans()
    {
        return $this->hasMany(RiwayatPenjualan::class, 'id_user');
    }

    public function keranjangs()
    {
        return $this->hasMany(Keranjang::class, 'id_user');
    }
}
