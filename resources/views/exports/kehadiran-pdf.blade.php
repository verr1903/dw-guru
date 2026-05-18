<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<style>
  * { margin: 0; padding: 0; box-sizing: border-box; }

  body {
    font-family: 'DejaVu Sans', Arial, sans-serif;
    font-size: 9pt;
    color: #1f2937;
    background: #fff;
  }

  .header {
    display: flex;
    align-items: center;
    border-bottom: 3px solid #3b82f6;
    padding-bottom: 12px;
    margin-bottom: 18px;
  }
  .header-logo {
    width: 56px;
    height: 56px;
    background: #3b82f6;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 14px;
    flex-shrink: 0;
  }
  .header-logo span { color:#fff; font-size:20pt; font-weight:700; line-height:1; }
  .header-text h1   { font-size:16pt; font-weight:700; color:#111827; letter-spacing:-0.3px; }
  .header-text p    { font-size:8.5pt; color:#6b7280; margin-top:2px; }

  .meta-row { display:flex; gap:10px; margin-bottom:16px; }
  .badge {
    background:#eff6ff; border:1px solid #bfdbfe;
    border-radius:6px; padding:4px 10px;
    font-size:8pt; color:#1e40af; font-weight:600;
  }
  .badge.gray { background:#f9fafb; border-color:#e5e7eb; color:#374151; }

  /* Legend */
  .legend { display:flex; gap:14px; margin-bottom:12px; font-size:7.5pt; }
  .legend-item { display:flex; align-items:center; gap:4px; }
  .dot { width:8px; height:8px; border-radius:50%; display:inline-block; }
  .dot.green { background:#10b981; }
  .dot.yellow { background:#f59e0b; }
  .dot.red { background:#ef4444; }

  table { width:100%; border-collapse:collapse; font-size:8.5pt; }
  thead tr { background:#3b82f6; color:#fff; }
  thead th { padding:8px 6px; text-align:left; font-weight:700; font-size:8pt; letter-spacing:0.3px; }
  thead th.right  { text-align:right; }
  thead th.center { text-align:center; }

  tbody tr:nth-child(even) { background:#eff6ff; }
  tbody td { padding:6.5px 6px; border-bottom:1px solid #e5e7eb; color:#374151; vertical-align:middle; }
  tbody td.right  { text-align:right; }
  tbody td.center { text-align:center; }
  tbody td.bold   { font-weight:700; color:#111827; }

  .status-baik  { background:#d1fae5; color:#065f46; font-weight:700; border-radius:4px; padding:2px 6px; font-size:7.5pt; }
  .status-cukup { background:#fef3c7; color:#92400e; font-weight:700; border-radius:4px; padding:2px 6px; font-size:7.5pt; }
  .status-kurang{ background:#fee2e2; color:#991b1b; font-weight:700; border-radius:4px; padding:2px 6px; font-size:7.5pt; }

  tfoot tr { background:#f3f4f6; }
  tfoot td { padding:7px 6px; font-weight:700; color:#111827; border-top:2px solid #3b82f6; }
  tfoot td.right { text-align:right; }

  .footer {
    margin-top:20px; display:flex; justify-content:space-between;
    align-items:flex-end; font-size:7.5pt; color:#9ca3af;
    border-top:1px solid #e5e7eb; padding-top:10px;
  }
  .ttd-block { text-align:center; font-size:8pt; color:#374151; }
  .ttd-block .label { font-weight:600; }
  .ttd-blank { height:50px; }
</style>
</head>
<body>

<!-- Header -->
<div class="header">
  <div class="header-logo"><span>C</span></div>
  <div class="header-text">
    <h1>Laporan Kehadiran Guru</h1>
    <p>SMA Cendana Pekanbaru &nbsp;·&nbsp; Tahun {{ $tahun }}</p>
  </div>
</div>

<!-- Meta -->
<div class="meta-row">
  <span class="badge">Tahun {{ $tahun }}</span>
  <span class="badge gray">Total Guru: {{ $data->count() }}</span>
  <span class="badge gray">Rata-rata Hadir: {{ $data->count() > 0 ? round($data->avg('persen_kehadiran'), 1) : 0 }}%</span>
  <span class="badge gray">Dicetak: {{ now()->isoFormat('D MMMM YYYY') }}</span>
</div>

<!-- Legend -->
<div class="legend">
  <span class="legend-item"><span class="dot green"></span> Baik (≥ 90%)</span>
  <span class="legend-item"><span class="dot yellow"></span> Cukup (75–89%)</span>
  <span class="legend-item"><span class="dot red"></span> Kurang (&lt; 75%)</span>
</div>

<!-- Table -->
<table>
  <thead>
    <tr>
      <th class="center" style="width:28px">No</th>
      <th style="width:100px">NIP</th>
      <th>Nama Guru</th>
      <th>Jabatan</th>
      <th class="right" style="width:40px">Hadir</th>
      <th class="right" style="width:36px">Sakit</th>
      <th class="right" style="width:36px">Izin</th>
      <th class="right" style="width:36px">Alfa</th>
      <th class="right" style="width:52px">% Hadir</th>
      <th class="center" style="width:52px">Status</th>
    </tr>
  </thead>
  <tbody>
    @foreach($data as $i => $row)
    @php
      $statusClass = match(true) {
        $row->persen_kehadiran >= 90 => 'status-baik',
        $row->persen_kehadiran >= 75 => 'status-cukup',
        default                      => 'status-kurang',
      };
      $statusLabel = match(true) {
        $row->persen_kehadiran >= 90 => 'Baik',
        $row->persen_kehadiran >= 75 => 'Cukup',
        default                      => 'Kurang',
      };
    @endphp
    <tr>
      <td class="center">{{ $i + 1 }}</td>
      <td>{{ $row->nip }}</td>
      <td class="bold">{{ $row->nama_guru }}</td>
      <td>{{ $row->jabatan }}</td>
      <td class="right" style="color:#065f46;font-weight:700">{{ $row->total_hadir }}</td>
      <td class="right" style="color:#d97706">{{ $row->total_sakit }}</td>
      <td class="right" style="color:#f59e0b">{{ $row->total_izin }}</td>
      <td class="right" style="color:#ef4444">{{ $row->total_alfa }}</td>
      <td class="right bold">{{ $row->persen_kehadiran }}%</td>
      <td class="center"><span class="{{ $statusClass }}">{{ $statusLabel }}</span></td>
    </tr>
    @endforeach
  </tbody>
  <tfoot>
    <tr>
      <td colspan="4" style="text-align:right">Total / Rata-rata</td>
      <td class="right">{{ number_format($data->sum('total_hadir')) }}</td>
      <td class="right">{{ number_format($data->sum('total_sakit')) }}</td>
      <td class="right">{{ number_format($data->sum('total_izin')) }}</td>
      <td class="right">{{ number_format($data->sum('total_alfa')) }}</td>
      <td class="right">{{ $data->count() > 0 ? round($data->avg('persen_kehadiran'), 1) : 0 }}%</td>
      <td></td>
    </tr>
  </tfoot>
</table>

<!-- Footer -->
<div class="footer">
  <div>
    <p>Dokumen ini digenerate secara otomatis oleh Sistem Informasi Kinerja Guru.</p>
    <p>SMA Cendana Pekanbaru &nbsp;·&nbsp; {{ now()->isoFormat('D MMMM YYYY, HH:mm') }} WIB</p>
  </div>
  <div class="ttd-block">
    <p class="label">Mengetahui,</p>
    <p>Kepala Sekolah</p>
    <div class="ttd-blank"></div>
    <p>____________________________</p>
    <p>NIP. &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
  </div>
</div>

</body>
</html>