<?php

namespace App\Http\Controllers;

use App\Http\Services\WablasNotification;
use App\Mail\RegisteredPerbaikanMail;
use App\Models\Kendaraan;
use App\Models\Perbaikan;
use App\Models\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Str;

class PerbaikanController extends Controller
{
    public function index()
    {
        
    }
    public function create()
    {
        $pageTitle = 'Tambah Perbaikan';

        $kendaraan = Kendaraan::find(request('idKendaraan'));

        if (!$kendaraan) {
            Alert::error('Error', 'Kendaraan tidak ditemukan');
            return redirect()->back();
        }

        return view('dashboard.pages.admin.perbaikan.create', compact('pageTitle', 'kendaraan'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $settings = Settings::first();
        $kendaraan = Kendaraan::find($request->idKendaraan);

        if (!$kendaraan) {
            Alert::error('Error', 'Kendaraan tidak ditemukan');
            return redirect()->back();
        }

        $validate = $request->validate(
            [
                'nama' => ['required', 'string'],
                'keterangan' => ['required', 'string'],
                'foto' => ['nullable', 'image', 'file', 'mimes:jpeg,png,jpg,gif,svg', 'max:5000'],
            ],
            [
                'nama.required' => 'Nama tidak boleh kosong',
                'keterangan.required' => 'Keterangan tidak boleh kosong',
                'foto.required' => 'Foto tidak boleh kosong',
                'foto.max' => 'Ukuran gambar terlalu besar',
                'foto.mimes' => 'Format gambar tidak valid',
            ]
        );

        $foto = null;

        if ($request->hasFile('foto')) {
            $foto = $validate['foto']->store('foto');
        }

        $randomString = Str::random(4);
        $randomNumber = rand(1000, 9999);
        $kodeUnik = $randomString . '-' . $randomNumber;

        $perbaikan = Perbaikan::create([
            'kode_unik' => $kodeUnik,
            'kendaraan_id' => $request->idKendaraan,
            'nama' => $request->nama,
            'keterangan' => $request->keterangan,
            'foto' => $foto,
            'status' => $request->status,
        ]);

        try {
            $email = $kendaraan->pelanggan->user->email;

            Mail::to($email)->send(new RegisteredPerbaikanMail($perbaikan));

            Log::channel('mail')->info('Email berhasil dikirim ', ['email' => $email]);
        } catch (\Exception $e) {
            Log::channel('mail')->error('Gagal mengirim email: ', ['error' => $e->getMessage()]);
        }

        try {
            $phone = $perbaikan->kendaraan->pelanggan->no_telp;
            $merek = $perbaikan->kendaraan->merek->nama_merek;
            $tipe = $perbaikan->kendaraan->tipe->nama_tipe;
            $noPlat = $perbaikan->kendaraan->no_plat;

            $namaPerbaikan = $perbaikan->nama;
            $keteranganPerbaikan = $perbaikan->keterangan;
            $statusPerbaikan = $perbaikan->status;
            $tanggalPerbaikan = $perbaikan->created_at;

            $message = "Halo, " . $perbaikan->kendaraan->pelanggan->nama . "!\n\n" .
                "Kendaraan Anda dengan detail berikut:\n\n" .
                "*Merek:* " . $merek . "\n" .
                "*Tipe:* " . $tipe . "\n" .
                "*Nomor Plat:* " . $noPlat . "\n\n" .
                "Perbaikan terbaru:\n\n" .
                "*Nama Perbaikan:* " . $namaPerbaikan . "\n" .
                "*Keterangan:* " . $keteranganPerbaikan . "\n" .
                "*Status:* " . $statusPerbaikan . "\n" .
                "*Tanggal:* " . $tanggalPerbaikan . "\n\n" .
                "Sistem Kami melakukan reminder service kepada anda H-7 .\n" .
                "Abaikan Pesan Ini Jika Sudah melakukan Service .\n" .
                "Terima kasih telah mempercayakan layanan kami.\n\n" .
                "Salam,\n" .
                "-Tim {$settings->master_nama}";

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
        } catch (\Exception $e) {
            Log::channel('wablas')->error('Gagal mengirim notifikasi: ', ['error' => $e->getMessage()]);
        }

        Alert::toast('<p style="color: white; margin-top: 15px;">' . $perbaikan->nama . ' berhasil ditambahkan!</p>', 'success')
            ->toHtml()
            ->background('#201658');

        return redirect()->route('kendaraan.show', $request->idKendaraan);
    }

    public function show(Perbaikan $perbaikan)
    {
        $pageTitle = 'Detail Perbaikan';

        $perbaikan->load('kendaraan');
        $perbaikan->load('progres');

        return view('dashboard.pages.admin.perbaikan.show', compact(
            'pageTitle',
            'perbaikan'
        ));
    }

    public function edit(Perbaikan $perbaikan)
    {
        $pageTitle = 'Edit Perbaikan';
        $perbaikan->load('kendaraan');

        return view('dashboard.pages.admin.perbaikan.edit', compact(
            'pageTitle',
            'perbaikan'
        ));
    }

    public function update(Request $request, Perbaikan $perbaikan)
    {
        $validate = $request->validate(
            [
                'nama' => ['required', 'string'],
                'keterangan' => ['required', 'string'],
                'foto' => ['nullable', 'image', 'file', 'mimes:jpeg,png,jpg,gif,svg', 'max:5000'],
            ],
            [
                'nama.required' => 'Nama tidak boleh kosong',
                'keterangan.required' => 'Keterangan tidak boleh kosong',
                'tgl_selesai.date' => 'Format Tgl. Selesai tidak valid',
                'foto.max' => 'Ukuran gambar terlalu besar',
                'foto.mimes' => 'Format gambar tidak valid',
            ]
        );

        $perbaikan->update([
            'nama' => $validate['nama'],
            'keterangan' => $validate['keterangan'],
        ]);

        if ($request->hasFile('foto')) {
            if ($perbaikan->foto) {
                // Delete old photo
                Storage::delete($perbaikan->foto);
            }

            // Store new photo
            $fotoPath = $request->file('foto')->store('foto');
            $perbaikan->update(['foto' => $fotoPath]);
        }


        Alert::toast('<p style="color: white; margin-top: 10px;">' . $perbaikan->nama . ' berhasil diubah!</p>', 'success')
            ->toHtml()
            ->background('#333A73');

        return redirect()->route('kendaraan.show', $perbaikan->kendaraan_id);
    }

    public function destroy(Perbaikan $perbaikan)
    {
        if ($perbaikan->foto) {
            Storage::delete($perbaikan->foto);
        }

        $perbaikan->delete();

        Alert::toast('<p style="color: white; margin-top: 10px;">' . $perbaikan->nama . ' berhasil dihapus!</p>', 'success')
            ->toHtml()
            ->background('#333A73');

        return redirect()->route('kendaraan.show', $perbaikan->kendaraan_id);
    }
}
