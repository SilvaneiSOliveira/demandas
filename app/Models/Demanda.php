<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Demanda extends Model
{
    protected $fillable = [
    'cliente_id',
    'filial_id',
    'titulo',
    'descricao',
    'nivel',
    'classificacao',
    'data_agendamento',
    'atendente',
    'status',
    'solicitante',
    'resolucao',
    'created_at',
    ];

    public function cliente()
    {
         return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    public function filial()
    {
        return $this->belongsTo(Filial::class);
    }

    public function atendente()
    {
        return $this->belongsTo(Atendente::class);
    }

    public function anexos()
    {
        return $this->hasMany(Anexo::class);
    }

}
