@extends('dashboard.layouts.main')

@section('content')
    <div class="pagetitle">
        <h1>Dashboard</h1>
    </div><!-- End Page Title -->
    <hr>
    <section class="section dashboard">
        @if (auth()->user()->pelanggan->no_telp == null ||
                auth()->user()->pelanggan->alamat == null ||
                auth()->user()->pelanggan->jenis_k == null)
            @include('dashboard.pages.pelanggan.components.complete_profil_form')
        @else
            <div class="row">
                <div class="col-xxl-4 col-md-4">
                    <div class="card info-card sales-card">
                        <div class="card-body">
                            <h5 class="card-title">Service Saat Ini</h5>
                            <a href="{{ route('dashboard.pelanggan.current-perbaikan', auth()->user()->pelanggan->id) }}">
                                <div class="d-flex align-items-center">
                                    <div
                                        class="card-icon {{ $perbaikanInProgressCount != 0 ? 'bg-warning text-white' : '' }} rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bx bxs-car-crash"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>{{ $perbaikanInProgressCount }}</h6>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div><!-- End Riwayat Perbaikan Card -->

                <div class="col-xxl-4 col-md-4">
                    <div class="card info-card sales-card">
                        <div class="card-body">
                            <h5 class="card-title">Riwayat Service</h5>
                            <a href="{{ route('dashboard.pelanggan.history-perbaikan', auth()->user()->pelanggan->id) }}">
                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-journal-bookmark"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>{{ $perbaikanDoneCount }}</h6>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div><!-- End Riwayat Perbaikan Card -->

                <div class="col-xxl-4 col-md-4">
                    <div class="card info-card sales-card">
                        <div class="card-body">
                            <h5 class="card-title">Kendaraan Saya</h5>
                            <a href="{{ route('dashboard.pelanggan.my-kendaraan', auth()->user()->pelanggan->id) }}">
                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bx bxs-car"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>{{ $kendaraanCount }}</h6>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div><!-- End Riwayat Perbaikan Card -->
            </div>
        @endif
    </section>
@endsection

@section('js')
    <script>
        function previewFoto() {
            const image = document.querySelector('#foto');
            const imgPreview = document.querySelector('.preview-foto');

            imgPreview.style.display = 'block';

            const oFReader = new FileReader();
            oFReader.readAsDataURL(image.files[0]);

            oFReader.onload = function(oFREvent) {
                imgPreview.src = oFREvent.target.result;
            }
        }

        function submit() {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data akan disimpan !",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, simpan!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('form').submit()
                }
            });
        }

        function formatNoTelp(value) {
            let formatedValue = value.replace(/[^0-9]/g, '').slice(0, 16);

            return formatedValue;
        }
    </script>
@endsection
