<?php

namespace App\Console\Commands;

use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use Illuminate\Console\Command;

class WebSocketServer implements MessageComponentInterface {

    public function handle(LoopInterface $loop) {
        $server = IoServer::factory(
            new HttpServer(
                new WsServer(
                    new WebSocketServer()
                )
            ),
            8080 // Customize port if needed
        );
    
        $server->run();
    }
    protected $clients;

    public function __construct() {
        $this->clients = new \SplObjectStorage;
    }

    // ...Implement the following methods...

    public function onOpen(ConnectionInterface $conn) {
        // Add client to storage when connected
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        // Process data and broadcast to clients
    }

    public function onClose(ConnectionInterface $conn) {
        //  Remove client from storage when disconnected
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        // Handle errors
    }
}
