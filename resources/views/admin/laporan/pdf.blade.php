<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Darurat - Permintaan Layanan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            line-height: 1.6;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #2c3e50;
            padding-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            font-size: 26px;
            color: #2c3e50;
            text-transform: uppercase;
        }
        .header h2 {
            margin: 5px 0;
            font-size: 16px;
            color: #7f8c8d;
            font-weight: normal;
        }
        .info-section {
            margin-bottom: 20px;
            background: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            border-left: 4px solid #2c3e50;
        }
        .info-section h3 {
            margin: 0 0 10px 0;
            font-size: 14px;
            color: #2c3e50;
            font-weight: bold;
        }
        .info-row {
            margin: 5px 0;
        }
        .info-label {
            font-weight: bold;
            display: inline-block;
            width: 130px;
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
            padding: 12px;
            text-align: center;
            border: 2px solid #dee2e6;
        }
        .stats-cell.total { background: #17a2b8; color: white; }
        .stats-cell.pending { background: #ffc107; color: #000; }
        .stats-cell.accepted { background: #17a2b8; color: white; }
        .stats-cell.otw { background: #007bff; color: white; }
        .stats-cell.completed { background: #28a745; color: white; }
        .stats-cell.cancelled { background: #6c757d; color: white; }
        .stats-cell .number {
            font-size: 28px;
            font-weight: bold;
            margin: 5px 0;
        }
        .stats-cell .label {
            font-size: 10px;
            text-transform: uppercase;
            font-weight: bold;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th {
            background-color: #2c3e50;
            color: white;
            padding: 10px 6px;
            text-align: left;
            font-weight: bold;
            font-size: 10px;
            text-transform: uppercase;
            border: 1px solid #1a252f;
        }
        td {
            padding: 8px 6px;
            border: 1px solid #dee2e6;
            font-size: 10px;
            vertical-align: top;
        }
        tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        .status-badge {
            display: inline-block;
            padding: 3px 6px;
            border-radius: 3px;
            font-size: 9px;
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
            padding-top: 15px;
            border-top: 2px solid #dee2e6;
            text-align: center;
            font-size: 9px;
            color: #7f8c8d;
        }
        .no-data {
            text-align: center;
            padding: 40px;
            color: #7f8c8d;
            font-style: italic;
        }
        .customer-name {
            font-weight: bold;
            color: #2c3e50;
        }
        .bengkel-name {
            font-weight: bold;
            color: #2c3e50;
        }
        .text-muted {
            color: #7f8c8d;
            font-size: 9px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Laporan Darurat</h1>
        <h2>Sistem Permintaan Layanan Kendaraan</h2>
    </div>

    <div class="info-section">
        <h3>Informasi Laporan</h3>
        <div class="info-row">
            <span class="info-label">Tanggal Cetak:</span>
            <span>{{ now()->format('d F Y, H:i:s') }}</span>
        </div>
        @if($filters['status'] && $filters['status'] !== 'all')
        <div class="info-row">
            <span class="info-label">Filter Status:</span>
            <span>
                @php
                    $statusLabels = [
                        'pending' => 'Menunggu',
                        'accepted' => 'Diterima',
                        'otw' => 'Dalam Perjalanan',
                        'completed' => 'Selesai',
                        'cancelled' => 'Dibatalkan'
                    ];
                    echo $statusLabels[$filters['status']] ?? ucfirst($filters['status']);
                @endphp
            </span>
        </div>
        @endif
        @if($filters['bengkel_id'])
        <div class="info-row">
            <span class="info-label">Filter Bengkel:</span>
            <span>{{ \App\Models\Bengkel::find($filters['bengkel_id'])->name ?? 'N/A' }}</span>
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
        @if($filters['year'])
        <div class="info-row">
            <span class="info-label">Tahun:</span>
            <span>{{ \Carbon\Carbon::parse($filters['year'])->format('Y') }}</span>
        </div>
        @endif
    </div>

    <div class="stats-grid">
        <div class="stats-row">
            <div class="stats-cell total">
                <div class="number">{{ $stats['total'] }}</div>
                <div class="label">Total</div>
            </div>
            <div class="stats-cell pending">
                <div class="number">{{ $stats['pending'] }}</div>
                <div class="label">Menunggu</div>
            </div>
            <div class="stats-cell accepted">
                <div class="number">{{ $stats['accepted'] }}</div>
                <div class="label">Diterima</div>
            </div>
            <div class="stats-cell otw">
                <div class="number">{{ $stats['otw'] }}</div>
                <div class="label">Perjalanan</div>
            </div>
            <div class="stats-cell completed">
                <div class="number">{{ $stats['completed'] }}</div>
                <div class="label">Selesai</div>
            </div>
            <div class="stats-cell cancelled">
                <div class="number">{{ $stats['cancelled'] }}</div>
                <div class="label">Dibatalkan</div>
            </div>
        </div>
    </div>

    @if($serviceRequests->count() > 0)
    <table>
        <thead>
            <tr>
                <th style="width: 5%;">ID</th>
                <th style="width: 15%;">Pelanggan</th>
                <th style="width: 15%;">Bengkel</th>
                <th style="width: 30%;">Deskripsi</th>
                <th style="width: 13%;">Lokasi</th>
                <th style="width: 10%;">Status</th>
                <th style="width: 12%;">Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($serviceRequests as $request)
            <tr>
                <td style="text-align: center; font-weight: bold;">#{{ $request->id }}</td>
                <td>
                    <span class="customer-name">{{ $request->user->name }}</span><br>
                    <span class="text-muted">{{ $request->user->email }}</span>
                </td>
                <td>
                    <span class="bengkel-name">{{ $request->bengkel->name }}</span><br>
                    <span class="text-muted">{{ $request->bengkel->phone }}</span>
                </td>
                <td>{{ $request->description }}</td>
                <td style="font-size: 9px;">
                    Lat: {{ number_format($request->latitude, 5) }}<br>
                    Long: {{ number_format($request->longitude, 5) }}
                </td>
                <td style="text-align: center;">
                    @php
                        $statusClass = 'status-' . $request->status->name;
                        $statusLabels = [
                            'pending' => 'Menunggu',
                            'accepted' => 'Diterima',
                            'otw' => 'Perjalanan',
                            'completed' => 'Selesai',
                            'cancelled' => 'Batal'
                        ];
                        $statusLabel = $statusLabels[$request->status->name] ?? ucfirst($request->status->name);
                    @endphp
                    <span class="status-badge {{ $statusClass }}">{{ $statusLabel }}</span>
                </td>
                <td style="text-align: center;">
                    {{ $request->created_at->format('d/m/Y') }}<br>
                    <span class="text-muted">{{ $request->created_at->format('H:i') }}</span>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div style="margin-top: 20px; font-size: 10px;">
        <strong>Total Data: {{ $serviceRequests->count() }} permintaan</strong>
    </div>
    @else
    <div class="no-data">
        Tidak ada data permintaan layanan yang sesuai dengan filter.
    </div>
    @endif

    <div class="footer">
        <p><strong>Laporan Darurat - Sistem Layanan Kendaraan</strong></p>
        <p>Dokumen ini dicetak secara otomatis pada {{ now()->format('d F Y, H:i:s') }}</p>
        <p>&copy; {{ now()->year }} Layanan Darurat Kendaraan. Semua hak dilindungi.</p>
    </div>
</body>
</html>
