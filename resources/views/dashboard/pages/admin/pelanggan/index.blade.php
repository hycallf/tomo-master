@extends('dashboard.layouts.main')

@section('content')
    <div class="pagetitle">
        <h1>Pelanggan</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Pelanggan</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Data Pelanggan</h5>
                        <a class="btn btn-outline-primary mb-4" href="{{ route('pelanggan.create') }}">
                            <i class="ri-add-circle-line"></i>
                            Tambah
                        </a>

                        <table id="datatable"
                            class="display table table-hover table-bordered dt-responsive table-responsive"
                            style="width:100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama</th>
                                    <th>No Telp</th>
                                    <th>Alamat</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Loaded by AJAX -->
                            </tbody>
                        </table>
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
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: "{{ route('pelanggan.data-table') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                        width: '5%'
                    },
                    {
                        data: 'nama',
                        name: 'nama'
                    },
                    {
                        data: 'no_telp',
                        name: 'no_telp'
                    },
                    {
                        data: 'alamat',
                        name: 'alamat'
                    },
                    {
                        data: 'aksi',
                        name: 'aksi',
                        orderable: false,
                        searchable: false
                    }
                ],
            });
        });

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
                    var url = '{{ route('pelanggan.destroy', ':id') }}';
                    url = url.replace(':id', id);

                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: {
                            '_token': '{{ csrf_token() }}',
                            '_method': 'DELETE'
                        },
                        success: function(response) {
                            $('#datatable').DataTable().ajax.reload();
                            Swal.fire(
                                'Deleted!',
                                'Data telah dihapus.',
                                'success'
                            );
                        },
                        error: function(xhr, status, error) {
                            var errorMessage = '';
                            if (xhr.responseText) {
                                var errorResponse = JSON.parse(xhr.responseText);
                                if (errorResponse.message) {
                                    errorMessage = errorResponse.message;
                                }
                            }
                            Swal.fire(
                                'Error!',
                                errorMessage,
                                'error'
                            );
                        }
                    });
                }
            });
        }
    </script>
@endsection
