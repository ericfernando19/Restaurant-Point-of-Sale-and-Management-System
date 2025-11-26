<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PembayaranController extends Controller
{
    public function index()
    {
        $transaksi = Transaksi::where('status', 'pending')->get();
        return view('kasir.pembayaran.index', compact('transaksi'));
    }

    public function show($id)
    {
        $trx = Transaksi::with('details.menu')->findOrFail($id);
        return view('kasir.pembayaran.show', compact('trx'));
    }

    /**
     * PROCESS PEMBAYARAN (AJAX)
     */
    public function process(Request $request, $id)
    {
        $request->validate([
            'bayar' => 'required|integer'
        ]);

        $trx = Transaksi::findOrFail($id);

        // Hitung kembalian
        $kembalian = $request->bayar - $trx->total_harga;
        if ($kembalian < 0) {
            return response()->json([
                'success' => false,
                'message' => 'Uang bayar kurang dari total!'
            ], 400);
        }

        // Simpan data pembayaran
        $trx->bayar = $request->bayar;
        $trx->kembalian = $kembalian;
        $trx->status = 'lunas';
        $trx->save();

        // Kirim data ke popup
        return response()->json([
            'success' => true,
            'kode' => $trx->kode_transaksi,
            'total' => number_format($trx->total_harga),
            'bayar' => number_format($trx->bayar),
            'kembalian' => number_format($trx->kembalian),
            'pdf_url' => route('kasir.pembayaran.strukpdf', $trx->id)
        ]);
    }

    /**
     * CETAK STRUK PDF
     */
    public function strukpdf($id)
    {
        $transaksi = Transaksi::with('details.menu')->findOrFail($id);
        $details = $transaksi->details;

        return Pdf::loadView('kasir.pembayaran.struk', [
            'transaksi' => $transaksi,
            'details' => $details
        ])->stream();
    }

}
