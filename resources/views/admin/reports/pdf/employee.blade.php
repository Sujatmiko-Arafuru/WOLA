<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Beban Kerja Pegawai - {{ $user->nip }}</title>
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
        .info-box {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .info-row {
            margin-bottom: 10px;
        }
        .info-label {
            font-weight: bold;
            display: inline-block;
            width: 150px;
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
        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 2px solid #ddd;
            text-align: center;
            font-size: 10px;
            color: #666;
        }
        .badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 10px;
            font-weight: bold;
        }
        .badge-daily {
            background: #17a2b8;
            color: white;
        }
        .badge-weekly {
            background: #ffc107;
            color: #333;
        }
        .badge-monthly {
            background: #28a745;
            color: white;
        }
        .badge-yearly {
            background: #1e5f5f;
            color: white;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h1>LAPORAN BEBAN KERJA PEGAWAI</h1>
        <p>Politeknik Kesehatan Denpasar</p>
        <p>Tanggal Cetak: {{ date('d F Y H:i') }}</p>
    </div>

    <!-- Employee Information -->
    <div class="info-box">
        <h3 style="margin-top: 0; color: #1e5f5f;">Informasi Pegawai</h3>
        <div class="info-row">
            <span class="info-label">Nama Lengkap:</span>
            <span>{{ $user->name }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">NIP:</span>
            <span>{{ $user->nip }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Email:</span>
            <span>{{ $user->email }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Jabatan:</span>
            <span>{{ $user->position }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Unit:</span>
            <span>{{ $user->unit ?? '-' }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Total Beban Kerja:</span>
            <span><strong>{{ number_format($total_minutes, 1) }} menit/hari</strong></span>
        </div>
        <div class="info-row">
            <span class="info-label">Status:</span>
            @php
                $statusClass = 'status-' . $status;
                $statusLabel = $status === 'optimal' ? 'OPTIMAL' : ($status === 'overload' ? 'KELEBIHAN BEBAN KERJA' : 'KEKURANGAN BEBAN KERJA');
                $statusColor = $status === 'optimal' ? '#28a745' : ($status === 'overload' ? '#dc3545' : '#ffc107');
                $statusBg = $status === 'optimal' ? '#d4edda' : ($status === 'overload' ? '#f8d7da' : '#fff3cd');
            @endphp
            <span style="background: {{ $statusBg }}; color: {{ $statusColor }}; padding: 5px 10px; border-radius: 5px; font-weight: bold;">
                {{ $statusLabel }}
            </span>
        </div>
    </div>

    <!-- Workload Entries Table -->
    <h3 style="color: #1e5f5f; margin-top: 20px;">Detail Beban Kerja</h3>
    @if($workload_entries->count() > 0)
        <table>
            <thead>
                <tr>
                    <th style="width: 5%;">No</th>
                    <th style="width: 45%;">Uraian Tugas</th>
                    <th style="width: 12%;">Jumlah</th>
                    <th style="width: 18%;">Satuan Waktu</th>
                    <th style="width: 20%;">Total Menit/Hari</th>
                </tr>
            </thead>
            <tbody>
                @foreach($workload_entries as $index => $entry)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
                            {{ $entry->task->task_description }}
                            <br>
                            <small style="color: #666;">({{ number_format($entry->task->time_per_unit) }} menit/unit)</small>
                        </td>
                        <td>{{ $entry->quantity }}</td>
                        <td>
                            @switch($entry->time_unit)
                                @case('daily')
                                    <span class="badge badge-daily">Harian</span>
                                    @break
                                @case('weekly')
                                    <span class="badge badge-weekly">Mingguan</span>
                                    @break
                                @case('monthly')
                                    <span class="badge badge-monthly">Bulanan</span>
                                    @break
                                @case('yearly')
                                    <span class="badge badge-yearly">Tahunan</span>
                                    @break
                            @endswitch
                        </td>
                        <td><strong>{{ number_format($entry->calculateMinutesPerDay(), 2) }}</strong></td>
                    </tr>
                @endforeach
                <tr style="background: #e9ecef; font-weight: bold;">
                    <td colspan="4" style="text-align: right;">TOTAL:</td>
                    <td><strong>{{ number_format($total_minutes, 2) }} menit/hari</strong></td>
                </tr>
            </tbody>
        </table>
    @else
        <p style="text-align: center; padding: 20px; background: #f8f9fa; border-radius: 5px;">
            Belum ada entri beban kerja untuk pegawai ini.
        </p>
    @endif

    <!-- Footer -->
    <div class="footer">
        <p>Dokumen ini digenerate secara otomatis oleh Sistem Informasi Beban Kerja</p>
        <p>Politeknik Kesehatan Denpasar © {{ date('Y') }}</p>
    </div>
</body>
</html>

