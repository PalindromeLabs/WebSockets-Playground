<?php

namespace App\Events;

use App\Events\Event;

class Message extends Event
{
    protected $user;

    protected $message;

    public function __construct($user, $message)
    {
        $this->user = $user;
        $this->message = $message;
    }

    public function eventName()
    {
        return 'message';
    }

    public function data()
    {
        $payload = $this->message;
        $payload->user = $this->user;

        return $payload;
    }
}
