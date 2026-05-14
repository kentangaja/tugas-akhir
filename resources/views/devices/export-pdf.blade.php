<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #10b981;
            padding-bottom: 15px;
        }
        .header h1 {
            margin: 0;
            color: #1f2937;
        }
        .header p {
            margin: 5px 0;
            color: #666;
        }
        .filter-info {
            background-color: #f3f4f6;
            padding: 10px 15px;
            margin-bottom: 20px;
            border-radius: 5px;
            font-size: 12px;
        }
        .stats {
            display: flex;
            gap: 20px;
            margin-bottom: 25px;
        }
        .stat-box {
            flex: 1;
            border: 2px solid #10b981;
            padding: 15px;
            border-radius: 8px;
            text-align: center;
        }
        .stat-label {
            font-size: 12px;
            color: #666;
            font-weight: bold;
            margin-bottom: 8px;
        }
        .stat-value {
            font-size: 24px;
            font-weight: bold;
            color: #10b981;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table thead {
            background-color: #f3f4f6;
        }
        table th {
            padding: 12px;
            text-align: left;
            font-weight: bold;
            border: 1px solid #e5e7eb;
            font-size: 13px;
        }
        table td {
            padding: 12px;
            border: 1px solid #e5e7eb;
            font-size: 12px;
        }
        table tbody tr:nth-child(even) {
            background-color: #fafafa;
        }
        .status-hot {
            background-color: #fee2e2;
            color: #b91c1c;
            padding: 4px 12px;
            border-radius: 20px;
            font-weight: bold;
            text-align: center;
            font-size: 11px;
        }
        .status-normal {
            background-color: #dcfce7;
            color: #166534;
            padding: 4px 12px;
            border-radius: 20px;
            font-weight: bold;
            text-align: center;
            font-size: 11px;
        }
        .footer {
            margin-top: 30px;
            padding-top: 15px;
            border-top: 1px solid #e5e7eb;
            font-size: 11px;
            color: #999;
            text-align: center;
        }
        .temperature-value {
            background-color: #fed7aa;
            padding: 4px 8px;
            border-radius: 4px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>📊 Laporan Data Sensor</h1>
        <p><strong>Device:</strong> {{ $device->device_name }}</p>
        <p><strong>Tanggal Laporan:</strong> {{ now()->format('d F Y H:i') }}</p>
    </div>

    @if ($startDate || $endDate || $minTemp || $maxTemp)
    <div class="filter-info">
        <strong>Filter yang Diterapkan:</strong>
        @if ($startDate)
            Dari {{ \Carbon\Carbon::parse($startDate)->format('d/m/Y') }}
        @endif
        @if ($endDate)
            sampai {{ \Carbon\Carbon::parse($endDate)->format('d/m/Y') }}
        @endif
        @if ($minTemp)
            | Temp min: {{ $minTemp }}°C
        @endif
        @if ($maxTemp)
            | Temp max: {{ $maxTemp }}°C
        @endif
    </div>
    @endif

    <div class="stats">
        <div class="stat-box">
            <div class="stat-label">Total Data</div>
            <div class="stat-value">{{ $sensorData->count() }}</div>
        </div>
        <div class="stat-box">
            <div class="stat-label">Rata-rata Suhu</div>
            <div class="stat-value">{{ number_format($sensorData->avg('avg_temperature') ?? 0, 1) }}°C</div>
        </div>
        <div class="stat-box">
            <div class="stat-label">Status Rata-rata</div>
            <div class="stat-value">
                @php
                    $avgTemp = $sensorData->avg('avg_temperature') ?? 0;
                    $status = $avgTemp > 30 ? 'Panas' : 'Normal';
                @endphp
                {{ $status }}
            </div>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Rata-rata Suhu</th>
                <th>Status</th>
                <th>Rata-rata Kelembaban</th>
                <th>Rata-rata Tanah</th>
                <th>Data Points</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($sensorData as $data)
            @php
                $dataStatus = $data->avg_temperature > 30 ? 'Panas' : 'Normal';
            @endphp
            <tr>
                <td>{{ \Carbon\Carbon::parse($data->date)->format('d M Y') }}</td>
                <td><span class="temperature-value">{{ number_format($data->avg_temperature ?? 0, 1) }}°C</span></td>
                <td>
                    @if ($dataStatus === 'Panas')
                        <div class="status-hot">🔥 Panas</div>
                    @else
                        <div class="status-normal">✓ Normal</div>
                    @endif
                </td>
                <td>{{ number_format($data->avg_humidity ?? 0, 1) }}%</td>
                <td>{{ number_format($data->avg_soil ?? 0, 1) }}</td>
                <td>{{ $data->count }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align: center; padding: 20px;">Tidak ada data sensor tersedia</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Laporan ini dibuat secara otomatis dari Sistem Monitoring Sensor</p>
        <p>© 2026 All Rights Reserved</p>
    </div>
</body>
</html>
