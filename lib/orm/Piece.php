<?php

// Piece Interface
//
// if the row can be inserted, then create returns a Piece object
// public static function create($image, $session, $board, $locationX, $locationY, $sizeX, $sizeY);
//
// if image exists, findByImage returns the Piece object
// public static function findByImage($image);
//
// getAllPieces returns an array
// public static function getAllPieces();
//
// findBySession returns an array
// public static function findBySession($session);
//
// findByBoard returns an array
// public static function findByBoard($board);
//
// findByLocation returns an array
// public static function findByLocation($locationX, $locationY);
//
// private constructor, called when row can be inserted
// private function __construct($image, $session, $board, $locationX, $locationY, $sizeX, $sizeY);
//
// public function getImage();
//
// public function getSession();
//
// get location returns an array [x,y]
// public function getLocation();
//
// get size returns an array [x,y]
// public function getSize();
//
// public function setLocation($x,$y);
//
// public function setSize($sizex, $sizey);
//
// update is called inside setters
// public function update();
//
// public function delete();
//
// public function getJSON();


class Piece {
	private $image;
	private $session;
	private $board;
	private $locationX;
	private $locationY;
	private $sizeX;
	private $sizeY;

	public static function create($image, $session, $board, $locationX, $locationY, $sizeX, $sizeY) {
		$db = mysqli_connect("classroom.cs.unc.edu", "serust", "CH@ngemenow99Please!serust", "serustdb");
		$result = $db->query("INSERT INTO a6_Piece VALUES (" .
			"'" . mysqli_real_escape_string($image) . "', " .
			"'" . mysqli_real_escape_string($session) . "', " .
			"'" . mysqli_real_escape_string($board) . "', " .
			    . $locationX . ", " .
			    . $locationY . ", " .
			    . $sizeX . ", " .
			    . $sizeY . ")"
			);
		if ($result) {
			return new Piece($image, $session, $board, $locationX, $locationY, $sizeX, $sizeY);
		}
		return null;
	}

	public static function findByImage($image) {
		$db = mysqli_connect("classroom.cs.unc.edu", "serust", "CH@ngemenow99Please!serust", "serustdb");
		$result = $db->query("SELECT * FROM a6_Piece WHERE image = \"" . $image . "\"");
		if ($result) {
			if ($result->num_rows == 0) {
				return null;
			}
			$row = $result->fetch_array();
			return new Piece(
				$row['image']),
				$row['session'],
				intval($row['board']),
				intval($row['locationX']),
				intval($row['locationY']),
				intval($row['sizeX']),
				intval($row['sizeY'])
			);
		}
		return null;
	}

	public static function getAllPieces() {
		$db = mysqli_connect("classroom.cs.unc.edu", "serust", "CH@ngemenow99Please!serust", "serustdb");
		$result = $db->query("SELECT * FROM a6_Piece ORDER BY image");

		$pieces = array();
		while($row = mysqli_fetch_array($result)) {
			$pieces[] = new Piece(
				$row['image'],
				$row['session'],
				intval($row['board']),
				intval($row['locationX']),
				intval($row['locationY']),
				intval($row['sizeX']),
				intval($row['sizeY'])
			);
		}

		return $pieces;
	}

	public static function findBySession($session) {
		$mysqli = new mysqli("classroom.cs.unc.edu", "serust", "CH@ngemenow99Please!serust", "serustdb");
		$result = $mysqli->query("SELECT * FROM a6_Piece WHERE session = " . $session);

		$pieces = array();
		while($row = mysqli_fetch_array($result)) {
			$pieces[] = new Piece(
				$row['image'],
				$row['session'],
				intval($row['board']),
				intval($row['locationX']),
				intval($row['locationY']),
				intval($row['sizeX']),
				intval($row['sizeY'])
			);
		}

		return $pieces;
	}

	public static function findByBoard($board) {
		$mysqli = new mysqli("classroom.cs.unc.edu", "serust", "CH@ngemenow99Please!serust", "serustdb");
		$result = $mysqli->query("SELECT * FROM a6_Piece WHERE board = " . $board);

		$pieces = array();
		while($row = mysqli_fetch_array($result)) {
			$pieces[] = new Piece(
				$row['image'],
				$row['session'],
				intval($row['board']),
				intval($row['locationX']),
				intval($row['locationY']),
				intval($row['sizeX']),
				intval($row['sizeY'])
			);
		}

		return $pieces;
	}

	public static function findByLocation($locationX, $locationY) {
		$mysqli = new mysqli("classroom.cs.unc.edu", "serust", "CH@ngemenow99Please!serust", "serustdb");
		$result = $mysqli->query("SELECT * FROM a6_Piece WHERE locationX = " . $locationX . " AND locationY = " . $locationY);

		$pieces = array();
		while($row = mysqli_fetch_array($result)) {
			$pieces[] = new Piece(
				$row['image'],
				$row['session'],
				intval($row['board']),
				intval($row['locationX']),
				intval($row['locationY']),
				intval($row['sizeX']),
				intval($row['sizeY'])
			);
		}

		return $pieces;
	}

	private function __construct($name, $session, $locationX, $locationY, $sizeX, $sizeY) {
		$this->name = $name;
		$this->session = $session;
		$this->locationX = $locationX;
		$this->locationY = $locationY;
		$this->sizeX = $sizeX;
		$this->sizeY = $sizeY;
	}

	public function getImage() {
		return $this->image;
	}

	public function getSession() {
		return $this->session;
	}

	public function getLocation() {
		return array($this->locationX, $this->locationY);
	}

	public function getSize() {
		return array($this->sizeX, $this->sizeY);
	}

	public function setLocation($x, $y) {
		$this->locationX = $x;
		$this->locationY = $y;

		return $this->update();
	}

	public function setSize($sizeX, $sizeY) {
		 $this->sizeX = $sizeX;
		 $this->sizeY = $sizeY;

		 return $this->update();
	}

	public function update() {
		$db = mysqli_connect("classroom.cs.unc.edu", "serust", "CH@ngemenow99Please!serust", "serustdb");
		$result = $db->query("UPDATE a6_Piece SET locationX = ". $this->locationX . ", locationY = " . $this->locationY . ", sizeX = " . $this->sizeX . ", sizeY = " . $this->sizeY . " WHERE image = \"" . $this->image . "\"");
		return $result;
	}

	public function delete() {
		$db = mysqli_connect("classroom.cs.unc.edu", "serust", "CH@ngemenow99Please!serust", "serustdb");
		$db->query("DELETE FROM a6_Piece WHERE image = \"" . $this->image . "\"");
	}

	public function getJSON() {
		$json_obj = array(
			'image' => $this->name,
			'session' => $this->session,
			'board' => $this->board,
			'locationX' => $this->locationX,
			'locationY' => $this->locationY,
			'sizeX' => $this->sizeX,
			'sizeY' => $this->sizeY
		);
		return json_encode($json_obj);
	}
}
?>
