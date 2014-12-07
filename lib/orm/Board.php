<?php

// Board Interface
//
// if the row can be inserted, then create returns a Board object
// 	public static function create($session, $background, $length, $width);
//
// if id exists, findById returns the Board object
// public static function findByID($id);
//
// getAllBoards returns an array
// public static function getAllBoards();
//
// findBySession returns an array
// public static function findBySession($session);
//
// private constructor, called when row can be inserted
// private function __construct($bid, $session, $background, $length, $width);
//
// public function getID();
//
// public function getSession();
//
// public function getBackground();
//
// public function getLength();
//
// public function getWidth();
//
// public function setBackground($background);
//
// public function setLength($length);
//
// public function setWidth($width);
//
// update is called inside setters
// public function update();
//
// public function delete();
//
// public function getJSON();

class Board {
	private $bid;
	private $session;
	private $background;
	private $length;
	private $width;

	public static function create($session, $background, $length, $width) {
		$db = mysqli_connect("classroom.cs.unc.edu", "serust", "CH@ngemenow99Please!serust", "serustdb");
		$result = $db->query("INSERT INTO a6_Board (session, background, length, width) VALUES ( " .
			"\"" . $db->real_escape_string($session) . "\", " .
			"\"" . $db->real_escape_string($background) . "\", " .
				  $length   . ", " .
				  $width    . ")"
			);
		if ($result) {
			$bid = $db->insert_id;
			return new Board($bid, $session, $background, $length, $width);
		}
		return null;
	}

	public static function findByID($bid) {
		$db = mysqli_connect("classroom.cs.unc.edu", "serust", "CH@ngemenow99Please!serust", "serustdb");
		$result = $db->query("SELECT * FROM a6_Board WHERE bid = " . $bid);
		if ($result) {
			if ($result->num_rows == 0) {
				return null;
			}
			$row = $result->fetch_array();
			return new Board(
				intval($row['bid']),
				$row['session'],
				$row['background'],
				intval($row['length']),
				intval($row['width'])
			);
		}
		return null;
	}

	public static function getAllBoards() {
		$db = mysqli_connect("classroom.cs.unc.edu", "serust", "CH@ngemenow99Please!serust", "serustdb");
		$result = $db->query("SELECT * FROM a6_Board ORDER BY bid");

		$boards = array();
		while($row = mysqli_fetch_array($result)) {
			$boards[] = new Board(
				intval($row['bid']),
				$row['session'],
				$row['background'],
				intval($row['length']),
				intval($row['width'])
			);
		}

		return $boards;
	}

	public static function getBySession($session) {
		$mysqli = new mysqli("classroom.cs.unc.edu", "serust", "CH@ngemenow99Please!serust", "serustdb");
		$result = $mysqli->query("SELECT * FROM a6_Board WHERE session = \"" . $session . "\"");

		$boards = array();
		while($row = mysqli_fetch_array($result)) {
			$boards[] = new Board(
				intval($row['bid']),
				$row['session'],
				$row['background'],
				intval($row['length']),
				intval($row['width'])
			);
		}

		return $boards;
	}

	private function __construct($bid, $session, $background, $length, $width) {
		$this->bid = $bid;
		$this->session = $session;
		$this->background = $background;
		$this->length = $length;
		$this->width = $width;
	}

	public function getID() {
		return $this->bid;
	}

	public function getSession() {
		return $this->session;
	}

	public function getBackground() {
		return $this->background;
	}

	public function getLength() {
		return $this->length;
	}

	public function getWidth() {
		return $this->width;
	}

	public function setBackground($background) {
		$this->background = $background;
		return $this->update();
	}

	public function setLength($length) {
		$this->length = $length;
		return $this->update();
	}

	public function setWidth($width) {
		$this->width = $width;
		return $this->update();
	}

	public function update() {
		$db = mysqli_connect("classroom.cs.unc.edu", "serust", "CH@ngemenow99Please!serust", "serustdb");
		$result = $db->query("UPDATE a6_Board SET background = \"". $this->background . "\", length = " . $this->length . ", width = " . $this->width . " WHERE bid = " . $this->bid);
		return $result;
	}

	public function delete() {
		$db = mysqli_connect("classroom.cs.unc.edu", "serust", "CH@ngemenow99Please!serust", "serustdb");
		$db->query("DELETE FROM a6_Board WHERE bid = " . $this->bid);
	}

	public function getJSON() {
		$json_obj = array(
			'bid' => $this->bid,
			'session' => $this->session,
			'background' => $this->background,
			'length' => $this->length,
			'width' => $this->width
		);
		return json_encode($json_obj);
	}
}
?>
