@extends('dashboard.layouts.main')

@section('css')
    <style>
        @media print {
            body * {
                visibility: hidden;
            }

            .invoice-container,
            .invoice-container * {
                visibility: visible;
            }

            .invoice-container {
                position: absolute;
                left: 0;
                top: 0;
            }

            .no-print {
                display: none;
            }
        }

        .invoice-container {
            background-color: white;
            padding: 20px;
        }

        .invoice-container .card {
            border: none;
            box-shadow: none;
        }

        .invoice-container .card-body {
            padding: 0;
        }

        .table-borderless th,
        .table-borderless td {
            border: none;
        }
    </style>
@endsection
@section('content')
    <div class="pagetitle">
        <h1>Lihat Transaksi</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active"><a
                        href="{{ route('dashboard.pelanggan.history-transaksi', auth()->user()->pelanggan->id) }}">Transaksi
                        Saya</a>
                </li>
                <li class="breadcrumb-item active">Show</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="mb-4">
                <a href="{{ route('dashboard.pelanggan.history-transaksi', auth()->user()->pelanggan->id) }}"
                    class="btn btn-outline-secondary" data-bs-toggle="tooltip" data-bs-placement="right" title="Kembali">
                    <i class="ri-arrow-go-back-line"></i>
                </a>
            </div>

            <div class="col-md-12 text-end no-print">
                <button onclick="printInvoice()" class="btn btn-primary">
                    <i class="bi bi-printer"></i> Cetak Invoice
                </button>
                <button onclick="generatePDF()" class="btn btn-success">
                    <i class="bi bi-file-earmark-pdf"></i> PDF
                </button>
            </div>

            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="panel-body mt-4">
                            <div class="clearfix">
                                <div class="float-start">
                                    <h3>Bengkel Cat W</h3>
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
                                            <strong>Bengkel Cat W</strong><br>
                                            Jl. AR Hakim No.25<br>
                                            Krajan IV, Semanten, Kec. Pacitan, Kabupaten Pacitan,<br>
                                            Jawa Timur 63518<br>
                                            <abbr title="Phone">P:</abbr> (+62) 89-696-764-576
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
                                    <h4><strong>Rp. {{ number_format($transaksi->gross_amount) ?? '-' }}</strong></h4>
                                </div>
                            </div>
                            <hr>
                            {{-- <div class="d-print-none">
                                <div class="float-end">
                                    <a href="#" class="btn btn-dark">
                                        <i class="bi bi-printer-fill"></i>
                                        Cetak
                                    </a>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.3.2/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script>
        function printInvoice() {
            window.print();
        }

        function generatePDF() {
            const {
                jsPDF
            } = window.jspdf;

            // Ambil elemen invoice-container
            var element = document.querySelector('.invoice-container');

            // Buat instance jsPDF
            var doc = new jsPDF('l', 'pt', 'a4');

            // Atur opsi untuk html2canvas
            var options = {
                scale: 2,
                useCORS: true,
                backgroundColor: '#ffffff'
            };

            // Gunakan html2canvas untuk mengubah elemen menjadi canvas
            html2canvas(element, options).then(function(canvas) {
                var imgData = canvas.toDataURL('image/png');
                var imgWidth = doc.internal.pageSize.getWidth();
                var pageHeight = doc.internal.pageSize.getHeight();
                var imgHeight = canvas.height * imgWidth / canvas.width;
                var heightLeft = imgHeight;
                var position = 0;

                doc.addImage(imgData, 'PNG', 0, position, imgWidth, imgHeight);
                heightLeft -= pageHeight;

                while (heightLeft >= 0) {
                    position = heightLeft - imgHeight;
                    doc.addPage();
                    doc.addImage(imgData, 'PNG', 0, position, imgWidth, imgHeight);
                    heightLeft -= pageHeight;
                }

                // Simpan PDF
                doc.save('invoice.pdf');
            });
        }
    </script>
@endsection
