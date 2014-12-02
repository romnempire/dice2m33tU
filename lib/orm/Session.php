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

class Session {
	private $url;
	
	public static function create($url) {
		$mysqli = new mysqli("classroom.cs.unc.edu", "serust", "CH@ngemenow99Please!serust", "serustdb");
		$result = $mysqli->query("INSERT INTO a6_Session VALUES (" . "'" . $mysqli->real_escape_string($url) . "'" . ")");
		if ($result) {
			return new Session($url);
		}
		return null;
	}
	
	public static function findByURL($url) {
		$mysqli = new mysqli("classroom.cs.unc.edu", "serust", "CH@ngemenow99Please!serust", "serustdb");
		$result = $mysqli->query("SELECT * FROM a6_Session WHERE url = " . "'" . $mysqli->real_escape_string($url) . "'");
		if ($result) {
			if ($result->num_rows == 0) {
				return null;
			}
			$info = $result->fetch_array();
			return new Session($info['url']);
		}
		return null;
	}
	
	private function __construct($url) {
		$this->url = $url;
	}
	
	public function getURL() {
		return $this->url;
	}
	
	public function delete() {
		$mysqli = new mysqli("classroom.cs.unc.edu", "serust", "CH@ngemenow99Please!serust", "serustdb");
		$mysqli->query("DELETE FROM a6_Session WHERE url = " . $this->url);
	}
}
?>