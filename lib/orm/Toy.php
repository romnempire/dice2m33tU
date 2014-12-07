<?php

namespace orm;

// Piece Interface
//
// if the row can be inserted, then create returns a Piece object
// public static function create($url, $session, $board, $locationX, $locationY, $sizeX, $sizeY);
//
// if image exists, findByImage returns the Piece object
// public static function findByID($tid);
//
// getAllPieces returns an array
// public static function getAllToys();
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
// private function __construct($tid, $url, $session, $board, $locationX, $locationY, $sizeX, $sizeY);
//
// public function getID();
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


class Toy {
    private $tid;
	private $url;
	private $session;
	private $board;
	private $locationX;
	private $locationY;
	private $sizeX;
	private $sizeY;

	public static function create($url, $session, $board, $locationX, $locationY, $sizeX, $sizeY) {
		$db = mysqli_connect("classroom.cs.unc.edu", "serust", "CH@ngemenow99Please!serust", "serustdb");
        $querystring = "INSERT INTO a6_Toy (url, session, board, locationX, locationY, sizeX, sizeY) VALUES (" .
            "\"" . $db->real_escape_string($url)        . "\", " .
            "\"" . $db->real_escape_string($session)    . "\", " .
            "\"" . $db->real_escape_string($board)      . "\", " .
                 $locationX . ", " .
                 $locationY . ", " .
                 $sizeX . ", " .
                 $sizeY . ")";
		$result = $db->query($querystring);
		if ($result) {
            $tid = $db->insert_id;
			return new Toy($tid, $url, $session, $board, $locationX, $locationY, $sizeX, $sizeY);
		}
		return null;
	}

	public static function findByID($tid) {
		$db = mysqli_connect("classroom.cs.unc.edu", "serust", "CH@ngemenow99Please!serust", "serustdb");
		$result = $db->query("SELECT * FROM a6_Toy WHERE tid = " . $tid);
		if ($result) {
			if ($result->num_rows == 0) {
				return null;
			}
			$row = $result->fetch_array();
			return new Toy(
                intval($row['tid']),
				$row['url'],
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

	public static function getAllToys() {
		$db = mysqli_connect("classroom.cs.unc.edu", "serust", "CH@ngemenow99Please!serust", "serustdb");
		$result = $db->query("SELECT * FROM a6_Toy ORDER BY tid");

		$toys = array();
		while($row = mysqli_fetch_array($result)) {
			$toys[] = new Toy(
                intval($row['tid']),
				$row['url'],
				$row['session'],
				intval($row['board']),
				intval($row['locationX']),
				intval($row['locationY']),
				intval($row['sizeX']),
				intval($row['sizeY'])
			);
		}

		return $toys;
	}

	public static function findBySession($session) {
		$mysqli = new mysqli("classroom.cs.unc.edu", "serust", "CH@ngemenow99Please!serust", "serustdb");
		$result = $mysqli->query("SELECT * FROM a6_Toy WHERE session = \"" . $session . "\"");

        $toys = array();
        while($row = mysqli_fetch_array($result)) {
            $toys[] = new Toy(
                intval($row['tid']),
                $row['url'],
                $row['session'],
                intval($row['board']),
                intval($row['locationX']),
                intval($row['locationY']),
                intval($row['sizeX']),
                intval($row['sizeY'])
            );
        }

        return $toys;
	}

	public static function findByBoard($board) {
		$mysqli = new mysqli("classroom.cs.unc.edu", "serust", "CH@ngemenow99Please!serust", "serustdb");
		$result = $mysqli->query("SELECT * FROM a6_Toy WHERE board = " . $board);

        $toys = array();
        while($row = mysqli_fetch_array($result)) {
            $toys[] = new Toy(
                intval($row['tid']),
                $row['url'],
                $row['session'],
                intval($row['board']),
                intval($row['locationX']),
                intval($row['locationY']),
                intval($row['sizeX']),
                intval($row['sizeY'])
            );
        }

        return $toys;
	}

	public static function findByLocation($locationX, $locationY) {
		$mysqli = new mysqli("classroom.cs.unc.edu", "serust", "CH@ngemenow99Please!serust", "serustdb");
		$result = $mysqli->query("SELECT * FROM a6_Toy WHERE locationX = " . $locationX . " AND locationY = " . $locationY);

        $toys = array();
        while($row = mysqli_fetch_array($result)) {
            $toys[] = new Toy(
                intval($row['tid']),
                $row['url'],
                $row['session'],
                intval($row['board']),
                intval($row['locationX']),
                intval($row['locationY']),
                intval($row['sizeX']),
                intval($row['sizeY'])
            );
        }

        return $toys;
	}

	private function __construct($tid, $url, $session, $board, $locationX, $locationY, $sizeX, $sizeY) {
		$this->tid = $tid;
        $this->url = $url;
		$this->session = $session;
        $this->board = $board;
		$this->locationX = $locationX;
		$this->locationY = $locationY;
		$this->sizeX = $sizeX;
		$this->sizeY = $sizeY;
	}

    public function getID() {
        return $this->tid;
    }

	public function getURL() {
		return $this->url;
	}

    public function getBoard() {
        return $this->board;
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
		$result = $db->query("UPDATE a6_Toy SET "  .
		    "locationX = "      . $this->locationX .
            ", locationY = "    . $this->locationY .
            ", sizeX = "        . $this->sizeX .
            ", sizeY = "        . $this->sizeY .
            " WHERE tid = "     . $this->tid);
		return $result;
	}

	public function delete() {
		$db = mysqli_connect("classroom.cs.unc.edu", "serust", "CH@ngemenow99Please!serust", "serustdb");
		$db->query("DELETE FROM a6_Toy WHERE tid = " . $this->tid . "");
	}

	public function getJSON() {
		$json_obj = array(
            'tid' => $this->tid,
			'url' => $this->url,
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
