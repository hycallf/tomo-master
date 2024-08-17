<td>{{ $loop->iteration }}</td>
<td>{{ $perbaikan->kode_unik }}</td>
<td>
    @if ($perbaikan->kendaraan && $perbaikan->kendaraan->pelanggan)
        {{ $perbaikan->kendaraan->pelanggan->nama }}
    @else
        Data Pelanggan Tidak Tersedia
    @endif
</td>
<td>
    @if ($perbaikan->kendaraan && $perbaikan->kendaraan->pelanggan)
        {{ $perbaikan->kendaraan->pelanggan->no_telp }}
    @else
        Data Pelanggan Tidak Tersedia
    @endif
</td>
<td>
    @if ($perbaikan->kendaraan)
        {{ $perbaikan->kendaraan->tipe->nama_tipe . ' ' . $perbaikan->kendaraan->merek->nama_merek . ' ' . $perbaikan->kendaraan->keterangan }}
    @else
        Data Kendaraan Tidak Tersedia
    @endif
</td>
<td>
    @if ($perbaikan->kendaraan)
        {{ $perbaikan->kendaraan->no_plat }}
    @else
        Data Kendaraan Tidak Tersedia
    @endif
</td>
<td>{{ \Carbon\Carbon::parse($perbaikan->tgl_selesai)->format('d-m-Y') }}</td>
<td>{{ $perbaikan->durasi }}</td>
<td>
    @if ($perbaikan->reminder_sent)
        <span class="badge bg-success">Terkirim</span>
        <br>
        <small>{{ $perbaikan->reminder_sent_at ? Carbon\Carbon::parse($perbaikan->reminder_sent_at)->format('d-m-Y H:i') : '' }}</small>
        <button type="button" class="btn btn-warning btn-sm send-reminder" data-id="{{ $perbaikan->id }}">Re-send <i
                class="bi bi-send"></i></button>
    @else
        <button type="button" class="btn btn-primary btn-sm send-reminder" data-id="{{ $perbaikan->id }}">
            Send <i class="bi bi-send"></i>
        </button>
    @endif
</td>
