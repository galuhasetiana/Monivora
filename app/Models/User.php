<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = ['name', 'email', 'password', 'foto', 'target_harian'];

    protected $hidden = ['password', 'remember_token'];

    // Relasi: satu user punya banyak transaksi
    public function transaksi()
    {
        return $this->hasMany(Transaksi::class);
    }

    // Relasi: satu user punya banyak notifikasi
    public function notifikasi()
    {
        return $this->hasMany(Notifikasi::class);
    }
}
