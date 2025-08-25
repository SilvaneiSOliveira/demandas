<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class computador extends Model
{
    protected $table = 'computadores';
   protected $fillable = [
    'cliente_id',
    'filial_id',
    'tag',
    'local',
    'processador',
    'memoria_ram',
    'armazenamento',
    'sistema_operacional',
    'observacao',
    'usuario_alteracao',
    'ultima_alteracao',
   ];

   public function cliente()
   {
    return $this->belongsTo(Cliente::Class);
   }

   public function filial()
   {
    return $this->belongsTo(Filial::Class);
   }
}
