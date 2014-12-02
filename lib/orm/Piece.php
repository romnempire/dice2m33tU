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

class Piece {
	private $image;
	private $session;
	private $board;
	private $locationX;
	private $locationY;
	private $sizeX;
	private $sizeY;
	
	public static function create($image, $session, $board, $locationX, $locationY, $sizeX, $sizeY) {
		$mysqli = new mysqli("classroom.cs.unc.edu", "serust", "CH@ngemenow99Please!serust", "serustdb");
		$result = $mysqli->query("INSERT INTO a6_Piece VALUES (" . 
			"'" . $mysqli->real_escape_string($image) . "', " .
			"'" . $mysqli->real_escape_string($session) . "', " . 
			"'" . $mysqli->real_escape_string($board) . "', " .
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
		$mysqli = new mysqli("classroom.cs.unc.edu", "serust", "CH@ngemenow99Please!serust", "serustdb");
		$result = $mysqli->query("SELECT * FROM a6_Piece WHERE image = " . $image);
		if ($result) {
			if ($result->num_rows == 0) {
				return null;
			}
			$info = $result->fetch_array();
			return new Piece($info['image']),
							 $info['session'],
							 $info['board'],
							 intval($info['locationX']),
							 intval($info['locationY']),
							 intval($info['sizeX']),
							 intval($info['sizeY'])
							 );
		}
		return null;
	}
	
	public static function getAllPieces() {
		$mysqli = new mysqli("classroom.cs.unc.edu", "serust", "CH@ngemenow99Please!serust", "serustdb");
		$result = $mysqli->query("SELECT * FROM a6_Piece ORDER BY image");
		
		$all = $result->fetch_all([ int $resulttype = MYSQLI_NUM ]);
		$pieces = array();
		for ($index = 0; $index < sizeof($all); $index++) {
			$pieces[$index] = new User($all[$index]['image'],$all[$index]['session'],$all[$index]['board'], $all[$index]['locationX'],$all[$index]['locationY'],$all[$index]['sizeX'],$all[$index]['sizeY']);
		}
		
		return $pieces;
	}
	
	public static function findBySession($session) {
		$mysqli = new mysqli("classroom.cs.unc.edu", "serust", "CH@ngemenow99Please!serust", "serustdb");
		$result = $mysqli->query("SELECT * FROM a6_Piece WHERE session = " . $session);
		
		$all = $result->fetch_all([ int $resulttype = MYSQLI_NUM ]);
		$pieces = array();
		for ($index = 0; $index < sizeof($all); $index++) {
			$pieces[$index] = new User($all[$index]['image'],$all[$index]['session'],$all[$index]['board'], $all[$index]['locationX'],$all[$index]['locationY'],$all[$index]['sizeX'],$all[$index]['sizeY']);
		}
		
		return $pieces;	}
	
	public static function findByBoard($board) {
		$mysqli = new mysqli("classroom.cs.unc.edu", "serust", "CH@ngemenow99Please!serust", "serustdb");
		$result = $mysqli->query("SELECT * FROM a6_Piece WHERE board = " . $board);
		
		$all = $result->fetch_all([ int $resulttype = MYSQLI_NUM ]);
		$pieces = array();
		for ($index = 0; $index < sizeof($all); $index++) {
			$pieces[$index] = new User($all[$index]['image'],$all[$index]['session'],$all[$index]['board'], $all[$index]['locationX'],$all[$index]['locationY'],$all[$index]['sizeX'],$all[$index]['sizeY']);
		}
		
		return $pieces;
	}
	
	public static function findByLocation($locationX, $locationY) {
		$mysqli = new mysqli("classroom.cs.unc.edu", "serust", "CH@ngemenow99Please!serust", "serustdb");
		$result = $mysqli->query("SELECT * FROM a6_Piece WHERE locationX = " . $locationX . " AND locationY = " . $locationY);
		
		$all = $result->fetch_all([ int $resulttype = MYSQLI_NUM ]);
		$pieces = array();
		for ($index = 0; $index < sizeof($all); $index++) {
			$pieces[$index] = new User($all[$index]['image'],$all[$index]['session'],$all[$index]['board'], $all[$index]['locationX'],$all[$index]['locationY'],$all[$index]['sizeX'],$all[$index]['sizeY']);
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
		$mysqli = new mysqli("classroom.cs.unc.edu", "serust", "CH@ngemenow99Please!serust", "serustdb");
		$result = $mysqli->query("UPDATE a6_Piece SET locationX = ". $this->locationX . ", locationY = " . $this->locationY . ", sizeX = " . $this->sizeX . ", sizeY = " . $this->sizeY . " WHERE image = " . $this->image);
		return $result;
	}
	
	public function delete() {
		$mysqli = new mysqli("classroom.cs.unc.edu", "serust", "CH@ngemenow99Please!serust", "serustdb");
		$mysqli->query("DELETE FROM a6_Piece WHERE image = " . $this->image);
	}
}
?>