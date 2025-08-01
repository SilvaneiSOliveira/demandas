<?php

namespace App\Events;

use App\Models\Demanda;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DemandaAtualizada implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $demanda;

    /**
     * Cria uma nova instância do evento.
     */
    public function __construct(Demanda $demanda)
    {
        $this->demanda = $demanda;
    }

    /**
     * Canal que será usado pra transmitir o evento.
     */
    public function broadcastOn()
    {
        return new Channel('dashboard-channel'); // canal público
    }

    /**
     * Nome do evento que será escutado no front.
     */
    public function broadcastAs()
    {
        return 'demanda.atualizada';
    }
}
