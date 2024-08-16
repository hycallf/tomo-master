<?php

namespace App\Http\Controllers;

use App\Http\Services\WablasNotification;
use App\Models\Perbaikan;
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
        $threeMonthsAgo = $now->copy()->subMonths(3);

        $overduePerbaikans = Perbaikan::with(['kendaraan.pelanggan'])
            ->where('status', 'Selesai')
            ->where('reminder_sent', false)
            ->where('tgl_selesai', '<', $threeMonthsAgo)
            ->orderBy('tgl_selesai', 'asc')
            ->get()
            ->map(function ($perbaikan) use ($now) {
                $perbaikan->durasi = $this->hitungDurasi($perbaikan->tgl_selesai, $now);
                return $perbaikan;
            });

        $regularPerbaikans = Perbaikan::with(['kendaraan.pelanggan'])
            ->where('status', 'Selesai')
            ->where(function ($query) use ($threeMonthsAgo) {
                $query->where('tgl_selesai', '>=', $threeMonthsAgo)
                    ->orWhere('reminder_sent', true);
            })
            ->orderBy('reminder_sent', 'asc')
            ->orderBy('tgl_selesai', 'asc')
            ->get()
            ->map(function ($perbaikan) use ($now) {
                $perbaikan->durasi = $this->hitungDurasi($perbaikan->tgl_selesai, $now);
                return $perbaikan;
            });

        return view('dashboard.pages.admin.reminder.index', compact('overduePerbaikans', 'regularPerbaikans'));
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
        $perbaikan = Perbaikan::findOrFail($id);
        $settings = Settings::first();
        try {
            $phone = $perbaikan->kendaraan->pelanggan->no_telp;
            $merek = $perbaikan->kendaraan->merek->nama_merek;
            $tipe = $perbaikan->kendaraan->tipe->nama_tipe;
            $noPlat = $perbaikan->kendaraan->no_plat;

            $namaPerbaikan = $perbaikan->nama;
            $keteranganPerbaikan = $perbaikan->keterangan;
            $statusPerbaikan = $perbaikan->status;
            $tanggalPerbaikan = Carbon::parse($perbaikan->tgl_selesai)->format('d-m-Y');

            $message = "Yth. Bapak/Ibu " . $perbaikan->kendaraan->pelanggan->nama . "!\n\n" .
            "{$settings->master_nama} mengingatkan bahwa kendaraan Anda dengan detail berikut:\n\n" .
                "*Merek:* " . $merek . "\n" .
                "*Tipe:* " . $tipe . "\n" .
                "*Nomor Plat:* " . $noPlat . "\n\n" . 
                "Terakhir kali Anda melakukan service di toko kami pada tanggal " . $tanggalPerbaikan . ", dan sudah memasuki waktu servis rutin di setiap 3 bulannya. Pastikan untuk menjadwalkan perawatan kendaraan kesayangan Anda di bengkel kami agar performa perjalanan Anda selalu nyaman dan aman.\n\n" . 
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
            Alert::toast('<p style="color: white; margin-top: 15px;">' . $perbaikan->nama . ' Reminder berhasil dikirim ke WhatsApp!</p>', 'success')
            ->toHtml()
            ->background('#201658');

            $perbaikan->update([
                'reminder_sent' => true,
                'reminder_sent_at' => now(),
            ]);

            return redirect()->route('reminder.index')->with('success', 'Reminder berhasil dikirim');

        } catch (\Exception $e) {
            Log::channel('wablas')->error('Gagal mengirim notifikasi: ', ['error' => $e->getMessage()]);
        }
        
    }

}
