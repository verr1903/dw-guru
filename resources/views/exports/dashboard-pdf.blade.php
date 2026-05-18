<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'DejaVu Sans', Arial, sans-serif;
      font-size: 9pt;
      color: #1f2937;
      background: #fff;
    }

    /* Header */
    .header {
      border-bottom: 3px solid #374151;
      padding-bottom: 12px;
      margin-bottom: 16px;
    }

    .header h1 {
      font-size: 18pt;
      font-weight: 700;
      color: #111827;
    }

    .header p {
      font-size: 9pt;
      color: #6b7280;
      margin-top: 3px;
    }

    /* Stat grid */
    .stats {
      display: flex;
      gap: 10px;
      margin-bottom: 18px;
    }

    .stat-card {
      flex: 1;
      border: 1.5px solid #e5e7eb;
      border-radius: 8px;
      padding: 10px 12px;
      background: #f9fafb;
    }

    .stat-card .label {
      font-size: 7.5pt;
      color: #6b7280;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      font-weight: 600;
    }

    .stat-card .value {
      font-size: 18pt;
      font-weight: 700;
      color: #111827;
      margin-top: 3px;
      line-height: 1.1;
    }

    .stat-card .sub {
      font-size: 7pt;
      color: #9ca3af;
      margin-top: 2px;
    }

    .stat-card.green .value {
      color: #059669;
    }

    .stat-card.amber .value {
      color: #d97706;
    }

    /* Section title */
    .section-title {
      font-size: 10pt;
      font-weight: 700;
      color: #fff;
      background: #374151;
      padding: 6px 10px;
      border-radius: 6px;
      margin-bottom: 8px;
      margin-top: 14px;
    }

    /* Tables */
    table {
      width: 100%;
      border-collapse: collapse;
      font-size: 8pt;
      margin-bottom: 4px;
    }

    thead tr {
      background: #374151;
      color: #fff;
    }

    thead th {
      padding: 6px 7px;
      text-align: left;
      font-weight: 700;
      font-size: 7.5pt;
    }

    thead th.right {
      text-align: right;
    }

    thead th.center {
      text-align: center;
    }

    tbody tr:nth-child(even) {
      background: #f9fafb;
    }

    tbody td {
      padding: 5.5px 7px;
      border-bottom: 1px solid #e5e7eb;
      vertical-align: middle;
    }

    tbody td.right {
      text-align: right;
    }

    tbody td.center {
      text-align: center;
    }

    tbody td.bold {
      font-weight: 700;
      color: #111827;
    }

    tfoot tr {
      background: #f3f4f6;
    }

    tfoot td {
      padding: 6px 7px;
      font-weight: 700;
      border-top: 2px solid #374151;
    }

    tfoot td.right {
      text-align: right;
    }

    .status-baik {
      background: #d1fae5;
      color: #065f46;
      font-weight: 700;
      border-radius: 4px;
      padding: 1px 5px;
      font-size: 7pt;
    }

    .status-cukup {
      background: #fef3c7;
      color: #92400e;
      font-weight: 700;
      border-radius: 4px;
      padding: 1px 5px;
      font-size: 7pt;
    }

    .status-kurang {
      background: #fee2e2;
      color: #991b1b;
      font-weight: 700;
      border-radius: 4px;
      padding: 1px 5px;
      font-size: 7pt;
    }

    /* Two-column layout for tren + pie */
    .two-col {
      display: flex;
      gap: 14px;
      margin-top: 6px;
    }

    .col-left {
      flex: 3;
    }

    .col-right {
      flex: 2;
    }

    /* Tren table small */
    .tren-table thead tr {
      background: #6b7280;
    }

    /* Page footer */
    .page-footer {
      margin-top: 18px;
      border-top: 1px solid #e5e7eb;
      padding-top: 8px;
      display: flex;
      justify-content: space-between;
      font-size: 7pt;
      color: #9ca3af;
    }
  </style>
</head>

