<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContatoFilial extends Model
{
    protected $table = 'contatos_filial';

    protected $fillable = [
        'filial_id', 'nome', 'telefone', 'cargo', 'email'
    ];

    public function filial()
    {
        return $this->belongsTo(Filial::class);
    }
}