<?php

namespace App\Exports;

use App\Models\ServiceRequest;
use App\Enum\ServiceRequestStatus;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class ServiceRequestsExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithTitle
{
    protected $filters;

    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $query = ServiceRequest::with(['user', 'bengkel']);

        // Apply filters
        if (!empty($this->filters['status']) && $this->filters['status'] !== 'all') {
            $query->where('status', ServiceRequestStatus::from($this->filters['status']));
        }

        if (!empty($this->filters['bengkel_id'])) {
            $query->where('bengkel_id', $this->filters['bengkel_id']);
        }

        if (!empty($this->filters['date_from'])) {
            $query->whereDate('created_at', '>=', $this->filters['date_from']);
        }

        if (!empty($this->filters['date_to'])) {
            $query->whereDate('created_at', '<=', $this->filters['date_to']);
        }

        if (!empty($this->filters['year'])) {
            $query->whereYear('created_at', $this->filters['year']);
        }

        return $query->latest()->get();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'ID',
            'Pelanggan',
            'Email',
            'Bengkel',
            'Deskripsi Masalah',
            'Latitude',
            'Longitude',
            'Status',
            'Tanggal Dibuat',
            'Waktu',
        ];
    }

    /**
     * @param ServiceRequest $serviceRequest
     */
    public function map($serviceRequest): array
    {
        $statusLabels = [
            'pending' => 'Menunggu',
            'accepted' => 'Diterima',
            'otw' => 'Dalam Perjalanan',
            'completed' => 'Selesai',
            'cancelled' => 'Dibatalkan',
        ];

        return [
            $serviceRequest->id,
            $serviceRequest->user->name,
            $serviceRequest->user->email,
            $serviceRequest->bengkel->name,
            $serviceRequest->description,
            $serviceRequest->latitude,
            $serviceRequest->longitude,
            $statusLabels[$serviceRequest->status->name] ?? ucfirst($serviceRequest->status->name),
            $serviceRequest->created_at->format('d/m/Y'),
            $serviceRequest->created_at->format('H:i:s'),
        ];
    }

    /**
     * @param Worksheet $sheet
     */
    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text
            1 => [
                'font' => ['bold' => true, 'size' => 12],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '2c3e50']
                ],
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
            ],
        ];
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Laporan Darurat';
    }
}
