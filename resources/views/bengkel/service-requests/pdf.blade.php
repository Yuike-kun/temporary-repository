<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Permintaan Layanan - {{ $bengkel->name }}</title>
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
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            color: #2c3e50;
        }
        .header h2 {
            margin: 5px 0;
            font-size: 18px;
            color: #7f8c8d;
            font-weight: normal;
        }
        .info-section {
            margin-bottom: 20px;
            background: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
        }
        .info-section h3 {
            margin: 0 0 10px 0;
            font-size: 14px;
            color: #2c3e50;
        }
        .info-row {
            margin: 5px 0;
        }
        .info-label {
            font-weight: bold;
            display: inline-block;
            width: 150px;
        }
        .stats-grid {
            display: table;
            width: 100%;
            margin: 20px 0;
            border-collapse: collapse;
        }
        .stats-row {
            display: table-row;
        }
        .stats-cell {
            display: table-cell;
            width: 16.66%;
            padding: 15px;
            text-align: center;
            border: 1px solid #dee2e6;
            background: #f8f9fa;
        }
        .stats-cell .number {
            font-size: 24px;
            font-weight: bold;
            color: #2c3e50;
        }
        .stats-cell .label {
            font-size: 11px;
            color: #7f8c8d;
            text-transform: uppercase;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th {
            background-color: #2c3e50;
            color: white;
            padding: 10px;
            text-align: left;
            font-weight: bold;
            font-size: 11px;
            text-transform: uppercase;
        }
        td {
            padding: 8px;
            border-bottom: 1px solid #dee2e6;
            font-size: 11px;
        }
        tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        .status-badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 3px;
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .status-pending { background: #ffc107; color: #000; }
        .status-accepted { background: #17a2b8; color: #fff; }
        .status-otw { background: #007bff; color: #fff; }
        .status-completed { background: #28a745; color: #fff; }
        .status-cancelled { background: #6c757d; color: #fff; }
        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #dee2e6;
            text-align: center;
            font-size: 10px;
            color: #7f8c8d;
        }
        .no-data {
            text-align: center;
            padding: 40px;
            color: #7f8c8d;
            font-style: italic;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Laporan Permintaan Layanan</h1>
        <h2>{{ $bengkel->name }}</h2>
    </div>

    <div class="info-section">
        <h3>Informasi Bengkel</h3>
        <div class="info-row">
            <span class="info-label">Nama Bengkel:</span>
            <span>{{ $bengkel->name }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Alamat:</span>
            <span>{{ $bengkel->address }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Telepon:</span>
            <span>{{ $bengkel->phone }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Jam Operasional:</span>
            <span>{{ $bengkel->open_time }} - {{ $bengkel->close_time }}</span>
        </div>
    </div>

    <div class="info-section">
        <h3>Filter Laporan</h3>
        <div class="info-row">
            <span class="info-label">Tanggal Cetak:</span>
            <span>{{ now()->format('d F Y, H:i') }}</span>
        </div>
        @if($filters['status'] && $filters['status'] !== 'all')
        <div class="info-row">
            <span class="info-label">Status:</span>
            <span>{{ ucfirst($filters['status']) }}</span>
        </div>
        @endif
        @if($filters['date_from'])
        <div class="info-row">
            <span class="info-label">Dari Tanggal:</span>
            <span>{{ \Carbon\Carbon::parse($filters['date_from'])->format('d F Y') }}</span>
        </div>
        @endif
        @if($filters['date_to'])
        <div class="info-row">
            <span class="info-label">Sampai Tanggal:</span>
            <span>{{ \Carbon\Carbon::parse($filters['date_to'])->format('d F Y') }}</span>
        </div>
        @endif
    </div>

    <div class="stats-grid">
        <div class="stats-row">
            <div class="stats-cell">
                <div class="number">{{ $stats['total'] }}</div>
                <div class="label">Total</div>
            </div>
            <div class="stats-cell">
                <div class="number">{{ $stats['pending'] }}</div>
                <div class="label">Menunggu</div>
            </div>
            <div class="stats-cell">
                <div class="number">{{ $stats['accepted'] }}</div>
                <div class="label">Diterima</div>
            </div>
            <div class="stats-cell">
                <div class="number">{{ $stats['otw'] }}</div>
                <div class="label">Dalam Perjalanan</div>
            </div>
            <div class="stats-cell">
                <div class="number">{{ $stats['completed'] }}</div>
                <div class="label">Selesai</div>
            </div>
            <div class="stats-cell">
                <div class="number">{{ $stats['cancelled'] }}</div>
                <div class="label">Dibatalkan</div>
            </div>
        </div>
    </div>

    @if($serviceRequests->count() > 0)
    <table>
        <thead>
            <tr>
                <th style="width: 8%;">ID</th>
                <th style="width: 20%;">Pelanggan</th>
                <th style="width: 32%;">Deskripsi Masalah</th>
                <th style="width: 15%;">Lokasi</th>
                <th style="width: 12%;">Status</th>
                <th style="width: 13%;">Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($serviceRequests as $request)
            <tr>
                <td>#{{ $request->id }}</td>
                <td>
                    <strong>{{ $request->user->name }}</strong><br>
                    <span style="font-size: 9px; color: #7f8c8d;">{{ $request->user->email }}</span>
                </td>
                <td>{{ $request->description }}</td>
                <td style="font-size: 9px;">
                    Lat: {{ number_format($request->latitude, 6) }}<br>
                    Long: {{ number_format($request->longitude, 6) }}
                </td>
                <td>
                    @php
                        $statusClass = 'status-' . $request->status->name;
                        $statusLabels = [
                            'pending' => 'Menunggu',
                            'accepted' => 'Diterima',
                            'otw' => 'Dalam Perjalanan',
                            'completed' => 'Selesai',
                            'cancelled' => 'Dibatalkan'
                        ];
                        $statusLabel = $statusLabels[$request->status->name] ?? ucfirst($request->status->name);
                    @endphp
                    <span class="status-badge {{ $statusClass }}">{{ $statusLabel }}</span>
                </td>
                <td>
                    {{ $request->created_at->format('d/m/Y') }}<br>
                    <span style="font-size: 9px; color: #7f8c8d;">{{ $request->created_at->format('H:i') }}</span>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <div class="no-data">
        Tidak ada data permintaan layanan yang sesuai dengan filter.
    </div>
    @endif

    <div class="footer">
        <p>Laporan ini dicetak secara otomatis oleh sistem pada {{ now()->format('d F Y, H:i:s') }}</p>
        <p>&copy; {{ now()->year }} {{ $bengkel->name }}. Semua hak dilindungi.</p>
    </div>
</body>
</html>
