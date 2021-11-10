<?php

namespace App\Events;

use App\Events\Event;

class UserJoined extends Event
{
    protected $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function eventName()
    {
        return 'joined';
    }

    public function data()
    {
        return [
            'user' => $this->user
        ];
    }
}
