<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Status - {{ $status_label }}</title>
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
        .status-banner {
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 30px;
            text-align: center;
        }
        .status-optimal {
            background: #d4edda;
            border: 3px solid #28a745;
        }
        .status-optimal h2 {
            color: #155724;
            margin: 0;
        }
        .status-overload {
            background: #f8d7da;
            border: 3px solid #dc3545;
        }
        .status-overload h2 {
            color: #721c24;
            margin: 0;
        }
        .status-underload {
            background: #fff3cd;
            border: 3px solid #ffc107;
        }
        .status-underload h2 {
            color: #856404;
            margin: 0;
        }
        .summary-box {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .summary-stat {
            display: inline-block;
            margin-right: 30px;
        }
        .summary-number {
            font-size: 32px;
            font-weight: bold;
            color: #1e5f5f;
        }
        .summary-label {
            font-size: 12px;
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
            color: white;
        }
        .badge-unit {
            background: #17a2b8;
        }
        .info-box {
            background: #e9ecef;
            padding: 15px;
            border-left: 4px solid #1e5f5f;
            margin: 20px 0;
        }
        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 2px solid #ddd;
            text-align: center;
            font-size: 10px;
            color: #666;
        }
        .unit-breakdown {
            margin: 20px 0;
        }
        .unit-item {
            background: white;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 3px;
            border-left: 3px solid #1e5f5f;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h1>LAPORAN PEGAWAI BERDASARKAN STATUS</h1>
        <p>Politeknik Kesehatan Denpasar</p>
        <p>Tanggal Cetak: {{ date('d F Y H:i') }}</p>
    </div>

    <!-- Status Banner -->
    <div class="status-banner status-{{ $status }}">
        <h2>{{ strtoupper($status_label) }}</h2>
        <p style="font-size: 14px; margin: 10px 0;">
            Laporan Pegawai dengan Status: <strong>{{ $status_label }}</strong>
        </p>
    </div>

    <!-- Employee Table -->
    <h3 style="color: #1e5f5f;">Daftar Pegawai</h3>
    @if($employees->count() > 0)
        <table>
            <thead>
                <tr>
                    <th style="width: 5%;">No</th>
                    <th style="width: 25%;">Nama</th>
                    <th style="width: 18%;">NIP</th>
                    <th style="width: 20%;">Unit</th>
                    <th style="width: 17%;">Beban Kerja</th>
                    <th style="width: 15%;">Selisih</th>
                </tr>
            </thead>
            <tbody>
                @foreach($employees as $index => $data)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $data['user']->name }}</td>
                        <td>{{ $data['user']->nip }}</td>
                        <td>
                            <span class="badge badge-unit">{{ $data['user']->unit ?? '-' }}</span>
                        </td>
                        <td>
                            <strong>{{ number_format($data['total_minutes'], 1) }}</strong> menit/hari
                        </td>
                        <td>
                            @php
                                $diff = $data['total_minutes'] - 300;
                            @endphp
                            <strong style="color: {{ $diff > 0 ? '#dc3545' : '#ffc107' }};">
                                {{ $diff > 0 ? '+' : '' }}{{ number_format($diff, 1) }} menit
                            </strong>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p style="text-align: center; padding: 20px; background: #f8f9fa; border-radius: 5px;">
            Tidak ada pegawai dengan status {{ $status_label }}.
        </p>
    @endif

    <!-- Footer -->
    <div class="footer">
        <p>Dokumen ini digenerate secara otomatis oleh Sistem Informasi Beban Kerja</p>
        <p>Politeknik Kesehatan Denpasar © {{ date('Y') }}</p>
        <p style="margin-top: 10px; font-style: italic;">
            Untuk informasi lebih lanjut atau diskusi terkait laporan ini, silakan hubungi Bagian Kepegawaian atau HRD
        </p>
    </div>
</body>
</html>