<body>

  <!-- Header -->
  <div class="header">
    <h1>Rekap Kinerja Guru — {{ isset($isSemua) && $isSemua ? 'Semua Tahun' : 'Tahun '.$tahun }}</h1>
    <p>SMA Cendana Pekanbaru &nbsp;·&nbsp; Dicetak: {{ now()->isoFormat('D MMMM YYYY, HH:mm') }} WIB</p>
  </div>

  <!-- Stat Cards -->
  <div class="stats">
    <div class="stat-card">
      <div class="label">Total Jam Mengajar</div>
      <div class="value">{{ number_format($totalJamMengajar) }}</div>
      <div class="sub">jam · tahun {{ $tahun }}</div>
    </div>
    <div class="stat-card green">
      <div class="label">Tingkat Kehadiran</div>
      <div class="value">{{ $kehadiranRataRata }}%</div>
      <div class="sub">rata-rata seluruh guru</div>
    </div>
    <div class="stat-card">
      <div class="label">Guru Aktif</div>
      <div class="value">{{ $totalGuru }}</div>
      <div class="sub">pengajar aktif</div>
    </div>
    <div class="stat-card amber">
      <div class="label">Total Prestasi</div>
      <div class="value">{{ $totalPrestasi }}</div>
      <div class="sub">pencapaian tercatat</div>
    </div>
  </div>

  <!-- Jam Mengajar Section -->
  <div class="section-title">Rekap Jam Mengajar per Guru</div>
  <table>
    <thead>
      <tr>
        <th class="center" style="width:24px">No</th>
        <th style="width:95px">NIP</th>
        <th>Nama Guru</th>
        <th>Jabatan</th>
        <th>Bidang Studi</th>
        <th class="right" style="width:60px">Total Jam</th>
        <th class="right" style="width:60px">Hari Ngajar</th>
      </tr>
    </thead>
    <tbody>
      @foreach($jamData as $i => $row)
      <tr>
        <td class="center">{{ $i + 1 }}</td>
        <td>{{ $row->nip }}</td>
        <td class="bold">{{ $row->nama_guru }}</td>
        <td>{{ $row->jabatan }}</td>
        <td>{{ $row->bidang_studi }}</td>
        <td class="right bold" style="color:#059669">{{ number_format($row->total_jam) }}</td>
        <td class="right">{{ number_format($row->total_hari_mengajar) }}</td>
      </tr>
      @endforeach
    </tbody>
    <tfoot>
      <tr>
        <td colspan="5" style="text-align:right">Total</td>
        <td class="right">{{ number_format($jamData->sum('total_jam')) }}</td>
        <td class="right">{{ number_format($jamData->sum('total_hari_mengajar')) }}</td>
      </tr>
    </tfoot>
  </table>

  <!-- Kehadiran Section -->
  <div class="section-title">Rekap Kehadiran Guru</div>
  <table>
    <thead>
      <tr>
        <th class="center" style="width:24px">No</th>
        <th style="width:95px">NIP</th>
        <th>Nama Guru</th>
        <th>Jabatan</th>
        <th class="right" style="width:38px">Hadir</th>
        <th class="right" style="width:32px">Sakit</th>
        <th class="right" style="width:32px">Izin</th>
        <th class="right" style="width:32px">Alfa</th>
        <th class="right" style="width:50px">% Hadir</th>
        <th class="center" style="width:46px">Status</th>
      </tr>
    </thead>
    <tbody>
      @foreach($kehadiranData as $i => $row)
      @php
      $statusClass = match(true) {
      $row->persen_kehadiran >= 90 => 'status-baik',
      $row->persen_kehadiran >= 75 => 'status-cukup',
      default => 'status-kurang',
      };
      $statusLabel = match(true) {
      $row->persen_kehadiran >= 90 => 'Baik',
      $row->persen_kehadiran >= 75 => 'Cukup',
      default => 'Kurang',
      };
      @endphp
      <tr>
        <td class="center">{{ $i + 1 }}</td>
        <td>{{ $row->nip }}</td>
        <td class="bold">{{ $row->nama_guru }}</td>
        <td>{{ $row->jabatan }}</td>
        <td class="right" style="color:#059669;font-weight:700">{{ $row->total_hadir }}</td>
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
        <td colspan="4" style="text-align:right">Rata-rata</td>
        <td class="right">—</td>
        <td class="right">—</td>
        <td class="right">—</td>
        <td class="right">—</td>
        <td class="right">{{ $kehadiranData->count() > 0 ? round($kehadiranData->avg('persen_kehadiran'), 1) : 0 }}%</td>
        <td></td>
      </tr>
    </tfoot>
  </table>

  <!-- Tren Bulanan -->
  <div class="section-title">Tren Bulanan</div>
  <table class="tren-table">
    <thead>
      <tr>
        @if(isset($isSemua) && $isSemua)
        <th style="width:50px">Tahun</th>
        @endif
        <th style="width:80px">Bulan</th>
        <th class="right">Total Jam</th>
        <th class="right">Hadir</th>
        <th class="right">Izin/Sakit</th>
        <th class="right">Alfa</th>
      </tr>
    </thead>
    <tbody>
      @foreach($trenBulan as $row)
      <tr>
        @if(isset($isSemua) && $isSemua)
        <td>{{ $row->tahun }}</td>
        @endif
        <td class="bold">{{ $namaBulan[$row->bulan] ?? $row->bulan }}</td>
        <td class="right">{{ number_format($row->total_jam) }}</td>
        <td class="right" style="color:#059669">{{ number_format($row->total_hadir) }}</td>
        <td class="right" style="color:#d97706">{{ number_format($row->total_izin) }}</td>
        <td class="right" style="color:#ef4444">{{ number_format($row->total_alpha) }}</td>
      </tr>
      @endforeach
    </tbody>
    <tfoot>
      <tr>
        <td>Total</td>
        <td class="right">{{ number_format($trenBulan->sum('total_jam')) }}</td>
        <td class="right">{{ number_format($trenBulan->sum('total_hadir')) }}</td>
        <td class="right">{{ number_format($trenBulan->sum('total_izin')) }}</td>
        <td class="right">{{ number_format($trenBulan->sum('total_alpha')) }}</td>
      </tr>
    </tfoot>
  </table>

  <!-- Page footer -->
  <div class="page-footer">
    <span>Sistem Informasi Kinerja Guru · SMA Cendana Pekanbaru</span>
    <span>{{ now()->isoFormat('D MMMM YYYY, HH:mm') }} WIB</span>
  </div>

</body>

</html>