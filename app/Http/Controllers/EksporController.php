<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;

class EksporController extends Controller
{
    // ── TAMPILKAN HALAMAN EKSPOR ──────────────────────────────────
    public function index()
    {
        return view('ekspor.index');
    }

    // ── EKSPOR PDF ────────────────────────────────────────────────
    // Membutuhkan package: barryvdh/laravel-dompdf
    // Install: composer require barryvdh/laravel-dompdf
    public function exportPdf(Request $request)
    {
        $request->validate([
            'start' => 'required|date',
            'end'   => 'required|date|after_or_equal:start',
        ]);

        $transaksi = Transaksi::milikSaya()
                        ->rentang($request->start, $request->end)
                        ->orderBy('tanggal')
                        ->get();

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('ekspor.pdf', [
            'transaksi' => $transaksi,
            'start'     => $request->start,
            'end'       => $request->end,
            'user'      => auth()->user(),
        ]);

        return $pdf->download('monifora-transaksi.pdf');
    }

    // ── EKSPOR EXCEL ──────────────────────────────────────────────
    // Membutuhkan package: maatwebsite/excel
    // Install: composer require maatwebsite/excel
    public function exportExcel(Request $request)
    {
        $request->validate([
            'start' => 'required|date',
            'end'   => 'required|date|after_or_equal:start',
        ]);

        // Contoh penggunaan Maatwebsite Excel Export:
        // return Excel::download(new TransaksiExport($request->start, $request->end), 'transaksi.xlsx');

        // Untuk sementara, kembalikan CSV sederhana:
        $transaksi = Transaksi::milikSaya()
                        ->rentang($request->start, $request->end)
                        ->orderBy('tanggal')
                        ->get();

        $filename = 'monifora-transaksi.csv';
        $headers  = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function () use ($transaksi) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Tanggal', 'Jenis', 'Kategori', 'Keterangan', 'Jumlah']);
            foreach ($transaksi as $t) {
                fputcsv($file, [
                    $t->tanggal->format('d/m/Y'),
                    $t->jenis,
                    $t->kategori,
                    $t->keterangan,
                    $t->jumlah,
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
