<?php

namespace App\Socket;

use App\Events\Event;
use Ratchet\ConnectionInterface;

class Broadcast
{
    protected $event;

    protected $clients;

    public function __construct(Event $event, array $clients)
    {
        $this->event = $event;
        $this->clients = $clients;
    }

    public function toAll()
    {
        foreach ($this->clients as $client) {
            $client->send($this->event);
        }
    }

    public function to(ConnectionInterface $client)
    {
        $client->send($this->event);
    }

    public function toAllExcept(ConnectionInterface $clientToExclude)
    {
        foreach ($this->clients as $client) {
            if ($client !== $clientToExclude) {
                $client->send($this->event);
            }
        }
    }
}