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
        <h1>Proses Service</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Proses Service</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">
            <div class="mb-4">
                <a href="{{ route('dashboard.pekerja.list-perbaikan-dalam-proses') }}" class="btn btn-outline-secondary"
                    data-bs-toggle="tooltip" data-bs-placement="right" title="Kembali">
                    <i class="ri-arrow-go-back-line"></i>
                </a>
            </div>
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <h5 class="card-title flex-grow-1">Data Service</h5>
                            <button type="button" class="btn btn-outline-primary" style="height: 38px"
                                data-bs-toggle="modal" data-bs-target="#dataKendaraan">
                                <i class="ri-car-line"></i>
                            </button>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-12 d-flex justify-content-center">
                                @if ($perbaikan->foto)
                                    <img src="{{ asset('storage/' . $perbaikan->foto) }}" class="img-fluid rounded"
                                        alt="">
                                @else
                                    <img src="{{ asset('assets/dashboard/img/repair.png') }}" alt="Default"
                                        class="col-md-6 img-fluid">
                                @endif
                            </div>
                            <div class="col-md-12">
                                <table class="table table-borderless">
                                    <tr>
                                        <th>Kode</th>
                                        <td>
                                            <span class="badge bg-secondary" style="font-size: 1rem;">
                                                {{ $perbaikan->kode_unik ?? '' }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Nama Service</th>
                                        <td>{{ $perbaikan->nama ?? '' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Keterangan</th>
                                        <td>{{ $perbaikan->keterangan ?? '' }}</td>
                                    </tr>
                                    <tr>
                                        @php
                                            if ($perbaikan->durasi) {
                                                $durations = explode(' to ', $perbaikan->durasi);
                                                $startDate = \Carbon\Carbon::createFromFormat('d-m-Y', $durations[0]);
                                                $endDate = \Carbon\Carbon::createFromFormat('d-m-Y', $durations[1]);

                                                $days = $startDate->diffInDays($endDate);
                                            }
                                        @endphp
                                        <th>Durasi</th>
                                        <td>
                                            @if ($perbaikan->durasi)
                                                {{ $days ?? '-' }} Hari <br> {{ $perbaikan->durasi ?? '-' }}
                                            @else
                                                {{ $perbaikan->durasi ?? '-' }}
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Masuk</th>
                                        <td>{{ $perbaikan->created_at ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Selesai</th>
                                        <td>{{ $perbaikan->tgl_selesai ?? '-' }}</td>
                                    </tr>
                                    <tr>
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
                                        <th>Status</th>
                                        <td><span class="badge {{ $badge_bg }}"
                                                style="font-size: 1rem;">{{ $perbaikan->status ?? '-' }}</span>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- End Data Perbaikan-->

            <!-- Modal Data Kendaraan -->
            <div class="modal fade" id="dataKendaraan" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title" id="exampleModalLabel">Data Kendaraan</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row justify-content-center">
                                <div class="col-sm-6">
                                    @if ($perbaikan->kendaraan->foto)
                                        <img src="{{ asset('storage/' . $perbaikan->kendaraan->foto) }}"
                                            class="img-fluid rounded" alt="">
                                    @else
                                        <img src="{{ asset('assets/dashboard/img/hatchback.png') }}" alt="Default"
                                            class="img-fluid">
                                    @endif
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-sm-12">
                                    <table class="table table-borderless">
                                        <tr>
                                            <th>No Plat</th>
                                            <td>{{ $perbaikan->kendaraan->no_plat ?? '' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Tipe</th>
                                            <td>{{ $perbaikan->kendaraan->tipe->nama_tipe ?? '' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Merek</th>
                                            <td>{{ $perbaikan->kendaraan->merek->nama_merek ?? '' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Terdaftar Sejak</th>
                                            <td>{{ $perbaikan->kendaraan->created_at ?? '' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Pemilik</th>
                                            <td>{{ $perbaikan->kendaraan->pelanggan->nama ?? '' }}</td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td>{{ $perbaikan->kendaraan->pelanggan->no_telp ?? '' }}</td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td>{{ $perbaikan->kendaraan->pelanggan->alamat ?? '' }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Insert Progres -->
            <div class="modal fade" id="insertProgres" tabindex="-1" data-bs-backdrop="static"
                aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title" id="exampleModalLabel">Tambahkan Progres Service</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" enctype="multipart/form-data" id="progressForm">
                                <input type="hidden" name="perbaikan_id" value="{{ $perbaikan->id }}">
                                <input type="hidden" name="pekerja_id" value="{{ Auth::user()->pekerja->id }}">

                                <div class="mb-3">
                                    <label for="foto" class="col-form-label">Foto</label>
                                    <input required type="file" class="form-control" id="foto" name="foto"
                                        accept=".jpg,.png" required onchange="previewFoto()">

                                </div>
                                <div class="mb-3 d-none" id="container-preview">
                                    <center>
                                        <img class="preview-foto img-fluid rounded">
                                    </center>
                                </div>
                                <div class="mb-3">
                                    <label for="keterangan" name="keterangan" class="col-form-label">Keterangan</label>
                                    <textarea class="form-control" id="keterangan" name="keterangan" rows="4"></textarea>
                                </div>
                                <div class="mb-3 form-check">
                                    <input type="checkbox" class="form-check-input" id="selesaiCheckbox"
                                        name="is_selesai">
                                    <label class="form-check-label" for="selesaiCheckbox">Nyatakan sudah
                                        selesai</label>
                                </div>
                                <button type="button" class="btn btn-primary w-100" id="submitProgressForm">
                                    <i class="bi bi-save me-1"></i> Submit
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            @forelse ($perbaikan->progres->sortByDesc('created_at') as $progres)
                <!-- Modal Edit Progres {{ $progres->id }} -->
                <div class="modal fade" id="editProgres{{ $progres->id }}" tabindex="-1"
                    aria-labelledby="editProgresLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header bg-primary text-white">
                                <h5 class="modal-title" id="editProgresLabel">Edit Progres</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('dashboard.pekerja.update-proses-perbaikan', $progres) }}"
                                    method="POST" enctype="multipart/form-data"
                                    id="editProgresForm{{ $progres->id }}">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="perbaikan_id" value="{{ $perbaikan->id }}">
                                    <input type="hidden" name="pekerja_id" value="{{ Auth::user()->pekerja->id }}">

                                    <div class="mb-3">
                                        <label for="foto" class="col-form-label">Foto</label>
                                        <input type="file" class="form-control" id="foto{{ $progres->id }}"
                                            name="foto" accept=".jpg,.png"
                                            onchange="previewFoto{{ $progres->id }}()">
                                        <small id="fotoHelp{{ $progres->id }}" class="form-text text-danger"></small>
                                    </div>
                                    <div class="mb-3">
                                        <center>
                                            @if ($progres->foto)
                                                <img src="{{ asset('storage/' . $progres->foto) }}"
                                                    class="preview-foto{{ $progres->id }} img-fluid rounded"
                                                    alt="">
                                            @else
                                                <img class="preview-foto{{ $progres->id }} img-fluid rounded">
                                            @endif
                                        </center>
                                    </div>
                                    <div class="mb-3">
                                        <label for="keterangan" class="col-form-label">Keterangan</label>
                                        <textarea class="form-control" id="keterangan" name="keterangan" rows="4">{{ $progres->keterangan }}</textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary w-100"
                                        id="editProgresButton{{ $progres->id }}">
                                        <i class="bi bi-save me-1"></i> Submit
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
            @endforelse

            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Progres Service</h5>
                        <div class="activity">
                            @if ($latest_progres['is_selesai'] != true)
                                <div class="row">
                                    <div class="col-md-12">
                                        <button type="button" class="btn btn-outline-primary w-100"
                                            data-bs-toggle="modal" data-bs-target="#insertProgres">
                                            <i class="ri-add-line"></i>
                                        </button>
                                    </div>
                                </div>
                            @endif
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    @forelse ($perbaikan->progres->sortByDesc('id') as $key => $progres)
                                        @php
                                            $date = \Carbon\Carbon::parse($progres->created_at)->locale('id');
                                            $formattedDate = $date->format('d-m-Y');
                                            $formattedTime = $date->format('H:i');
                                            $diffForHumans = $date->diffForHumans();
                                        @endphp
                                        <div class="activity-item d-flex">
                                            <div class="activite-label" style="width: 150px">
                                                {{ $diffForHumans ?? '-' }} <br>
                                                {{ $formattedDate . ' ' . $formattedTime ?? '-' }} <br>
                                                @php

                                                    if ($progres->pekerja_id == auth()->user()->pekerja->id) {
                                                        echo 'oleh : Saya';
                                                    } elseif ($progres->pekerja) {
                                                        echo 'oleh : ' . $progres->pekerja->nama ?? '-';
                                                    } else {
                                                        echo 'oleh : -';
                                                    }
                                                @endphp
                                            </div>
                                            <i
                                                class='bi bi-circle-fill activity-badge {{ $progres->is_selesai == 1 ? 'text-success' : 'text-warning' }} align-self-start'></i>
                                            <div class="activity-content">
                                                {{ $progres->keterangan ?? '-' }}
                                                <div class="col-md-4 mt-2">
                                                    @if ($progres->foto)
                                                        <a href="javascript:void(0)">
                                                            <img src="{{ asset('storage/' . $progres->foto) }}"
                                                                class="img-fluid rounded" alt=""
                                                                onclick="openImage('{{ asset('storage/' . $progres->foto) }}')">
                                                        </a>
                                                    @endif
                                                </div>
                                                @if (!in_array($key, [0, 1]))
                                                    <div class="col-md-4 mt-2">
                                                        @if ($latest_progres['is_selesai'] != true || $latest_progres['id'] == $progres->id)
                                                            <button type="button" class="btn btn-outline-primary"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#editProgres{{ $progres->id }}"
                                                                style="height: 40px;"><i class="ri-pencil-line"></i>
                                                            </button>
                                                        @endif
                                                    </div>
                                                @endif
                                            </div>

                                        </div><!-- End Progres item-->
                                    @empty
                                        <div class="text-center">
                                            <h5>Tidak ada progres</h5>
                                            <img src="{{ asset('assets/dashboard/img/hang-around.png') }}"
                                                class="img-fluid rounded" alt="">
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- End Progres -->
        </div>
    </section>
@endsection

@section('js')
    <script>
        function openImage(imageUrl) {
            Swal.fire({
                imageUrl: imageUrl,
                imageWidth: 450,
                imageAlt: 'Foto Progres',
                showConfirmButton: false,
            });
        }

        function previewFoto() {
            const image = document.querySelector('#foto');
            const imageContainer = document.querySelector('#container-preview');
            const imgPreview = document.querySelector('.preview-foto');

            imageContainer.classList.remove('d-none');
            imgPreview.style.display = 'block';

            const oFReader = new FileReader();
            oFReader.readAsDataURL(image.files[0]);

            oFReader.onload = function(oFREvent) {
                imgPreview.src = oFREvent.target.result;
            }
        }
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const selesaiCheckbox = document.getElementById('selesaiCheckbox');

            selesaiCheckbox.addEventListener('change', function() {
                if (selesaiCheckbox.checked) {
                    Swal.fire({
                        title: 'Apakah Anda yakin ingin menyatakan sudah selesai ?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Ya',
                        cancelButtonText: 'Tidak',
                    }).then((result) => {
                        if (!result.isConfirmed) {
                            selesaiCheckbox.checked = false;
                        }
                    });
                }
            });
        });

        $(document).ready(function() {
            $('#submitProgressForm').on('click', function(e) {
                e.preventDefault();

                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: 'Anda akan mengirimkan formulir ini',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya , kirim !',
                    cancelButtonText: 'Batal !',
                }).then((result) => {
                    if (result.isConfirmed) {
                        showLoadingModal();
                        submitFormInsertProgres();
                    }
                });
            });

            function showLoadingModal() {
                Swal.fire({
                    title: 'Loading',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    allowEnterKey: false,
                    showConfirmButton: false,
                    willOpen: () => {
                        Swal.showLoading();
                    }
                });
            }

            function submitFormInsertProgres() {
                var formData = new FormData($('#progressForm')[0]);
                var csrfToken = '{{ csrf_token() }}';

                formData.append('_token', csrfToken);

                $.ajax({
                    type: 'POST',
                    url: "{{ route('dashboard.pekerja.store-proses-perbaikan') }}",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        Swal.close(); // Close loading modal
                        if (response.status === 'success-insert-new-progress') {
                            location.reload();
                        } else if (response.status === 'success-update-to-selesai') {
                            window.location.href = "{{ route('dashboard') }}";
                        } else if (response.status === 'error_validation') {
                            $.each(response.errors, function(key, value) {
                                $('#' + key).after(
                                    '<div class="error-message text-danger">' +
                                    value[0] + '</div>');
                            });
                        } else {
                            Swal.fire({
                                title: 'Error',
                                text: 'Error occurred while inserting progress: ' + response
                                    .message,
                                icon: 'error',
                                confirmButtonText: 'OK',
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        Swal.close(); // Close loading modal
                        Swal.fire({
                            title: 'Error',
                            text: 'Error occurred while inserting progress: ' + error,
                            icon: 'error',
                            confirmButtonText: 'OK',
                        });
                    }
                });
            }
        });
    </script>

    @forelse ($perbaikan->progres->sortByDesc('created_at') as $progres)
        @if ($latest_progres['id'] == $progres->id)
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const selesaiCheckbox{{ $progres->id }} = document.getElementById(
                        'selesaiCheckbox{{ $progres->id }}');

                    selesaiCheckbox{{ $progres->id }}.addEventListener('change', function() {
                        if (selesaiCheckbox{{ $progres->id }}.checked) {
                            Swal.fire({
                                title: 'Apakah Anda yakin ingin menyatakan sudah selesai ?',
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonText: 'Ya',
                                cancelButtonText: 'Tidak',
                            }).then((result) => {
                                if (!result.isConfirmed) {
                                    selesaiCheckbox{{ $progres->id }}.checked = false;
                                }
                            });
                        }
                    });
                });
            </script>
        @endif
        <script>
            function previewFoto{{ $progres->id }}() {
                const fileInput{{ $progres->id }} = document.getElementById('foto{{ $progres->id }}');
                const fileSize{{ $progres->id }} = fileInput{{ $progres->id }}.files[0].size;
                const fileTypes{{ $progres->id }} = ['image/jpeg', 'image/png'];

                // Check file type
                if (!fileTypes{{ $progres->id }}.includes(fileInput{{ $progres->id }}.files[0].type)) {
                    document.getElementById('fotoHelp{{ $progres->id }}').textContent =
                        'File harus berupa gambar JPG atau PNG.';
                    fileInput{{ $progres->id }}.value = '';
                    return;
                }

                // Check file size
                const maxSize{{ $progres->id }} = 5 * 1024 * 1024;
                if (fileSize{{ $progres->id }} > maxSize{{ $progres->id }}) {
                    document.getElementById('fotoHelp{{ $progres->id }}').textContent =
                        'Ukuran file tidak boleh melebihi 5MB.';
                    fileInput{{ $progres->id }}.value = '';
                    return;
                }

                document.getElementById('fotoHelp{{ $progres->id }}').textContent = '';

                const image{{ $progres->id }} = document.querySelector('#foto{{ $progres->id }}');
                const imgPreview{{ $progres->id }} = document.querySelector('.preview-foto{{ $progres->id }}');

                imgPreview{{ $progres->id }}.style.display = 'block';

                const oFReader{{ $progres->id }} = new FileReader();
                oFReader{{ $progres->id }}.readAsDataURL(image{{ $progres->id }}.files[0]);

                oFReader{{ $progres->id }}.onload = function(oFREvent) {
                    imgPreview{{ $progres->id }}.src = oFREvent.target.result;
                }
            }
        </script>
    @empty
    @endforelse
@endsection
