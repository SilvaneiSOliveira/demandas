<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    use HasFactory;

    protected $table = 'produtos';

    protected $fillable = [
        'cliente_id', // chave estrangeira
        'nome',
        'descricao',
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }
}
