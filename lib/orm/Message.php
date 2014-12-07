<?php

namespace orm;

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
//
// public function getJSON();

class Message {
	private $mid;
	private $session;
	private $timestamp;
	private $text;
	private $user;

	public static function create($session, $timestamp, $text, $user) {
		$db = mysqli_connect("classroom.cs.unc.edu", "serust", "CH@ngemenow99Please!serust", "serustdb");
        $querystring = "INSERT INTO a6_Message (session, timestamp, text, user) VALUES ( " .
            "\"" . $db->real_escape_string($session)     . "\", " .
            "\"" . $db->real_escape_string($timestamp)   . "\", " .
            "\"" . $db->real_escape_string($text)        . "\", " .
            "\"" . $db->real_escape_string($user)        . "\")";
		$result = $db->query($querystring);
		if ($result) {
			$mid = $db->insert_id;
			return new Message($mid, $session, $timestamp, $text, $user);
		}
		return null;
	}

	public static function findByID($mid) {
		$db = mysqli_connect("classroom.cs.unc.edu", "serust", "CH@ngemenow99Please!serust", "serustdb");
		$result = $db->query("SELECT * FROM a6_Message WHERE mid = " . $mid);
		if ($result) {
			if ($result->num_rows == 0) {
				return null;
			}
			$row = mysqli_fetch_array($result);
			return new Message(
							intval($row['mid']),
							$row['session'],
							$row['timestamp'],
							$row['text'],
							$row['user']
							);
		}
		return null;
	}


	public static function findBySession($session) {
		$db = mysqli_connect("classroom.cs.unc.edu", "serust", "CH@ngemenow99Please!serust", "serustdb");
		$result = $db->query("SELECT * FROM a6_Message WHERE session = \"" . $session . "\" ORDER BY timestamp");

		$messages = array();
		while ($row = mysqli_fetch_array($result)) {
			$messages[] = new Message(
				intval($row['mid']),
				$row['session'],
				$row['timestamp'],
				$row['text'],
				$row['user']
			);
		}

		return $messages;
	}

	public static function findByUser($user) {
		$db = mysqli_connect("classroom.cs.unc.edu", "serust", "CH@ngemenow99Please!serust", "serustdb");
		$result = $db->query("SELECT * FROM a6_Message WHERE user = \"" . $user . "\" ORDER BY timestamp");

		$messages = array();
		while ($row = mysqli_fetch_array($result)) {
			$messages[] = new Message(
				intval($row['mid']),
				$row['session'],
				$row['timestamp'],
				$row['text'],
				$row['user']
			);
		}

		return $messages;
	}

	private function __construct($mid, $session, $timestamp, $text, $user) {
		$this->mid = $mid;
		$this->session = $session;
		$this->timestamp = $timestamp;
		$this->text = $text;
		$this->user = $user;
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
		$mysqli = new \mysqli("classroom.cs.unc.edu", "serust", "CH@ngemenow99Please!serust", "serustdb");
		$mysqli->query("DELETE FROM a6_Message WHERE mid = " . $this->mid);
	}

	public function getJSON() {
		$json_obj = array(
			'mid' => $this->mid,
			'session' => $this->session,
			'timestamp' => $this->timestamp,
			'text' => $this->text,
			'user' => $this->user
		);
		return json_encode($json_obj);
	}
}
?>
