<!-- resources/views/dashboard/pages/admin/reminder/index.blade.php -->

@extends('dashboard.layouts.main')

@section('content')
    <div class="pagetitle">
        <h1>Reminder Perawatan Rutin</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Reminder</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                @if ($overdueKendaraans->isNotEmpty())
                    <div class="alert alert-danger" role="alert">
                        <h4 class="alert-heading">Peringatan!</h4>
                        <p>Terdapat {{ $overdueKendaraans->count() }} kendaraan yang telah melewati 3 bulan setelah
                            perbaikan dan belum dikirimkan reminder.</p>
                    </div>
                @endif
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Daftar Reminder Perawatan Rutin (Overdue)</h5>
                        <table id="overdueTable" class="table datatable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Pemilik</th>
                                    <th>No Pelanggan</th>
                                    <th>Kendaraan</th>
                                    <th>No Plat</th>
                                    <th>Terakhir Perawatan</th>
                                    <th>Jadwal Perawatan</th>
                                    <th>Status Reminder</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($overdueKendaraans as $kendaraan)
                                    <tr class="table-danger">
                                        @include('dashboard.pages.admin.reminder._kendaraan_row')
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card mt-4">
                    <div class="card-body">
                        <h5 class="card-title">Daftar Reminder Perawatan Rutin (Regular)</h5>
                        <table id="regularTable" class="table datatable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Pemilik</th>
                                    <th>No Pelanggan</th>
                                    <th>Kendaraan</th>
                                    <th>No Plat</th>
                                    <th>Terakhir Perawatan</th>
                                    <th>Jadwal Perawatan</th>
                                    <th>Status Reminder</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($regularKendaraans as $kendaraan)
                                    <tr>
                                        @include('dashboard.pages.admin.reminder._kendaraan_row')
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#overdueTable, #regularTable').DataTable({
                "pageLength": 10,
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
                }
            });

            $('.send-reminder').on('click', function() {
                var button = $(this);
                var id = button.data('id');
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Anda akan mengirim reminder WhatsApp ke pelanggan ini.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, kirim!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '{{ route('reminder.send', ':id') }}'.replace(':id', id),
                            type: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                _method: 'PUT'
                            },
                            success: function(response) {
                                Swal.fire(
                                    'Berhasil!',
                                    'Reminder telah dikirim.',
                                    'success'
                                ).then(() => {
                                    location.reload();
                                });
                            },
                            error: function(xhr) {
                                Swal.fire(
                                    'Error!',
                                    'Terjadi kesalahan saat mengirim reminder.',
                                    'error'
                                );
                            }
                        });
                    }
                });
            });
        });
    </script>
@endsection
