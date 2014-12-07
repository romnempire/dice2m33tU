<?php

// Session Interface
//
// if the row can be inserted, then create returns a Session object
// public static function create($url);
//
// if id exists, findById returns the Session object
// public static function findByURL($url);
//
// private constructor, called when row can be inserted
// private function __construct($url);
//
// public function getURL();
//
// public function delete();
//
// public function getJSON();

class Session {
	private $name;

	public static function create($name) {
		$db = mysqli_connect("classroom.cs.unc.edu", "serust", "CH@ngemenow99Please!serust", "serustdb");
		$result = $db->query("INSERT INTO a6_Session VALUES (" . "\"" . $db->real_escape_string($name) . "\"" . ")");
		if ($result) {
			return new Session($name);
		}
		return null;
	}

	public static function findByName($name) {
		$db = mysqli_connect("classroom.cs.unc.edu", "serust", "CH@ngemenow99Please!serust", "serustdb");
		$result = $db->query("SELECT * FROM a6_Session WHERE name = " . "\"" . $db->real_escape_string($name) . "\"");
		if ($result) {
			if ($result->num_rows == 0) {
				return null;
			}
			$row = $result->fetch_array();
			return new Session($row['name']);
		}
		return null;
	}

	private function __construct($name) {
		$this->url = $name;
	}

	public function getName() {
		return $this->name;
	}

	public function delete() {
		$db = mysqli_connect("classroom.cs.unc.edu", "serust", "CH@ngemenow99Please!serust", "serustdb");
		$db->query("DELETE FROM a6_Session WHERE name = \"" . $this->name . "\"");
	}

	public function getJSON() {
		$json_obj = array(
			'name' => $this->name
		);
		return json_encode($json_obj);
	}
}
?>
