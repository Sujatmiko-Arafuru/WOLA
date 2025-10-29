<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Unit - {{ $unit }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.6;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 3px solid #1e5f5f;
        }
        .header h1 {
            margin: 0;
            color: #1e5f5f;
            font-size: 24px;
        }
        .header p {
            margin: 5px 0;
            color: #666;
        }
        .unit-name {
            background: #1e5f5f;
            color: white;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            text-align: center;
        }
        .unit-name h2 {
            margin: 0;
            font-size: 20px;
        }
        .summary-box {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .summary-grid {
            display: table;
            width: 100%;
            margin-top: 10px;
        }
        .summary-item {
            display: table-cell;
            width: 25%;
            text-align: center;
            padding: 10px;
            vertical-align: top;
        }
        .summary-number {
            font-size: 24px;
            font-weight: bold;
            color: #1e5f5f;
        }
        .summary-label {
            font-size: 11px;
            color: #666;
            margin-top: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        table th {
            background: #1e5f5f;
            color: white;
            padding: 10px;
            text-align: left;
            font-weight: bold;
        }
        table td {
            padding: 8px;
            border-bottom: 1px solid #ddd;
        }
        table tr:nth-child(even) {
            background: #f8f9fa;
        }
        .badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 10px;
            font-weight: bold;
        }
        .badge-optimal {
            background: #28a745;
            color: white;
        }
        .badge-overload {
            background: #dc3545;
            color: white;
        }
        .badge-underload {
            background: #ffc107;
            color: #333;
        }
        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 2px solid #ddd;
            text-align: center;
            font-size: 10px;
            color: #666;
        }
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h1>LAPORAN BEBAN KERJA PER UNIT</h1>
        <p>Politeknik Kesehatan Denpasar</p>
        <p>Tanggal Cetak: {{ date('d F Y H:i') }}</p>
    </div>

    <!-- Unit Name -->
    <div class="unit-name">
        <h2>{{ $unit }}</h2>
    </div>

    <!-- Summary Statistics -->
    <div class="summary-box">
        <h3 style="margin-top: 0; color: #1e5f5f;">Ringkasan Unit</h3>
        <div class="summary-grid">
            <div class="summary-item">
                <div class="summary-number">{{ $employees->count() }}</div>
                <div class="summary-label">Total Pegawai</div>
            </div>
            <div class="summary-item">
                <div class="summary-number" style="color: #28a745;">
                    {{ $employees->where('status', 'optimal')->count() }}
                </div>
                <div class="summary-label">Optimal</div>
            </div>
            <div class="summary-item">
                <div class="summary-number" style="color: #ffc107;">
                    {{ $employees->where('status', 'underload')->count() }}
                </div>
                <div class="summary-label">Kekurangan Beban</div>
            </div>
            <div class="summary-item">
                <div class="summary-number" style="color: #dc3545;">
                    {{ $employees->where('status', 'overload')->count() }}
                </div>
                <div class="summary-label">Kelebihan Beban</div>
            </div>
        </div>
        
        @php
            $totalPegawai = $employees->count();
            $optimalCount = $employees->where('status', 'optimal')->count();
            $optimalPercentage = $totalPegawai > 0 ? ($optimalCount / $totalPegawai) * 100 : 0;
        @endphp
        
        <div style="margin-top: 15px; padding-top: 15px; border-top: 1px solid #ddd;">
            <strong>Persentase Optimal:</strong> {{ number_format($optimalPercentage, 1) }}%
            @if($optimalPercentage >= 90)
                <span style="color: #28a745; font-weight: bold;"> (Unit Optimal)</span>
            @else
                <span style="color: #ffc107; font-weight: bold;"> (Perlu Peningkatan)</span>
            @endif
        </div>
    </div>

    <!-- Employee Table -->
    <h3 style="color: #1e5f5f;">Daftar Pegawai</h3>
    @if($employees->count() > 0)
        <table>
            <thead>
                <tr>
                    <th style="width: 5%;">No</th>
                    <th style="width: 30%;">Nama</th>
                    <th style="width: 20%;">NIP</th>
                    <th style="width: 20%;">Beban Kerja (Menit/Hari)</th>
                    <th style="width: 10%;">Target</th>
                    <th style="width: 15%;">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($employees as $index => $data)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $data['user']->name }}</td>
                        <td>{{ $data['user']->nip }}</td>
                        <td>
                            <strong>{{ number_format($data['total_minutes'], 1) }}</strong>
                            @php
                                $diff = $data['total_minutes'] - 300;
                            @endphp
                            @if($diff != 0)
                                <br>
                                <small style="color: #666;">
                                    ({{ $diff > 0 ? '+' : '' }}{{ number_format($diff, 1) }})
                                </small>
                            @endif
                        </td>
                        <td>300</td>
                        <td>
                            @if($data['status'] === 'optimal')
                                <span class="badge badge-optimal">Optimal</span>
                            @elseif($data['status'] === 'overload')
                                <span class="badge badge-overload">Kelebihan</span>
                            @else
                                <span class="badge badge-underload">Kekurangan</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p style="text-align: center; padding: 20px; background: #f8f9fa; border-radius: 5px;">
            Tidak ada data pegawai untuk unit ini.
        </p>
    @endif

    <!-- Footer -->
    <div class="footer">
        <p>Dokumen ini digenerate secara otomatis oleh Sistem Informasi Beban Kerja</p>
        <p>Politeknik Kesehatan Denpasar © {{ date('Y') }}</p>
    </div>
</body>
</html>

