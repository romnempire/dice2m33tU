<?php

// Message Interface
//
// if the row can be inserted, then create returns a Message object
// public static function create($mid, $session, $timestamp, $text, $user);
//
// if id exists, findByID returns the Message object
// public static function findByID($mid);
//
// findBySession returns an array
// public static function findBySession($session);
//
// findByUser returns an array
// public static function findByUser($user);
//
// private constructor, called when row can be inserted
// private function __construct($mid, $session, $timestamp, $text, $user);
//
// public function getID();
//
// public function getSession();
//
// public function getTimestamp();
//
// public function getText();
//
// public function getUser();
//
// public function delete();

class Message {
	private $mid;
	private $session;
	private $timestamp;
	private $text;
	private $user;

	public static function create($session, $timestamp, $text, $user) {
		$mysqli = new mysqli("classroom.cs.unc.edu", "serust", "CH@ngemenow99Please!serust", "serustdb");
		$result = $mysqli->query("INSERT INTO a6_Message (session, timestamp, text, user) VALUES ( " .
			"'" . $mysqli->real_escape_string($session) 	. "', " .
			"'" . $mysqli->real_escape_string($timestamp) 	. "', " .
			"'" . $mysqli->real_escape_string($text) 		. "', " .
			"'" . $mysqli->real_escape_string($user) 		. "'"
			);
		if ($result) {
			$mid = $mysqli->insert_id;
			return new Message($mid, $session, $timestamp, $text, $user);
		}
		return null;
	}

	public static function findByID($mid) {
		$mysqli = new mysqli("classroom.cs.unc.edu", "serust", "CH@ngemenow99Please!serust", "serustdb");
		$result = $mysqli->query("SELECT * FROM a6_Message WHERE mid = " . $mid);
		if ($result) {
			if ($result->num_rows == 0) {
				return null;
			}
			$info = $result->fetch_array();
			return new Message($info['mid'],
							 $info['session'],
							 $info['timestamp'],
							 $info['text'],
							 $info['user']
							 );
		}
		return null;
	}

	public static function findBySession($session) {
		$mysqli = new mysqli("classroom.cs.unc.edu", "serust", "CH@ngemenow99Please!serust", "serustdb");
		$result = $mysqli->query("SELECT * FROM a6_Message WHERE session = " . $session . "ORDER BY timestamp");

		$all = $result->fetch_all();
		$messages = array();
		for ($index = 0; $index < sizeof($all); $index++) {
			$messages[$index] = new User($all[$index]['mid'],$all[$index]['session'],$all[$index]['timestamp'], $all[$index]['text'],$all[$index]['user']);
		}

		return $messages;
	}

    // not valid php

	// public static function findByUser($user) {
	// 	$mysqli = new mysqli("classroom.cs.unc.edu", "serust", "CH@ngemenow99Please!serust", "serustdb");
	// 	$result = $mysqli->query("SELECT * FROM a6_Message WHERE user = " . $user . "ORDER BY timestamp");

	// 	$all = $result->fetch_all([ int $resulttype = MYSQLI_NUM ]);
	// 	$messages = array();
	// 	for ($index = 0; $index < sizeof($all); $index++) {
	// 		$messages[$index] = new User($all[$index]['mid'],$all[$index]['session'],$all[$index]['timestamp'], $all[$index]['text'],$all[$index]['user']);
	// 	}

	// 	return $messages;
	// }

	private function __construct($mid, $session, $timestamp, $text, $user) {
		$this->name = $mid;
		$this->session = $session;
		$this->locationX = $timestamp;
		$this->locationY = $text;
		$this->sizeX = $user;
	}

	public function getID() {
		return $this->mid;
	}

	public function getSession() {
		return $this->session;
	}

	public function getTimestamp() {
		return $this->timestamp;
	}

	public function getText() {
		return $this->text;
	}

	public function getUser() {
		return $this->user;
	}

	public function delete() {
		$mysqli = new mysqli("classroom.cs.unc.edu", "serust", "CH@ngemenow99Please!serust", "serustdb");
		$mysqli->query("DELETE FROM a6_Message WHERE mid = " . $this->mid);
	}
}
?>
