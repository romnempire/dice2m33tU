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
	private $url;

	public static function create($url) {
		$db = mysqli_connect("classroom.cs.unc.edu", "serust", "CH@ngemenow99Please!serust", "serustdb");
		$result = $db->query("INSERT INTO a6_Session VALUES (" . "\"" . mysqli_real_escape_string($url) . "\"" . ")");
		if ($result) {
			return new Session($url);
		}
		return null;
	}

	public static function findByURL($url) {
		$db = mysqli_connect("classroom.cs.unc.edu", "serust", "CH@ngemenow99Please!serust", "serustdb");
		$result = $db->query("SELECT * FROM a6_Session WHERE url = " . "\"" . mysqli_real_escape_string($url) . "\"");
		if ($result) {
			if ($result->num_rows == 0) {
				return null;
			}
			$row = $result->fetch_array();
			return new Session($row['url']);
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
		$db = mysqli_connect("classroom.cs.unc.edu", "serust", "CH@ngemenow99Please!serust", "serustdb");
		$db->query("DELETE FROM a6_Session WHERE url = \"" . $this->url . "\"");
	}

	public function getJSON() {
		$json_obj = array(
			'url' => $this->url
		);
		return json_encode($json_obj);
	}
}
?>
