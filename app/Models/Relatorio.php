<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Relatorio extends Model
{
    protected $table = 'relatorios';

    protected $fillable = [
        'tecnico_responsavel',
        'empresa_visitada',
        'solicitante',
        'data_visita',
        'horario_visita',
        'equipamento_atendido',
        'descricao_ocorrencia',
        'procedimentos_realizados',
        'resultado',
        'conclusao',
        'demanda_id',
    ];

    // Se tiver relação com a demanda:
    public function demanda()
    {
        return $this->belongsTo(Demanda::class);
    }
}
