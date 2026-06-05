<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $table = 'transaksi';

    protected $fillable = [
        'user_id',
        'jenis',
        'tanggal',
        'keterangan',
        'kategori',
        'jumlah',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'jumlah'  => 'decimal:2',
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Scope: hanya transaksi user yang login
    public function scopeMilikSaya($query)
    {
        return $query->where('user_id', auth()->id());
    }

    // Scope: filter rentang tanggal
    public function scopeRentang($query, $start, $end)
    {
        return $query->whereBetween('tanggal', [$start, $end]);
    }
}
