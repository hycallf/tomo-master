@extends('dashboard.layouts.main')

@section('css')
@endsection
@section('content')
    <div class="pagetitle">
        <h1>Lihat Transaksi</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('transaksi.index') }}">Transaksi</a></li>
                <li class="breadcrumb-item active">Show</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="mb-4">
                <a href="{{ route('transaksi.index') }}" class="btn btn-outline-secondary" data-bs-toggle="tooltip"
                    data-bs-placement="right" title="Kembali">
                    <i class="ri-arrow-go-back-line"></i>
                </a>
            </div>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="panel-body mt-4">
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <h3 class="mb-3">{{ $settings->master_nama }}</h3>
                                    <div class="company-details">
                                        <p><i class="bi bi-geo-alt-fill me-2"></i>{{ $settings->alamat }}</p>
                                        <p><i class="bi bi-telephone-fill me-2"></i>{{ $settings->telepon }}</p>
                                        @php
                                            $whatsappNumber = preg_replace(
                                                '/[^0-9]/',
                                                '',
                                                str_replace('wa.me/', '', $settings->whatsapp),
                                            );
                                        @endphp
                                        <p>
                                            <i class="bi bi-whatsapp me-2"></i>
                                            <a href="https://wa.me/{{ $whatsappNumber }}" class="text-decoration-none">
                                                {{ $whatsappNumber }}
                                            </a>
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-6 text-md-end">
                                    <h4 class="mb-3">Invoice #{{ $transaksi->order_id }}</h4>
                                    <table class="table table-borderless text-md-end">
                                        <tr>
                                            <th>Tanggal Order:</th>
                                            <td>{{ \Carbon\Carbon::parse($transaksi->created_at)->format('d-m-Y') }}</td>
                                        </tr>
                                        <tr>
                                            <th>Status Order:</th>
                                            <td>{{ $transaksi->transaction_status ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Metode Pembayaran:</th>
                                            <td>{{ $transaksi->chosen_payment ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Dibayar Oleh:</th>
                                            <td>{{ $transaksi->pay_by ?? '-' }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <hr>
                            <div class="row mt-4">
                                <div class="col-md-4">
                                    <h5 class="mb-3">Data Pelanggan</h5>
                                    <table class="table table-borderless">
                                        <tr>
                                            <th style="width: 35%;">Nama</th>
                                            <td style="width: 5%;">:</td>
                                            <td>{{ $transaksi->pelanggan->nama ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th>No Telp</th>
                                            <td>:</td>
                                            <td>{{ $transaksi->pelanggan->no_telp ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Email</th>
                                            <td>:</td>
                                            <td>
                                                @if ($transaksi->pelanggan->email)
                                                    @php
                                                        $email = $transaksi->pelanggan->email;
                                                        $emailParts = explode('@', $email);
                                                        $username = $emailParts[0];
                                                        $domain = isset($emailParts[1]) ? '@' . $emailParts[1] : '';

                                                        if (strlen($username) > 20) {
                                                            $username = substr($username, 0, 20) . '...';
                                                        }

                                                        $wrappedEmail = $username . '<br>' . $domain;
                                                    @endphp
                                                    {!! $wrappedEmail !!}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-4">
                                    <h5 class="mb-3">Data Kendaraan</h5>
                                    <table class="table table-borderless">
                                        <tr>
                                            <th>No Plat</th>
                                            <td>: {{ $transaksi->perbaikan->kendaraan->no_plat ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Merek</th>
                                            <td>: {{ $transaksi->perbaikan->kendaraan->merek->nama_merek ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Tipe</th>
                                            <td>: {{ $transaksi->perbaikan->kendaraan->tipe->nama_tipe ?? '-' }}</td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-4">
                                    <h5 class="mb-3">Data Perbaikan</h5>
                                    <table class="table table-borderless">
                                        <tr>
                                            <th>Nama Perbaikan</th>
                                            <td>: {{ $transaksi->perbaikan->nama ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Selesai Pada</th>
                                            <td>:
                                                {{ \Carbon\Carbon::parse($transaksi->perbaikan->tgl_selesai)->format('d-m-Y') ?? '-' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Unit Cost</th>
                                            <td>: Rp. {{ number_format($transaksi->gross_amount) ?? '-' }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <hr>
                            <div class="row justify-content-end mt-4">
                                <div class="col-md-6" style="font-size: 12px">
                                    <h5 class="small text-dark fw-normal">SYARAT DAN KETENTUAN PEMBAYARAN</h5>
                                    <p>
                                        Pembayaran harus dilakukan sesuai dengan waktu yang ditentukan.
                                        Pembayaran dapat dilakukan menggunakan kartu kredit, transfer bank,
                                        atau metode pembayaran lainnya yang didukung. Jika pembayaran tidak tepat
                                        waktu, maka transaksi harus dilakukan ulang.
                                    </p>
                                </div>
                                <div class="col-md-6 text-end">
                                    <h2>Total</h2>
                                    <h4><strong>Rp. {{ number_format($transaksi->gross_amount) ?? '-' }}</strong></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('js')
@endsection
