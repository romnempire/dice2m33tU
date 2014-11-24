<?php

// Board Interface
//
// if the row can be inserted, then create returns a Board object
// 	public static function create($session, $background, $length, $width);
//
// if id exists, findById returns the Board object
// public static function findByID($id);
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

class Board {
	private $bid;
	private $session;
	private $background;
	private $length;
	private $width;
	
	public static function create($session, $background, $length, $width) {
		$mysqli = new mysqli("classroom.cs.unc.edu", "serust", "CH@ngemenow99Please!serust", "serustdb");
		$result = $mysqli->query("INSERT INTO a6_Board VALUES (0, " . 
			"'" . $mysqli->real_escape_string($session) . "', " .
			"'" . $mysqli->real_escape_string($background) . "', " . 
				  $length . ", " .
				. $width . ")"
			);
		if ($result) {
			$new_id = $mysqli->insert_id;
			return new Board($new_id, $session, $background, $length, $width);
		}
		return null;
	}
	
	public static function findByID($bid) {
		$mysqli = new mysqli("classroom.cs.unc.edu", "serust", "CH@ngemenow99Please!serust", "serustdb");
		$result = $mysqli->query("SELECT * FROM a6_Board WHERE bid = " . $bid);
		if ($result) {
			if ($result->num_rows == 0) {
				return null;
			}
			$info = $result->fetch_array();
			return new Board(intval($info['bid']),
							 $info['session'],
							 $info['background'],
							 intval($info['length']),
							 intval($info['width'])
							 );
		}
		return null;
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
		$mysqli = new mysqli("classroom.cs.unc.edu", "serust", "CH@ngemenow99Please!serust", "serustdb");
		$result = $mysqli->query("UPDATE a6_Board SET background = ". $this->background . ", length = " . $this->length . ", width = " . $this->width . " WHERE bid = " . $this->bid);
		return $result;
	}
	
	public function delete() {
		$mysqli = new mysqli("classroom.cs.unc.edu", "serust", "CH@ngemenow99Please!serust", "serustdb");
		$mysqli->query("DELETE FROM a6_Board WHERE bid = " . $this->bid);
	}
}
?>