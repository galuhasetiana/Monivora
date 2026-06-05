<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Total saldo
        $pemasukan   = Transaksi::milikSaya()
                        ->where('jenis', 'Pemasukan')
                        ->sum('jumlah');

        $pengeluaran = Transaksi::milikSaya()
                        ->where('jenis', 'Pengeluaran')
                        ->sum('jumlah');

        $saldo = $pemasukan - $pengeluaran;

        // 5 transaksi terbaru
        $transaksiTerbaru = Transaksi::milikSaya()
                            ->orderBy('tanggal', 'desc')
                            ->orderBy('created_at', 'desc')
                            ->take(5)
                            ->get();

        // Target harian: pengeluaran hari ini vs rata-rata 7 hari lalu
        $pengeluaranHariIni = Transaksi::milikSaya()
                                ->where('jenis', 'Pengeluaran')
                                ->whereDate('tanggal', today())
                                ->sum('jumlah');

        $targetHarian = 50000; // default, nanti bisa dari tabel settings user
        $persenTarget = $targetHarian > 0
                        ? min(100, round(($pengeluaranHariIni / $targetHarian) * 100))
                        : 0;

        return view('dashboard.index', compact(
            'user',
            'saldo',
            'pemasukan',
            'pengeluaran',
            'transaksiTerbaru',
            'pengeluaranHariIni',
            'targetHarian',
            'persenTarget',
        ));
    }
}
