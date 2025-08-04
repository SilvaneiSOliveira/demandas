<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Preventiva extends Model
{
    use HasFactory;

    protected $table = 'preventivas';

    protected $fillable = [
        'cliente',
        'filial',
        'status',
        'observacoes',
        'data',
        'ultima_alteracao',
        'usuario_alteracao',
    ];

    protected $dates = [
        'data',
        'created_at',
        'updated_at',
    ];


    public function filiais($cliente)
    {
        $preventivas = Preventiva::where('cliente', $cliente)->get();
        return view('partials.tabela_preventiva', compact('preventivas'));
    }
    
}

