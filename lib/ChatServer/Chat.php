<?php
namespace ChatServer;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
require_once 'lib/orm/Message.php';
require_once 'lib/orm/Toy.php';

class Chat implements MessageComponentInterface {
    protected $clients;

    public function __construct() {
        $this->clients = new \SplObjectStorage;
    }

    public function onOpen(ConnectionInterface $conn) {
        // Store the new connection to send messages to later
        $this->clients->attach($conn);

        echo "New connection! ({$conn->resourceId})\n";
    }

    public function onMessage(ConnectionInterface $from, $msg) {

        $msgobj = json_decode($msg);

        if ($msgobj->cmdType == 'message') {
            $this->processInboundMessage($from, $msgobj);
        } else if ($msgobj->cmdType == 'backlog') {
            $this->dumpChatBacklog($from, $msgobj);
        } else if ($msgobj->cmdType == 'diceroll') {
            $this->rollDice($from, $msgobj);
        } else if ($msgobj->cmdType == 'newtoy') {
            $this->processInboundToy($from, $msgobj, $msg);
        } else if ($msgobj->cmdType == 'toymove') {
            $this->processInboundToyMove($from, $msgobj);
        }
    }

    public function onClose(ConnectionInterface $conn) {
        // The connection is closed, remove it, as we can no longer send it messages
        $this->clients->detach($conn);

        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "An error has occurred: {$e->getMessage()}\n";

        $conn->close();
    }

    public function processInboundMessage(ConnectionInterface $conn, $msg) {
        $date = new \DateTime();
        $PHPMessage = \orm\Message::create($msg->session, $date->getTimestamp(), $msg->text, $msg->user);

        $data = array(
            "cmdType" => "message",
            "timestamp" => $PHPMessage->getTimestamp(),
            "text" => $PHPMessage->getText(),
            "user" => $PHPMessage->getUser()
        );

        $numRecv = count($this->clients) - 1;

        foreach ($this->clients as $client) {
            $client->send(json_encode($data));
        }
    }

	public function dumpChatBacklog(ConnectionInterface $conn, $msgobj) {
		$session = $msgobj->session;
		$messages = \orm\Message::findBySession($session);
    	for ($index = 0; $index < sizeof($messages); $index++) {
      		$data = array(
       			"cmdType" => "message",
        		"timestamp" => $messages[$index]->getTimestamp(),
        		"text" => $messages[$index]->getText(),
        		"user" => $messages[$index]->getUser()
      		);
      		$conn->send(json_encode($data));
    	}
  	}

    //not finished
    public function rollDice(ConnectionInterface $conn, $msg) {
        echo "diceroll \n";
        //generate randoms

        //post to database

        //create and send outbound diceroll
        $data = array(
            "cmdType" => "message",
            "timestamp" => $PHPMessage->getTimestamp(),
            "text" => $PHPMessage->getText(),
            "user" => $PHPMessage->getUser()
        );

        foreach ($this->clients as $client) {
            $client->send(json_encode($data));
        }
    }

    public function processInboundToy($from, $msgobj, $msg) {
        echo "new toy! \n";

        //post to database
        //IF THE PIECE IS THERE GET IT INSTEAD OF CREATING IT
        $toy = \orm\Toy::create($msgobj->url, $msgobj->session, 0, 0, 0, 10, 100);

        //create and send outbound toy
        //you don't actually use this because it literally recreates your input
        $data = array(
            "cmdType" => "newtoy",
            "user" => $msgobj->user,
            "session" => $toy->getSession(),
            "url" => $toy->getURL()
        );

        foreach ($this->clients as $client) {
            $client->send($msg);
        }
    }

    //not finished
    public function processInboundToyLock($from, $msgobj) {
        echo "toy lock \n";

        //create and send outbound toy move
        $data = array(
            "cmdType" => "toylock",
            "url" => $toy->getURL()
        );

        foreach ($this->clients as $client) {
            if ($from !== $client) {
                $client->send(json_encode($data));
            }
        }
    }

    //not finished
    public function processInboundToyMove($from, $msgobj) {
        echo "toy move \n";
        //edit in database

        //create and send outbound toy move
        $data = array(
            "cmdType" => "toymove"
        );

        foreach ($this->clients as $client) {
            $client->send(json_encode($data));
        }
    }
}
