<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $hariIni = Transaksi::whereDate('created_at', now())->sum('total_harga');

        $bulanIni = Transaksi::whereMonth('created_at', now()->month)
            ->sum('total_harga');

        $totalTransaksi = Transaksi::count();

        return view('dashboard.kasir', compact('hariIni', 'bulanIni', 'totalTransaksi'));
    }
}
