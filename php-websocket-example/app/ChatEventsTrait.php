<?php

namespace App;

use App\Events\Message;
use App\Events\UserJoined;
use App\Events\Users;
use Ratchet\ConnectionInterface;

trait ChatEventsTrait
{
    protected function handleMessage(ConnectionInterface $connection, $payload)
    {
        $user = $this->users[$connection->resourceId];
        $message = $payload->data;

        $this->broadcast(new Message($user, $message))->toAllExcept($connection);
    }

    protected function handleJoined(ConnectionInterface $connection, $payload)
    {
        $user = $payload->data->user;
        $this->users[$connection->resourceId] = $user;

        $this->broadcast(new Users($this->users))->to($connection);
        $this->broadcast(new UserJoined($user))->toAllExcept($connection);
    }
}
