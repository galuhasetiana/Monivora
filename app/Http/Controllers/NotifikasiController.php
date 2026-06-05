<?php

namespace App\Http\Controllers;

use App\Models\Notifikasi;

class NotifikasiController extends Controller
{
    public function index()
    {
        $notifikasi = Notifikasi::where('user_id', auth()->id())
                        ->orderBy('created_at', 'desc')
                        ->get();

        // Tandai semua sebagai sudah dibaca
        Notifikasi::where('user_id', auth()->id())
            ->where('dibaca', false)
            ->update(['dibaca' => true]);

        return view('notifikasi.index', compact('notifikasi'));
    }
}
