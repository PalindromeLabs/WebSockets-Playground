<?php

namespace App\Socket;

use App\Events\Event;
use App\Socket\Broadcast;

abstract class SocketAbstract
{
    protected function broadcast(Event $event)
    {
        return new Broadcast($event, $this->clients);
    }
}
