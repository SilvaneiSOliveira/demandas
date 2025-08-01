<?php

// Cliente.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $table = 'clientes';

    protected $fillable = [
        'cliente_id',
        'razao_social',
        'cnpj',
        'endereco',
        'bairro',
        'cidade',
        'estado',
        'produto',
        'contato_nome',
        'contato_cargo',
        'contato_telefone',
    ];

    // Relacionamento com produtos
    public function produtos()
    {
        return $this->hasMany(Produto::class);
    }

    // Relacionamento com contatos
    public function contatos()
    {
        return $this->hasMany(Contato::class);
    }

        public function filial()
    {
        return $this->hasMany(Filial::class);
    }

}