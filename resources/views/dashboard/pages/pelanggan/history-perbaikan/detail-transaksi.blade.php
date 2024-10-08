@extends('dashboard.layouts.main')

@section('css')
@endsection
@section('content')
    <div class="pagetitle">
        <h1>Lihat Transaksi</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">
                    <a href="{{ route('dashboard.pelanggan.history-perbaikan', auth()->user()->pelanggan->id) }}">Riwayat
                        Service
                    </a>
                </li>
                <li class="breadcrumb-item active">
                    <a href="{{ route('dashboard.pelanggan.history-perbaikan-detail', $transaksi->perbaikan->id) }}">Lihat
                        Service
                    </a>
                </li>
                <li class="breadcrumb-item active">Lihat Transaksi</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="mb-4">
                <a href="{{ route('dashboard.pelanggan.history-perbaikan-detail', $transaksi->perbaikan->id) }}"
                    class="btn btn-outline-secondary" data-bs-toggle="tooltip" data-bs-placement="right" title="Kembali">
                    <i class="ri-arrow-go-back-line"></i>
                </a>
            </div>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="panel-body mt-4">
                            <div class="clearfix">
                                <div class="float-start">
                                    @php
                                        $profil_bengkel = \App\Models\Settings::first();
                                    @endphp
                                    <h3>{{ $profil_bengkel->master_nama ?? '' }}</h3>
                                </div>
                                <div class="float-end">
                                    <h4>Invoice # <br>
                                        <strong>{{ $transaksi->order_id }}</strong>
                                    </h4>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="float-start mt-3">
                                        <address>
                                            <strong>{{ $profil_bengkel->master_nama ?? '' }}</strong><br>
                                            {{ $profil_bengkel->alamat ?? '' }}<br>
                                            <abbr title="Phone">P:</abbr> {{ $profil_bengkel->telepon ?? '' }}
                                        </address>
                                    </div>
                                    <div class="float-end mt-3">
                                        <table class="table table-borderless">
                                            <tr>
                                                <th>Order Date</th>
                                                <td>: {{ \Carbon\Carbon::parse($transaksi->created_at)->format('d-m-Y') }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Order Status</th>
                                                <td>: {{ $transaksi->transaction_status ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Metode Pembayaran</th>
                                                <td>: {{ $transaksi->pay_by ?? '-' }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-4 ">
                                    <table class="table table-borderless" style="width: 100%">
                                        <tr>
                                            <th>Nama</th>
                                            <td>: {{ $transaksi->pelanggan->nama ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th>No Telp</th>
                                            <td>: {{ $transaksi->pelanggan->no_telp ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Email</th>
                                            <td>: {{ $transaksi->email ?? '-' }}</td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-4 ">
                                    <table class="table table-borderless" style="width: 100%">
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
                                    <table class="table table-borderless" style="width: 100%">
                                        <tr>
                                            <th>Nama Service</th>
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
                                            <td>: Rp. {{ number_format($transaksi->gross_amount, 2) ?? '-' }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <hr>
                            <div class="row justify-content-end">
                                <div class="col-md-6" style="font-size: 12px">
                                    <div class="clearfix mt-4">
                                        <h5 class="small text-dark fw-normal">SYARAT DAN KETENTUAN PEMBAYARAN</h5>

                                        <small>
                                            Pembayaran harus dilakukan sesuai dengan waktu yang ditentukan.
                                            Pembayaran dapat dilakukan menggunakan kartu kredit, transfer bank,
                                            atau metode pembayaran lainnya yang didukung. Jika pembayaran tidak tepat
                                            waktu, maka transaksi harus dilakukan ulang.
                                        </small>
                                    </div>
                                </div>
                                <div class="col-md-6" style="text-align: right">
                                    <h2>Total</h2>
                                    <h4><strong>Rp. {{ number_format($transaksi->gross_amount, 2) ?? '-' }}</strong></h4>
                                </div>
                            </div>
                            <hr>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('js')
@endsection
