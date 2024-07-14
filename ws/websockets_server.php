<?php
require 'vendor/autoload.php';

use Predis\Client as RedisClient;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;

class NotificationServer implements MessageComponentInterface
{
    protected $clients;
    protected $redis;

    public function __construct()
    {
        $this->clients = new \SplObjectStorage();
        $this->redis = new RedisClient([
            'scheme' => 'tcp',
            'host'   => 'redis',
            'port'   => 6379,
        ]);
    }

    public function onOpen(ConnectionInterface $conn)
    {
        $this->clients->attach($conn);
        echo "New connection! ({$conn->resourceId})\n";
        
        // Subscribe to the Redis channel
        $this->redis->subscribe(['notifications'], function ($message) use ($conn) {
            $conn->send($message->payload);
        });
    }

    public function onMessage(ConnectionInterface $from, $message)
    {
        $data = json_decode($message, true);
        // Add timestamp and sender ID to the message
        $data['timestamp'] = date('Y-m-d H:i:s');
        $data['sender_id'] = $from->resourceId;
        echo "New message ({$data['message']}) from ({$from->resourceId})\n";
        $data['message'] = htmlspecialchars($data['message'], ENT_QUOTES, 'UTF-8');
       
        $message = json_encode($data);

        // Publish the message to the Redis channel
        $this->redis->publish('notifications', $message);
        
        // Broadcast the modified message to all connected clients
        foreach ($this->clients as $client) {
            $client->send($message);
        }
    }

    public function onClose(ConnectionInterface $conn)
    {
        $this->clients->detach($conn);
        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        echo "An error has occurred: {$e->getMessage()}\n";
        $conn->close();
    }
}

$server = IoServer::factory(
    new HttpServer(
        new WsServer(
            new NotificationServer()
        )
    ),
    8000
);

$server->run();
