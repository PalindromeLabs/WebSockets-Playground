<?php

namespace App\Events;

use App\Events\Event;

class Users extends Event
{
    protected $users;

    public function __construct($users)
    {
        $this->users = $users;
    }

    public function eventName()
    {
        return 'users';
    }

    public function data()
    {
        return array_values($this->users);
    }
}
