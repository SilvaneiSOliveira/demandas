<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;   
use Maatwebsite\Excel\Concerns\WithMapping;    
use Illuminate\Support\Collection;

class RelatoriosExport implements FromCollection, WithHeadings, WithMapping
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
            'Atendente',
            'Criado em',
            'Solicitante',
            'Data de agendamento',
            'Resolucao',
            
        ];
    }

    public function map($demanda): array
    {
        return [
            $demanda->cliente->nome ?? 'Não informado',
            $demanda->atendente->nome ?? 'Não informado',
            $demanda->criado_em ? \Carbon\Carbon::parse($demanda->data_visita)->format('d/m/Y') : 'Não informado',
            $demanda->solicitante ?? 'Não informado',
            $demanda->data_agendamento ?? 'Não informado',
            $demanda->resolucao ?? 'Não informado', 
        ];
    }

}


