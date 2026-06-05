<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TargetHarianController extends Controller
{
    // ── TAMPILKAN HALAMAN TARGET HARIAN ───────────────────────────
    public function index()
    {
        $targetHarian = auth()->user()->target_harian ?? 0;
        return view('target.index', compact('targetHarian'));
    }

    // ── SIMPAN TARGET HARIAN ──────────────────────────────────────
    public function simpan(Request $request)
    {
        $request->validate([
            'target_harian' => 'required|numeric|min:1000',
        ], [
            'target_harian.required' => 'Nominal target wajib diisi.',
            'target_harian.numeric'  => 'Nominal harus berupa angka.',
            'target_harian.min'      => 'Nominal target minimal Rp 1.000.',
        ]);

        auth()->user()->update([
            'target_harian' => $request->target_harian,
        ]);

        return redirect()->route('target.index')
                         ->with('success', 'Target harian berhasil disimpan!');
    }
}