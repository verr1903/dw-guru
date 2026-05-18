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

  /* ── Header ── */
  .header {
    display: flex;
    align-items: center;
    border-bottom: 3px solid #10b981;
    padding-bottom: 12px;
    margin-bottom: 18px;
  }
  .header-logo {
    width: 56px;
    height: 56px;
    background: #10b981;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 14px;
    flex-shrink: 0;
  }
  .header-logo span {
    color: #fff;
    font-size: 20pt;
    font-weight: 700;
    line-height: 1;
  }
  .header-text h1 {
    font-size: 16pt;
    font-weight: 700;
    color: #111827;
    letter-spacing: -0.3px;
  }
  .header-text p {
    font-size: 8.5pt;
    color: #6b7280;
    margin-top: 2px;
  }

  /* ── Meta badges ── */
  .meta-row {
    display: flex;
    gap: 10px;
    margin-bottom: 16px;
  }
  .badge {
    background: #f0fdf4;
    border: 1px solid #a7f3d0;
    border-radius: 6px;
    padding: 4px 10px;
    font-size: 8pt;
    color: #065f46;
    font-weight: 600;
  }
  .badge.gray {
    background: #f9fafb;
    border-color: #e5e7eb;
    color: #374151;
  }

  /* ── Table ── */
  table {
    width: 100%;
    border-collapse: collapse;
    font-size: 8.5pt;
  }
  thead tr {
    background: #10b981;
    color: #fff;
  }
  thead th {
    padding: 8px 7px;
    text-align: left;
    font-weight: 700;
    font-size: 8pt;
    letter-spacing: 0.3px;
  }
  thead th.right { text-align: right; }
  thead th.center { text-align: center; }

  tbody tr:nth-child(even) { background: #f0fdf4; }
  tbody tr:hover { background: #d1fae5; }
  tbody td {
    padding: 7px 7px;
    border-bottom: 1px solid #e5e7eb;
    color: #374151;
    vertical-align: middle;
  }
  tbody td.right  { text-align: right; }
  tbody td.center { text-align: center; }
  tbody td.bold   { font-weight: 700; color: #111827; }

  tfoot tr { background: #f3f4f6; }
  tfoot td {
    padding: 7px 7px;
    font-weight: 700;
    color: #111827;
    border-top: 2px solid #10b981;
    font-size: 8.5pt;
  }
  tfoot td.right { text-align: right; }

  /* ── Footer ── */
  .footer {
    margin-top: 20px;
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
    font-size: 7.5pt;
    color: #9ca3af;
    border-top: 1px solid #e5e7eb;
    padding-top: 10px;
  }
  .ttd-block {
    text-align: center;
    font-size: 8pt;
    color: #374151;
  }
  .ttd-block .label { font-weight: 600; }
  .ttd-blank { height: 50px; }
</style>
</head>
<body>

<!-- Header -->
<div class="header">
  <div class="header-logo"><span>C</span></div>
  <div class="header-text">
    <h1>Laporan Jam Mengajar Guru</h1>
    <p>SMA Cendana Pekanbaru &nbsp;·&nbsp; Tahun {{ $tahun }}</p>
  </div>
</div>

<!-- Meta -->
<div class="meta-row">
  <span class="badge">Tahun Ajaran {{ $tahun }}/{{ $tahun + 1 }}</span>
  <span class="badge gray">Total Guru: {{ $data->count() }}</span>
  <span class="badge gray">Total Jam: {{ number_format($data->sum('total_jam')) }}</span>
  <span class="badge gray">Dicetak: {{ now()->isoFormat('D MMMM YYYY') }}</span>
</div>

<!-- Table -->
<table>
  <thead>
    <tr>
      <th class="center" style="width:28px">No</th>
      <th style="width:100px">NIP</th>
      <th>Nama Guru</th>
      <th>Jabatan</th>
      <th>Bidang Studi</th>
      <th class="right" style="width:65px">Total Jam</th>
      <th class="right" style="width:65px">Hari Ngajar</th>
    </tr>
  </thead>
  <tbody>
    @foreach($data as $i => $row)
    <tr>
      <td class="center">{{ $i + 1 }}</td>
      <td>{{ $row->nip }}</td>
      <td class="bold">{{ $row->nama_guru }}</td>
      <td>{{ $row->jabatan }}</td>
      <td>{{ $row->bidang_studi }}</td>
      <td class="right bold" style="color:#065f46">{{ number_format($row->total_jam) }}</td>
      <td class="right">{{ number_format($row->total_hari_mengajar) }}</td>
    </tr>
    @endforeach
  </tbody>
  <tfoot>
    <tr>
      <td colspan="5" style="text-align:right">Total Keseluruhan</td>
      <td class="right">{{ number_format($data->sum('total_jam')) }}</td>
      <td class="right">{{ number_format($data->sum('total_hari_mengajar')) }}</td>
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