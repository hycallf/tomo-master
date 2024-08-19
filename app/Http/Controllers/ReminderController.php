<?php

namespace App\Http\Controllers;

use App\Http\Services\WablasNotification;
use App\Models\Perbaikan;
use App\Models\Kendaraan;
use App\Models\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use RealRashid\SweetAlert\Facades\Alert;
use Carbon\Carbon;

class ReminderController extends Controller
{
    public function index()
    {
        $now = Carbon::now();

        $kendaraans = Kendaraan::with(['pelanggan', 'perbaikans' => function ($query) {
            $query->latest('tgl_selesai');
        }])
        ->get()
        ->map(function ($kendaraan) use ($now) {
            $lastMaintenance = $kendaraan->perbaikans->first();
            if ($lastMaintenance) {
                $lastMaintenanceDate = Carbon::parse($lastMaintenance->tgl_selesai);
                $kendaraan->last_maintenance_date = $lastMaintenanceDate;
                $kendaraan->durasi = $lastMaintenanceDate->diffForHumans($now);
                $kendaraan->is_overdue = ($lastMaintenanceDate->addMonths($kendaraan->maintenance_schedule_months)->isPast() && $kendaraan->reminder_sent == false);

                // Cek apakah sudah lewat 1 minggu sejak pengiriman reminder terakhir
                if ($kendaraan->reminder_sent && $kendaraan->reminder_sent_at) {
                    $lastReminderSent = Carbon::parse($kendaraan->reminder_sent_at);
                    if ($lastReminderSent->addWeek()->isPast()) {
                        $kendaraan->reminder_sent = false;
                        $kendaraan->save();
                    }
                }
                
                $kendaraan->last_reminder_sent = $kendaraan->reminder_sent_at ? Carbon::parse($kendaraan->reminder_sent_at)->diffForHumans() : 'Belum pernah';
            } else {
                $kendaraan->durasi = 'Belum pernah';
                $kendaraan->is_overdue = true;
                $kendaraan->last_reminder_sent = 'Belum pernah';

            } 
            
            return $kendaraan;
        });

        $overdueKendaraans = $kendaraans->filter(function ($kendaraan) {
            return $kendaraan->is_overdue;
        });

        $regularKendaraans = $kendaraans->filter(function ($kendaraan) {
            return !$kendaraan->is_overdue;
        });
            
            
            // ->map(function ($perbaikan) use ($now) {
            //     $perbaikan->durasi = $this->hitungDurasi($perbaikan->tgl_selesai, $now);
            //     return $perbaikan;
            // });

        return view('dashboard.pages.admin.reminder.index', compact('overdueKendaraans', 'regularKendaraans'));
    }

    private function hitungDurasi($tanggalSelesai, $sekarang)
    {
        // Pastikan $tanggalSelesai adalah objek Carbon
        if (!$tanggalSelesai instanceof Carbon) {
            $tanggalSelesai = Carbon::parse($tanggalSelesai);
        }

        $diff = $tanggalSelesai->diff($sekarang);
        $bulan = $diff->y * 12 + $diff->m;
        $hari = $diff->d;
        return "{$bulan} bulan, {$hari} hari";
    }

    public function send($id)
    {
        $kendaraan = Kendaraan::findOrFail($id);
        $settings = Settings::first();
        $lastMaintenance = $kendaraan->perbaikans->first();
        try {
            $phone = $kendaraan->pelanggan->no_telp;
            $nama = $kendaraan->pelanggan->nama;
            $merek = $kendaraan->merek->nama_merek;
            $tipe = $kendaraan->tipe->nama_tipe;
            $noPlat = $kendaraan->no_plat;
            $schedule = $kendaraan->maintenance_schedule_months;

            $namaPerbaikan = $lastMaintenance->nama;
            $keteranganPerbaikan = $lastMaintenance->keterangan;
            $statusPerbaikan = $lastMaintenance->status;
            $tanggalPerbaikan = Carbon::parse($lastMaintenance->tgl_selesai)->format('d-m-Y');

            // Hitung durasi
        $now = Carbon::now();
        $durasi = $this->hitungDurasi($lastMaintenance->tgl_selesai, $now);

            $message = "Yth. Bapak/Ibu " . $nama . "!\n\n" .
            "{$settings->master_nama} mengingatkan bahwa kendaraan Anda dengan detail berikut:\n\n" .
                "*Merek:* " . $merek . "\n" .
                "*Tipe:* " . $tipe . "\n" .
                "*Nomor Plat:* " . $noPlat . "\n\n" . 
                "Anda mendaftarkan kendaraan anda untuk melakukan perawatan rutin bulanan dengan jadwal setiap {$schedule} bulan sekali. Sekarang sudah terlewat {$durasi} sejak terakhir kali Anda selesai melakukan service di toko kami yaitu pada tanggal " . $tanggalPerbaikan . ", untuk melakukan perbaikan {$namaPerbaikan} . Pastikan untuk segera melakukan perawatan kendaraan kesayangan Anda sesuai dengan jadwal yang sudah di tentukan di bengkel kami, kami mengingatkan anda untuk memastikan anda selalu aman dan nyaman dalam berkendara.\nTerima kasih.\n\n" . 
                "Untuk informasi lebih lanjut, silakan hubungi kami:\n" .
                "Telepon: {$settings->telepon}\n" .
                "WhatsApp: {$settings->whatsapp}\n" .
                "Email: {$settings->email}\n\n" .
                "Alamat: {$settings->alamat}\n\n" .
                "Salam,\n-Tim {$settings->master_nama}";

            $wablasNotification = new WablasNotification();

            $wablasNotification->setPhone($phone);
            $wablasNotification->setMessage($message);

            $response = $wablasNotification->sendMessage();

            if ($response['status'] !== 200) {
                Log::channel('wablas')->error('Gagal mengirim notifikasi ', [
                    'status' => $response['status'],
                    'response' => $response['response'],
                ]);
            } else {
                Log::channel('wablas')->info('Notifikasi berhasil dikirim ', [
                    'status' => $response['status'],
                    'response' => $response['response'],
                ]);
            }
            Alert::toast('<p style="color: white; margin-top: 15px;"> Reminder berhasil dikirim ke WhatsApp!</p>', 'success')
            ->toHtml()
            ->background('#201658');

            // Update status pengiriman
            $kendaraan->reminder_sent = true;
            $kendaraan->reminder_sent_at = now();
            $kendaraan->save();

            return redirect()->route('reminder.index')->with('success', 'Reminder berhasil dikirim');

        } catch (\Exception $e) {
            Log::channel('wablas')->error('Gagal mengirim notifikasi: ', ['error' => $e->getMessage()]);
        }
        
    }

    public function sendWhatsAppMessage($phone, $message)
    {
        try {
            $wablasNotification = new WablasNotification();
            $wablasNotification->setPhone($phone);
            $wablasNotification->setMessage($message);

            $response = $wablasNotification->sendMessage();

            if ($response['status'] !== true) {
                throw new \Exception('Gagal mengirim notifikasi WhatsApp');
            }

            return response()->json(['status' => 'success', 'message' => 'Pesan berhasil dikirim ke WhatsApp']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Gagal mengirim pesan: ' . $e->getMessage()], 500);
        }
    }

}
