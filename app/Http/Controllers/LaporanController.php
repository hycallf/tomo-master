<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use App\Models\Perbaikan;
use App\Models\Transaksi;
use Carbon\Carbon;

class LaporanController extends Controller
{
    public function pelanggan()
    {
        $pageTitle = 'Laporan Pelanggan';

        $pelanggans = Pelanggan::with('kendaraans', 'user')
            ->orderBy('created_at', 'desc')
            ->get();

        $totalPelanggans = $pelanggans->count();
        $totalKendaraans = $pelanggans->sum(function ($pelanggan) {
            return $pelanggan->kendaraans->count();
        });

        return view('dashboard.pages.admin.laporan.pelanggan.index', compact('pageTitle', 'pelanggans', 'totalKendaraans', 'totalPelanggans'));
    }

    public function perbaikan()
    {
        $pageTitle = 'Laporan Perbaikan Kendaraan';
        $status = request()->get('status');

        $perbaikans = Perbaikan::with('kendaraan', 'transaksi', 'kendaraan.pelanggan')
            ->when($status != null, function ($query) use ($status) {
                return $query->where('status', $status);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        $totalPerbaikans = $perbaikans->count();

        $average_done_in_days = null;

        $totalDuration = $perbaikans->filter(function ($perbaikan) {
            return $perbaikan->status == 'Selesai' && $perbaikan->tgl_selesai;
        })->sum(function ($perbaikan) {
            return Carbon::parse($perbaikan->created_at)->diffInDays(Carbon::parse($perbaikan->tgl_selesai));
        });

        $completedPerbaikans = $perbaikans->filter(function ($perbaikan) {
            return $perbaikan->status == 'Selesai' && $perbaikan->tgl_selesai;
        })->count();

        if ($completedPerbaikans > 0) {
            $average_done_in_days = $totalDuration / $completedPerbaikans;
        }

        $statuses = ['Baru', 'Antrian', 'Dalam Proses', 'Proses Selesai', 'Menunggu Bayar', 'Selesai'];
        $statusCounts = [];

        foreach ($statuses as $statusName) {
            $statusCounts[$statusName] = Perbaikan::where('status', $statusName)
                ->count();
        }

        if ($status != null) {
            $statusCounts = [
                $status => $perbaikans->count()
            ];
        }

        return view('dashboard.pages.admin.laporan.perbaikan.index', compact('pageTitle', 'perbaikans', 'totalPerbaikans', 'average_done_in_days', 'statusCounts'));
    }

    public function transaksi()
    {
        $pageTitle = 'Laporan Transaksi';
        $status = request()->get('status');
        $pelanggan = request()->get('pelanggan');

        $transaksis = Transaksi::with('perbaikan', 'perbaikan.kendaraan', 'perbaikan.kendaraan.pelanggan')
            ->when($status, function ($query) use ($status) {
                return $query->where('transaction_status', $status);
            })
            ->when($pelanggan, function ($query) use ($pelanggan) {
                return $query->where('pelanggan_id', $pelanggan);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        $totalIncome = $transaksis->filter(function ($transaksi) {
            return $transaksi->transaction_status == 'settlement';
        })->sum('gross_amount');

        $potentialIncome = $transaksis->filter(function ($transaksi) {
            return $transaksi->transaction_status != 'settlement';
        })->sum('gross_amount');

        $pelanggans = Pelanggan::with('kendaraans', 'user')->get();

        return view('dashboard.pages.admin.laporan.transaksi.index', compact('pageTitle', 'transaksis', 'totalIncome', 'potentialIncome', 'pelanggans'));
    }

}
