<?php
namespace ChatServer;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
require 'lib/orm/Message.php';

class Chat implements MessageComponentInterface {
    protected $clients;

    public function __construct() {
        $this->clients = new \SplObjectStorage;
    }

    public function onOpen(ConnectionInterface $conn) {
        // Store the new connection to send messages to later
        $this->clients->attach($conn);

        echo "New connection! ({$conn->resourceId})\n";

        // $this->dumpChatBacklog($conn);
        $this->newDumpChatBacklog($conn);
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

    public function onClose(ConnectionInterface $conn) {
        // The connection is closed, remove it, as we can no longer send it messages
        $this->clients->detach($conn);

        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "An error has occurred: {$e->getMessage()}\n";

        $conn->close();
    }

    public function dumpChatBacklog(ConnectionInterface $conn) {
        $dbhost = 'classroom.cs.unc.edu';
        $dbuser = 'serust';
        $dbpass = 'CH@ngemenow99Please!serust';
        $dbname = 'serustdb';
        $dbconn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die ('Error connecting to mysql');
        echo "connected to db \n";

        $query = "SELECT timestamp, text, user FROM a6_Message WHERE a6_Message.session = \"pets\"";
//        $insertquery = "INSERT INTO a6_Message(mid, Session, Timestamp, Text, User)".
//            " VALUES(1,\"pets\", \"1000-01-01 00:00:00\", \"doge goes woofe\", \"DOGE\")";
        $result = $dbconn->query($query) or die("Error in the consult.." . mysqli_error($dbconn));
        while($row = mysqli_fetch_array($result)) {
            $data = array("cmdType" => "message",
                          "timestamp" => $row["timestamp"],
                          "text" => $row["text"],
                          "user" => $row["user"]);
            $conn->send(json_encode($data));
            //echo $row["text"] . "<br>";
        }

    }

    public function newDumpChatBacklog(ConnectionInterface $conn) {
      $messages = Message::findBySession("pets");

      foreach($messsages as $message) {
        $data = array("cmdType" => "message",
                      "timestamp" => $message.timestamp,
                      "text" => $message.text,
                      "user" => $message.user);
        $conn->send(json_encode($data));
      }
    }
}