@extends('dashboard.layouts.main')

@section('css')
    <style>
        .btn-show-pemilik {
            cursor: pointer;
            border: none;
            background-color: transparent;
        }

        .btn-show-pemilik:hover {
            color: #007bff;
        }
    </style>
@endsection
@section('content')
    <div class="pagetitle">
        <h1>Perbaikan menunggu bayar</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Perbaikan menunggu bayar</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">
            <div class="mb-4">
                <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary" data-bs-toggle="tooltip"
                    data-bs-placement="right" title="Kembali">
                    <i class="ri-arrow-go-back-line"></i>
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Data perbaikan menunggu bayar</h5>

                        <div class="row">
                            <div class="col-md-12">
                                <table id="datatable" class="table table-bordered " style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Kode Perbaikan</th>
                                            <th>Nama Perbaikan</th>
                                            <th>Tgl Masuk</th>
                                            <th>Metode Bayar</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($perbaikans->sortByDesc('created_at') as $perbaikan)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $perbaikan->kode_unik }}</td>
                                                <td>{{ $perbaikan->nama }}</td>
                                                <td>{{ $perbaikan->created_at ?? '-' }}</td>
                                                <td>{{ $perbaikan->transaksi->chosen_payment ?? '-' }}</td>
                                                <td>
                                                    @php
                                                        $badge_bg = null;
                                                        $btn_color = null;

                                                        switch ($perbaikan->status) {
                                                            case 'Selesai':
                                                                $badge_bg = 'bg-success';
                                                                $btn_color = 'success';
                                                                break;
                                                            case 'Baru':
                                                                $badge_bg = 'bg-info';
                                                                $btn_color = 'info';
                                                                break;
                                                            case 'Antrian':
                                                                $badge_bg = 'bg-primary';
                                                                $btn_color = 'primary';
                                                                break;
                                                            case 'Dalam Proses':
                                                                $badge_bg = 'bg-secondary';
                                                                $btn_color = 'secondary';
                                                                break;
                                                            case 'Menunggu Bayar':
                                                                $badge_bg = 'bg-warning';
                                                                $btn_color = 'warning';
                                                                break;
                                                            default:
                                                                $badge_bg = 'bg-dark';
                                                                $btn_color = 'dark';
                                                                break;
                                                        }
                                                    @endphp
                                                    <span class="badge {{ $badge_bg }} w-100">
                                                        {{ $perbaikan->status ?? '-' }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <a class="btn btn-{{ $btn_color }} text-white btn-sm"
                                                        data-bs-toggle="tooltip" data-bs-placement="top" title="Proses"
                                                        href="{{ route('dashboard.admin.proses-menunggu-bayar', $perbaikan->id) }}">
                                                        <i class="ri-tools-line me-1"></i>Proses
                                                    </a>
                                                    <a class="btn btn-success btn-sm" data-bs-toggle="tooltip"
                                                        data-bs-placement="top" title="Lihat"
                                                        href="{{ route('dashboard.admin.detail-perbaikan-menunggu-bayar', $perbaikan->id) }}">
                                                        <i class="ri-eye-line"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('js')
    <script>
        $(document).ready(function() {
            $('#datatable').DataTable({
                responsive: true,
            });
        })

        function openImage(imageUrl) {
            Swal.fire({
                imageUrl: imageUrl,
                imageWidth: 450,
                imageAlt: 'Foto Progres',
                showConfirmButton: false,
            });
        }
    </script>
@endsection
