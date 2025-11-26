<?php

namespace App\Http\Controllers\Koki;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;

class DashboardController extends Controller
{
    public function index()
    {
        // Hitung jumlah pesanan berdasarkan status KOKI
        $menunggu = Transaksi::where('status_koki', 'pending')->count();
        $diproses = Transaksi::where('status_koki', 'diproses')->count();
        $selesai = Transaksi::where('status_koki', 'selesai_koki')->count();

        return view('dashboard.koki', compact('menunggu', 'diproses', 'selesai'));
    }

    // Pesanan masuk (status pending)
    public function pesananMasuk()
    {
        $pesanan = Transaksi::with('details.menu')
            ->whereIn('status_koki', ['pending', 'diproses'])
            ->orderBy('created_at', 'asc')
            ->get();

        return view('koki.pesanan.index', compact('pesanan'));
    }

    // Detail pesanan
    public function detail($id)
    {
        $pesanan = Transaksi::with('details.menu')->findOrFail($id);

        return view('koki.pesanan.detail', compact('pesanan'));
    }

    // Update status pesanan
    public function updateStatus($id)
    {
        $trx = Transaksi::findOrFail($id);

        // Status berubah sesuai alur
        if ($trx->status_koki == 'pending') {
            $trx->status_koki = 'diproses';
        } elseif ($trx->status_koki == 'diproses') {
            $trx->status_koki = 'selesai_koki';
        }

        $trx->save();

        return back()->with('success', 'Status pesanan diperbarui!');
    }

    // Riwayat pesanan Koki (selesai)
    public function riwayat()
    {
        $riwayat = Transaksi::with('details.menu')
            ->where('status_koki', 'selesai_koki')
            ->orderBy('updated_at', 'desc')
            ->get();

        return view('koki.pesanan.riwayat', compact('riwayat'));
    }
}
