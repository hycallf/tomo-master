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
        <h1>Service Baru</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Service Baru</li>
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
                        <h5 class="card-title">Data Service Baru</h5>

                        <div class="row">
                            <div class="col-md-12">
                                <table id="datatable" class="table table-bordered " style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Kode Service</th>
                                            <th>Nama Service</th>
                                            <th>Tgl Masuk</th>
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
                                                <td nowrap>
                                                    <button class="btn btn-{{ $btn_color }} text-white w-100 btn-sm"
                                                        onclick="confirmProses('{{ $perbaikan->id }}')">
                                                        <i class="ri-tools-line me-1"></i>Proses
                                                    </button>
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

        function confirmProses(perbaikanId) {
            Swal.fire({
                title: 'Apakah Anda yakin ingin memproses Service ini?',
                text: 'Service ini akan diupdate statusnya menjadi Antrian',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Proses!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "{{ route('dashboard.pekerja.proses-perbaikan-baru', '') }}" + '/' +
                        perbaikanId;
                }
            });
        }
    </script>

    <script>
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