<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Contato extends Model
{
    protected $table = 'contatos'; // Adicione esta linha
    
    protected $fillable = [
        'nome',
        'cargo',
        'telefone',
        'email',
        'cliente_id'
    ];

    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class);
    }
}
