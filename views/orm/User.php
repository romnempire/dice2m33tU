<?php

// User Interface
//
// if the row can be inserted, then create returns a User object
// public static function create($name, $session);
//
// if name exists, findByName returns the User object
// public static function findByName($name);
//
// private constructor, called when row can be inserted
// private function __construct($name, $session);
//
// public function getName();
//
// public function getSession();
//
// public function delete();

class User {
	private $name;
	private $session;
	
	public static function create($name, $session) {
		$mysqli = new mysqli("classroom.cs.unc.edu", "serust", "CH@ngemenow99Please!serust", "serustdb");
		$result = $mysqli->query("INSERT INTO a6_User VALUES (" . 
			"'" . $mysqli->real_escape_string($name) . "', " .
			"'" . $mysqli->real_escape_string($session) . "')";
			);
		if ($result) {
			return new Board($name, $session);
		}
		return null;
	}
	
	public static function findByName($name) {
		$mysqli = new mysqli("classroom.cs.unc.edu", "serust", "CH@ngemenow99Please!serust", "serustdb");
		$result = $mysqli->query("SELECT * FROM a6_User WHERE name = " . $name);
		if ($result) {
			if ($result->num_rows == 0) {
				return null;
			}
			$info = $result->fetch_array();
			return new User($info['name']),
							$info['session']
							);
		}
		return null;
	}
	
	private function __construct($name, $session) {
		$this->name = $name;
		$this->session = $session;
	}
	
	public function getName() {
		return $this->name;
	}
	
	public function getSession() {
		return $this->session;
	}
	
	public function delete() {
		$mysqli = new mysqli("classroom.cs.unc.edu", "serust", "CH@ngemenow99Please!serust", "serustdb");
		$mysqli->query("DELETE FROM a6_User WHERE name = " . $this->name);
	}
}
?>