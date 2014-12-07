<?php

// User Interface
//
// if the row can be inserted, then create returns a User object
// public static function create($name, $session);
//
// if name exists, findByName returns the User object
// public static function findByName($name);
//
// getAllUsers returns an array
// public function getAllUsers();
//
// findBySession returns an array
// public function findBySession($session);
//
// private constructor, called when row can be inserted
// private function __construct($name, $session);
//
// public function getName();
//
// public function getSession();
//
// public function delete();
//
// public function getJSON();

class User {
	private $name;
	private $session;

	public static function create($name, $session) {
		$db = mysqli_connect("classroom.cs.unc.edu", "serust", "CH@ngemenow99Please!serust", "serustdb");
		$result = $db->query("INSERT INTO a6_User VALUES (" .
			"\"" . $db->real_escape_string($name) . "\", " .
			"\"" . $db->real_escape_string($session) . "\")"
			);
		if ($result) {
			return new User($name, $session);
		}
		return null;
	}

	public static function findByName($name) {
		$db = mysqli_connect("classroom.cs.unc.edu", "serust", "CH@ngemenow99Please!serust", "serustdb");
		$result = $db->query("SELECT * FROM a6_User WHERE name = \"" . $name . "\"");
		if ($result) {
			if ($result->num_rows == 0) {
				return null;
			}
			$row = $result->fetch_array();
			return new User(
				$row['name'],
				$row['session']
			);
		}
		return null;
	}

	public static function getAllUsers() {
		$db = mysqli_connect("classroom.cs.unc.edu", "serust", "CH@ngemenow99Please!serust", "serustdb");
		$result = $db->query("SELECT * FROM a6_User ORDER BY name");

		$messages = array();
			while ($row = mysqli_fetch_array($result)) {
				$messages[] = new User(
					$row['name'],
					$row['session']
				);
			}

			return $messages;
	}

	public static function getBySession($session) {
		$mysqli = new mysqli("classroom.cs.unc.edu", "serust", "CH@ngemenow99Please!serust", "serustdb");
		$result = $mysqli->query("SELECT * FROM a6_User WHERE session = \"" . $session . "\"");

		$messages = array();
			while ($row = mysqli_fetch_array($result)) {
				$messages[] = new User(
					$row['name'],
					$row['session']
				);
			}

		return $messages;
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
		$mysqli->query("DELETE FROM a6_User WHERE name = \"" . $this->name . "\"");
	}

	public function getJSON() {
		$json_obj = array(
			'name' => $this->name,
			'session' => $this->session
		);
		return json_encode($json_obj);
	}
}
?>
