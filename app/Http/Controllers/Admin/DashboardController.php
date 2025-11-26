<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Transaksi;
use App\Models\User;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistik utama
        $totalMenu = Menu::count();
        $totalKaryawan = User::whereIn('role', ['kasir', 'koki'])->count();

        // Statistik transaksi
        $today = Carbon::today();

        $transaksiHariIni = Transaksi::whereDate('created_at', $today)->count();

        $pendapatanHariIni = Transaksi::whereDate('created_at', $today)
            ->sum('total_harga');

        $transaksiBulanIni = Transaksi::whereMonth('created_at', now()->month)
            ->count();

        return view(
            'dashboard.admin',
            compact(
                'totalMenu',
                'totalKaryawan',
                'transaksiHariIni',
                'pendapatanHariIni',
                'transaksiBulanIni'
            )
        );
    }
    public function laporan(Request $request)
    {
        // Jika ada tanggal dari user pakai untuk filter
        $tanggal = $request->tanggal;

        $query = Transaksi::query();

        if ($tanggal) {
            $query->whereDate('created_at', $tanggal);
        }

        $transaksi = $query->with('details.menu')->latest()->get();

        $totalPendapatan = $query->sum('total_harga');
        $jumlahTransaksi = $query->count();

        return view('admin.laporan.index', compact('transaksi', 'totalPendapatan', 'jumlahTransaksi', 'tanggal'));
    }
    public function cetakLaporan(Request $request)
    {
        $tanggal = $request->tanggal;

        $query = Transaksi::query();

        if ($tanggal) {
            $query->whereDate('created_at', $tanggal);
        }

        $transaksi = $query->get();

        $pdf = PDF::loadView('admin.laporan.pdf', compact('transaksi', 'tanggal'))
            ->setPaper('A4', 'portrait');

        return $pdf->download('Laporan-' . ($tanggal ?? 'semua') . '.pdf');
    }


}
