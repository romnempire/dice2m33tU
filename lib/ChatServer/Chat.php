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
        } else if ($msgobj->cmdType == 'toylock') {
            $this->processInboundToyLock($from, $msgobj, $msg);
        } else if ($msgobj->cmdType == 'toymove') {
            $this->processInboundToyMove($from, $msgobj, $msg);
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

    public function rollDice(ConnectionInterface $conn, $msgobj) {
        echo "diceroll \n";
        //generate randoms
        $rolls = [];
        for($i = 0;($i < $msgobj->quantity);$i++) {
            $rolls[] = rand(1,$msgobj->type);
        }

        $message = "$msgobj->type: " . implode(" ", $rolls);

        //create and send outbound diceroll
        $data = array(
            "cmdType" => "message",
            "text" => $message,
            "user" => $msgobj->user,
            "session" => $msgobj->session
        );

        //such inefficient
        $this->processInboundMessage($conn, json_decode(json_encode($data)));
    }

    public function processInboundToy($from, $msgobj, $msg) {
        echo "new toy! \n";

        //post to database
        //IF THE PIECE IS THERE GET IT INSTEAD OF CREATING IT
        $toy = \orm\Toy::create($msgobj->url, $msgobj->session, 0, 0, 0, 10, 100);

        //create and send outbound toy
        //you don't actually use this because it literally recreates your input
        //it just tests the orm
        $data = array(
            "cmdType" => "newtoy",
            "user" => $msgobj->user,
            "session" => $toy->getSession(),
            "url" => $toy->getURL(),
            "tid" => $toy->getID()
        );

        foreach ($this->clients as $client) {
            $client->send(json_encode($data));
        }
    }

    public function processInboundToyLock($from, $msgobj, $msg) {
        echo "toy lock \n";

        $toy = \orm\Toy::findByID($msgobj->tid);

        //create and send outbound toy move
        //you don't actually use this because it literally recreates your input
        //it just tests the orm
        $data = array(
            "cmdType" => "toylock",
            "user" => $msgobj->user,
            "session" => $toy->getSession(),
            "tid" => $toy->getID()
        );

        foreach ($this->clients as $client) {
            if ($from !== $client) {
                $client->send($msg);
            }
        }
    }

    public function processInboundToyMove($from, $msgobj, $msg) {
        echo "toy move \n";
        //edit in database

        $toy = \orm\Toy::findByID($msgobj->tid);

        //create and send outbound toy move
        $data = array(
            "cmdType" => "toymove",
            "user" => $msgobj->user,
            "session" => $toy->getSession(),
            "tid" => $toy->getID(),
            "top" => $toy->getLocation()[1],
            "left" => $toy->getLocation()[0]
        );

        foreach ($this->clients as $client) {
            $client->send($msg);
        }
    }
}
