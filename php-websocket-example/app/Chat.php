<?php

namespace App;

use App\ChatEventsTrait;
use App\Events\UserLeft;
use App\Socket\SocketAbstract;
use Exception;
use Ratchet\ConnectionInterface;
use Ratchet\MessageComponentInterface;

class Chat extends SocketAbstract implements MessageComponentInterface
{
    use ChatEventsTrait;

    protected $clients;

    protected $users;

    public function onOpen(ConnectionInterface $connection)
    {
        $this->clients[$connection->resourceId] = $connection;
        echo "New connection! ({$conn->resourceId})\n";
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        $numRecv = count($this->clients) - 1;
        echo sprintf('Connection %d sending message "%s" to %d other connection%s' . "\n"
            , $from->resourceId, $msg, $numRecv, $numRecv == 1 ? '' : 's');

        foreach ($this->clients as $client) {
            if ($from !== $client) {
                // The sender is not the receiver, send to each client connected
                $client->send($msg);
            }
        }
    }

    public function onClose(ConnectionInterface $connection)
    {
        if (!isset($this->users[$connection->resourceId])) {
            return;
        }

        $user = $this->users[$connection->resourceId];

        $this->broadcast(new UserLeft($user))->toAll();
        echo "Connection {$connection->resourceId} has disconnected\n";
        unset($this->clients[$connection->resourceId], $this->users[$connection->resourceId]);
    }

    public function onError(ConnectionInterface $connection, Exception $e)
    {
        $connection->close();
    }
}
