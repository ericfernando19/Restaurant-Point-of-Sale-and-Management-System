<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Transaksi;
use App\Models\TransaksiDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf; // <-- TAMBAHKAN INI

class KasirTransaksiController extends Controller
{
    public function index()
    {
        $menus = Menu::all();
        return view('kasir.transaksi.index', compact('menus'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'items' => 'required',
            'total_harga' => 'required|integer',
            'bayar' => 'required|integer',
        ]);

        $items = json_decode($request->items, true);

        $kembalian = $request->bayar - $request->total_harga;

        $transaksi = Transaksi::create([
            'kode_transaksi' => 'TRX' . time(),
            'kasir_id' => Auth::id(),
            'total_harga' => $request->total_harga,
            'bayar' => $request->bayar,
            'kembalian' => $kembalian,
        ]);

        foreach ($items as $item) {
            TransaksiDetail::create([
                'transaksi_id' => $transaksi->id,
                'menu_id' => $item['id'],
                'qty' => $item['qty'],
                'subtotal' => $item['subtotal'],
            ]);
        }

        return redirect()->route('kasir.pembayaran.show', $transaksi->id);
    }

    // -------------------------------------------------
    // 🔥 FUNCTION CETAK PDF
    // -------------------------------------------------
    public function printPdf($id)
    {
        $transaksi = Transaksi::with('details.menu')->findOrFail($id);

        $pdf = Pdf::loadView('kasir.transaksi.struk_pdf', compact('transaksi'))
            ->setPaper('A5', 'portrait');

        return $pdf->download('Struk-' . $transaksi->id . '.pdf');
    }
    public function riwayat(Request $request)
    {
        $query = Transaksi::where('kasir_id', Auth::id());

        if ($request->tanggal) {
            $query->whereDate('created_at', $request->tanggal);
        }

        $riwayat = $query->latest()->paginate(10);

        return view('kasir.transaksi.riwayat', compact('riwayat'));
    }
    public function strukAjax($id)
    {
        $trx = Transaksi::with('details.menu')->findOrFail($id);

        return response()->json([
            'kode' => $trx->kode_transaksi,
            'total' => number_format($trx->total_harga),
            'bayar' => number_format($trx->bayar),
            'kembalian' => number_format($trx->kembalian),
            'pdf_url' => route('kasir.transaksi.struk', $trx->id)
        ]);
    }




}
