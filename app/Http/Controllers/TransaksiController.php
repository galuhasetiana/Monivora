<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class TransaksiController extends Controller
{
    // ── RIWAYAT TRANSAKSI ─────────────────────────────────────────
    public function index()
    {
        // Data untuk chart mingguan
        $labels      = [];
        $pemasukan   = [];
        $pengeluaran = [];

        for ($i = 6; $i >= 0; $i--) {
            $hari = Carbon::today()->subDays($i);
            $labels[] = $hari->translatedFormat('D'); // Sen, Sel, dst

            $pemasukan[] = (float) Transaksi::milikSaya()
                ->where('jenis', 'Pemasukan')
                ->whereDate('tanggal', $hari)
                ->sum('jumlah');

            $pengeluaran[] = (float) Transaksi::milikSaya()
                ->where('jenis', 'Pengeluaran')
                ->whereDate('tanggal', $hari)
                ->sum('jumlah');
        }

        // Grup transaksi per hari
        $transaksi = Transaksi::milikSaya()
            ->orderBy('tanggal', 'desc')
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy(function ($item) {
                $tgl = Carbon::parse($item->tanggal);
                if ($tgl->isToday())    return 'Hari Ini';
                if ($tgl->isYesterday()) return 'Kemarin';
                return $tgl->translatedFormat('d F Y');
            });

        return view('transaksi.riwayat', compact(
            'transaksi',
            'labels',
            'pemasukan',
            'pengeluaran',
        ));
    }

    // ── FORM TAMBAH TRANSAKSI ─────────────────────────────────────
    public function create()
    {
        return view('transaksi.tambah');
    }

    // ── SIMPAN TRANSAKSI BARU ─────────────────────────────────────
    public function store(Request $request)
    {
        $request->validate([
            'jenis'      => 'required|in:Pemasukan,Pengeluaran',
            'tanggal'    => 'required|date',
            'keterangan' => 'required|string|max:255',
            'kategori'   => 'nullable|string|max:100',
            'jumlah'     => 'required|numeric|min:1',
        ], [
            'jenis.required'      => 'Jenis transaksi wajib dipilih.',
            'tanggal.required'    => 'Tanggal wajib diisi.',
            'keterangan.required' => 'Keterangan wajib diisi.',
            'jumlah.required'     => 'Jumlah wajib diisi.',
            'jumlah.numeric'      => 'Jumlah harus berupa angka.',
            'jumlah.min'          => 'Jumlah minimal Rp 1.',
        ]);

        Transaksi::create([
            'user_id'    => auth()->id(),
            'jenis'      => $request->jenis,
            'tanggal'    => $request->tanggal,
            'keterangan' => $request->keterangan,
            'kategori'   => $request->kategori ?? 'Lainnya',
            'jumlah'     => $request->jumlah,
        ]);

        return redirect()->route('transaksi.index')
                         ->with('success', 'Transaksi berhasil disimpan!');
    }

    // ── FORM EDIT TRANSAKSI ───────────────────────────────────────
    public function edit($id)
    {
        $transaksi = Transaksi::milikSaya()->findOrFail($id);
        return view('transaksi.edit', compact('transaksi'));
    }

    // ── UPDATE TRANSAKSI ──────────────────────────────────────────
    public function update(Request $request, $id)
    {
        $transaksi = Transaksi::milikSaya()->findOrFail($id);

        $request->validate([
            'jenis'      => 'required|in:Pemasukan,Pengeluaran',
            'tanggal'    => 'required|date',
            'keterangan' => 'required|string|max:255',
            'jumlah'     => 'required|numeric|min:1',
        ]);

        $transaksi->update($request->only(
            'jenis', 'tanggal', 'keterangan', 'kategori', 'jumlah'
        ));

        return redirect()->route('transaksi.index')
                         ->with('success', 'Transaksi berhasil diperbarui!');
    }

    // ── HAPUS TRANSAKSI ───────────────────────────────────────────
    public function destroy($id)
    {
        $transaksi = Transaksi::milikSaya()->findOrFail($id);
        $transaksi->delete();

        return redirect()->route('transaksi.index')
                         ->with('success', 'Transaksi berhasil dihapus.');
    }
}
