<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notifikasi extends Model
{
    protected $table = 'notifikasi';

    protected $fillable = [
        'user_id',
        'judul',
        'isi',
        'type',
        'dibaca',
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Scope: notifikasi yang belum dibaca
    public function scopeBelumDibaca($query)
    {
        return $query->where('dibaca', false);
    }
}
