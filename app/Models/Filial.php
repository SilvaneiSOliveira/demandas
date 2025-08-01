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
        'estado'
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function filial()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function contatos()
    {
        return $this->hasMany(Contato::class);
    }
    public function demandas()
    {
        return $this->hasMany(Demanda::class);
    }

}
