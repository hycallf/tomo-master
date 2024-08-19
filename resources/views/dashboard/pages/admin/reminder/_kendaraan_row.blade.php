<td>{{ $loop->iteration }}</td>
<td>{{ $kendaraan->pelanggan->nama }}</td>
<td>{{ $kendaraan->pelanggan->no_telp }}</td>
<td>{{ $kendaraan->tipe->nama_tipe . ' ' . $kendaraan->merek->nama_merek . ' ' . $kendaraan->keterangan }}</td>
<td>{{ $kendaraan->no_plat }}</td>
<td>{{ $kendaraan->last_maintenance_date->format('d-m-Y') }}
    <br>
    <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal"
        data-bs-target="#serviceModal{{ $kendaraan->id }}">
        <i class="bi bi-eye"></i>
    </button>
</td>
<td>Setiap {{ $kendaraan->maintenance_schedule_months }} Bulan</td>
<td>
    @if ($kendaraan->reminder_sent)
        <span class="badge bg-success">Terkirim</span>
        <br>
        <small>{{ $kendaraan->reminder_sent_at ? Carbon\Carbon::parse($kendaraan->reminder_sent_at)->format('d-m-Y H:i') : '' }}</small>
    @else
        <span class="badge bg-danger">Belum Terkirim</span>
    @endif
</td>
<td>
    @if (!$kendaraan->reminder_sent || $kendaraan->reminder_sent_at < now()->subMonths(3))
        <button type="button" class="btn btn-primary btn-sm send-reminder" data-id="{{ $kendaraan->id }}">
            Send <i class="bi bi-send"></i>
        </button>
    @else
        <button type="button" class="btn btn-warning btn-sm send-reminder" data-id="{{ $kendaraan->id }}">
            Re-Send <i class="bi bi-send"></i>
        </button>
    @endif
</td>

<!-- Modal untuk detail services -->
<div class="modal fade" id="serviceModal{{ $kendaraan->id }}" tabindex="-1"
    aria-labelledby="serviceModalLabel{{ $kendaraan->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="serviceModalLabel{{ $kendaraan->id }}">Detail Perbaikan -
                    {{ $kendaraan->tipe->nama_tipe . ' ' . $kendaraan->merek->nama_merek . ' ' . $kendaraan->keterangan }}
                    <br> Plat Nomor : {{ $kendaraan->no_plat }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul>
                    @forelse ($kendaraan->perbaikans as $perbaikan)
                        <li>Service Tiket : {{ $perbaikan->kode_unik }} <br>Service : {{ $perbaikan->nama }}
                            <br>Tanggal
                            Selesai : {{ $perbaikan->tgl_selesai }} <a
                                href="{{ route('perbaikan.show', $perbaikan->id) }}"><button
                                    class="btn btn-info btn-sm"><i class="bi bi-eye"></i></button></a></li>
                    @empty
                        <li>Belum ada data perbaikan</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div>
