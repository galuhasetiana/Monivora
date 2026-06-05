<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfilController extends Controller
{
    // ── TAMPILKAN HALAMAN PROFIL ──────────────────────────────────
    public function index()
    {
        return view('profil.index');
    }

    // ── UPLOAD FOTO PROFIL ────────────────────────────────────────
    public function uploadFoto(Request $request)
    {
        $request->validate([
            'foto' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'foto.required' => 'Pilih foto terlebih dahulu.',
            'foto.image'    => 'File harus berupa gambar.',
            'foto.mimes'    => 'Format foto harus jpg, jpeg, atau png.',
            'foto.max'      => 'Ukuran foto maksimal 2MB.',
        ]);

        $user = auth()->user();

        // Hapus foto lama kalau ada
        if ($user->foto && Storage::disk('public')->exists($user->foto)) {
            Storage::disk('public')->delete($user->foto);
        }

        // Simpan foto baru
        $path = $request->file('foto')->store('foto-profil', 'public');
        $user->update(['foto' => $path]);

        return back()->with('success', 'Foto profil berhasil diperbarui!');
    }

    // ── HAPUS SEMUA DATA TRANSAKSI ────────────────────────────────
    public function hapusSemuaData(Request $request)
    {
        Transaksi::where('user_id', auth()->id())->delete();

        return back()->with('success', 'Semua data transaksi berhasil dihapus.');
    }
}