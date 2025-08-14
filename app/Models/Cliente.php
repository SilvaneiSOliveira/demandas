<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $table = 'clientes';

    protected $fillable = [
        'nome_cliente',
        'razao_social',
        'cnpj',
        'endereco',
        'bairro',
        'cidade',
        'estado',
        'produto',
        'tipo_suporte',
    ];

    // Relacionamento com produtos
    public function produtos()
    {
        return $this->hasMany(Produto::class);
    }

    // Relacionamento com contatos
    public function contatos()
{
    return $this->hasMany(Contato::class, 'cliente_id', 'id');
}
    
    // Relacionamento com filial
        public function filial()
    {
        return $this->hasMany(Filial::class);
    }

}