<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Filial extends Model
{
    use HasFactory;

    protected $table = 'filiais';

    protected $fillable = [
        'cliente_id',
        'nome',
        'cnpj',
        'endereco',
        'razao_social',
        'bairro',
        'cidade',
        'estado',
        'produto',
        'tipo_suporte',
        'ativo',
    ];

    // Cast para arrays JSON
    protected $casts = [
        'tipo_suporte' => 'array',
        'produto' => 'array',
        'ativo' => 'boolean',
    ];


    // Relacionamento com Cliente
    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id'); 
    }

    // Relacionamento com filial
    public function filial()
    {
        return $this->belongsTo(Cliente::class);
    }

    // Relacionamento com Contatos
    public function contatos_filial()
    {
        return $this->hasMany(ContatoFilial::class, 'filial_id');
    }
    
    // Relacionamento com Demandas
    public function demandas()
    {
        return $this->hasMany(Demanda::class);
    }

}
