<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;   
use Maatwebsite\Excel\Concerns\WithMapping;    
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Support\Collection;

class RelatoriosExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithEvents
{
    protected $demandas;

    public function __construct(Collection $demandas)
    {
        $this->demandas = $demandas;
    }

    public function collection()
    {
        return $this->demandas;
    }

    public function headings(): array
    {
        return [
            'Cliente',
            'Filial',
            'Atendente',
            'Data_agendamento',
            'Status',
            'Solicitante',    
        ];
    }

    public function map($demanda): array
    {
        return [
            $demanda->cliente->nome_cliente ?? 'Não informado',
            $demanda->filial->nome ?? 'Não informado',
            $demanda->atendente ?? 'Não informado',
            $demanda->data_agendamento ? \Carbon\Carbon::parse($demanda->data_agendamento)->format('d/m/Y') : 'Não informado',
            $demanda->status ?? 'Não informado',
            $demanda->solicitante ?? 'Não informado',    
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Cabeçalho
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '1E3A5F']
                ]
            ]
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                // Largura automática das colunas
                foreach (range('A', 'F') as $col) {
                    $event->sheet->getColumnDimension($col)->setAutoSize(true);
                }

                // Bordas em todas as células preenchidas
                $cellRange = 'A1:F' . $event->sheet->getHighestRow();
                $event->sheet->getStyle($cellRange)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['rgb' => '000000']
                        ]
                    ]
                ]);

                // Listras alternadas (zebra)
                for ($row = 2; $row <= $event->sheet->getHighestRow(); $row++) {
                    if ($row % 2 == 0) {
                        $event->sheet->getStyle("A{$row}:F{$row}")
                            ->getFill()
                            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                            ->getStartColor()->setRGB('F9F9F9');
                    }
                }
            }
        ];
    }
}
