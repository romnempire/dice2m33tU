<?php

// Message Interface
//
// if the row can be inserted, then create returns a Message object
// public static function create($mid, $session, $timestamp, $text, $user);
//
// if id exists, findByID returns the Message object
// public static function findByID($mid);
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
// public function setTimestamp($time);
//
// public function setText($text);
//
// update is called inside setters
// public function update();
//
// public function delete();

class Message {
	private $mid;
	private $session;
	private $timestamp;
	private $text;
	private $user;
	
	public static function create($mid, $session, $timestamp, $text, $user) {
		$mysqli = new mysqli("classroom.cs.unc.edu", "serust", "CH@ngemenow99Please!serust", "serustdb");
		$result = $mysqli->query("INSERT INTO a6_Message VALUES ( 
			"   . $mid . ", " .
			"'" . $mysqli->real_escape_string($session) . "', " . 
			"'" . $mysqli->real_escape_string($timestamp) . "', " .
			"'" . $locationX . ", " .
			"'" . $locationY . "', " .
			"'" . $sizeX . "', " .
			"'" . $sizeY . "')"
			);
		if ($result) {
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
			return new Message($info['mid']),
							 $info['session'],
							 $info['timestamp'],
							 $info['text'],
							 $info['user'],
							 );
		}
		return null;
	}
	
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
		
	public function setTimestamp($time) {
		$this->timestamp = $time;
		
		return $this->update();
	}
	
	public function setText($text) {
		 $this->text = $text;
		 
		 return $this->update();
	}
	
	public function update() {
		$mysqli = new mysqli("classroom.cs.unc.edu", "serust", "CH@ngemenow99Please!serust", "serustdb");
		$result = $mysqli->query("UPDATE a6_Message SET timestamp = ". $this->timestamp . ", text = " . $this->text . " WHERE mid = " . $this->mid);
		return $result;
	}
	
	public function delete() {
		$mysqli = new mysqli("classroom.cs.unc.edu", "serust", "CH@ngemenow99Please!serust", "serustdb");
		$mysqli->query("DELETE FROM a6_Message WHERE mid = " . $this->mid);
	}
}
?>