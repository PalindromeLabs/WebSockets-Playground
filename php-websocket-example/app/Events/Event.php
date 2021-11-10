<?php

namespace App\Events;

abstract class Event
{
    abstract public function eventName();

    abstract public function data();

    public function __toString()
    {
        return json_encode([
            'event' => $this->eventName(),
            'data' => $this->data(),
        ]);
    }
}
