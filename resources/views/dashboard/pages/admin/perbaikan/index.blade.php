@extends('dashboard.layouts.main')

@section('content')
    <div class="pagetitle">
        <h1>Kendraan</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Kendraan</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Data Kendraan</h5>
                        <a class="btn btn-outline-primary mb-4" href="{{ route('kendaraan.create') }}">
                            <i class="ri-add-circle-line"></i>
                            Tambah
                        </a>

                        <!-- Table with stripped rows -->
                        <table id="datatable" class="table table-bordered ">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Pemilik</th>
                                    <th>No Plat</th>
                                    <th>Merek</th>
                                    <th>Tipe</th>
                                    <th>Keterangan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($kendaraans as $kendaraan)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $kendaraan->pelanggan->nama ?? '' }}</td>
                                        <td>{{ $kendaraan->no_plat }}</td>
                                        <td>{{ $kendaraan->merek }}</td>
                                        <td>{{ $kendaraan->tipe }}</td>
                                        <td>{{ $kendaraan->keterangan }}</td>
                                        <td>
                                            <a class="btn btn-success btn-sm"
                                                href="{{ route('kendaraan.show', $kendaraan->id) }}">
                                                <i class="ri-eye-line"></i>
                                            </a>
                                            <a class="btn btn-primary btn-sm"
                                                href="{{ route('kendaraan.edit', $kendaraan->id) }}">
                                                <i class="ri-edit-2-line"></i>
                                            </a>
                                            <a class="btn btn-danger btn-sm" href="javascript:"
                                                onclick="deleteData({{ $kendaraan->id }})">
                                                <i class="ri-delete-bin-5-line"></i>
                                            </a>

                                            <form class="d-none" id="formDelete-{{ $kendaraan->id }}"
                                                action="{{ route('kendaraan.destroy', $kendaraan->id) }}" method="POST">
                                                @method('DELETE')
                                                @csrf
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <!-- End Table with stripped rows -->
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
                lengthMenu: [
                    [5, 10, 25, 50, -1],
                    [5, 10, 25, 50, "All"]
                ],
            });
        })
    </script>

    <script>
        function deleteData(id) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('formDelete-' + id).submit()
                }
            });
        }
    </script>
@endsection
