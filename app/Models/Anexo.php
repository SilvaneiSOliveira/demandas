<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anexo extends Model
{
    use HasFactory;

    protected $fillable = [
        'demanda_id',
        'nome_arquivo',
        'caminho',
    ];

    public function demanda()
    {
        return $this->belongsTo(Demanda::class);
    }
}
