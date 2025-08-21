<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

// Exemplo: canal público
Broadcast::channel('notificacoes', function () {
    return true;
});

// Exemplo: canal privado
Broadcast::channel('demanda.{id}', function ($user, $id) {
    return $user->id === (int) $id;
});

