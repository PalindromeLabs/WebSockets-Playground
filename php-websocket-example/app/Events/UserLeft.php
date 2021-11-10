<?php

namespace App\Events;

use App\Events\Event;

class UserLeft extends Event
{
    protected $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function eventName()
    {
        return 'left';
    }

    public function data()
    {
        return [
            'user' => $this->user
        ];
    }
}
