<?php
    require_once 'lib/orm/Board.php';
    ///////////In Test Mode///////////

    $path_components = explode('/', $_SERVER["PATH_INFO"]);

    // no id specified
    if (count($path_components) == 1) {
        if ($_SERVER['REQUEST_METHOD'] == "GET") {

            // ID not specified, then must be asking for index
            header("Content-type: application/json");
            print(json_encode(Board::getAllBoards())); //does this work?
            exit();

        } else if ($_SERVER['REQUEST_METHOD'] == "POST") {

            if (!isset($_REQUEST['background'])) {
                header("HTTP/1.0 400 Bad Request");
                print("Missing background");
                exit();
            }
            $background = $_REQUEST['background'];

            if ($background == "") {
                header("HTTP/1.0 400 Bad Request");
                print("Bad url");
                exit();
            }

            $length = 0;
            if ($_REQUEST['length'] != "") {
                $length = trim($_REQUEST['length']);
            }

            $width = 0;
            if ($_REQUEST['width'] != "") {
                $width = trim($_REQUEST['width']);
            }
            $session = "pets"; ///////REPLACE/////////

            $board = Board::create($session, $background, $length, $width);

            if ($board == null) {
                header("HTTP/1.0 500 Server Error");
                print("Server couldn't create new board");
                exit();
            }

            header("Content-type: application/json");
            print($board->getJSON());
            exit();
        } else {
            header("HTTP/1.0 400 Bad Request");
            print("Not valid RESTful url");
            exit();
        }

    } else if (count($path_components) >= 2 && ($path_components[1] != "")) {
        $bid = intval($path_components[1]);

        $board = Board::findByID($bid);
        if ($board == null) {
            // Board not found
            header("HTTP/1.0 404 Not Found");
            print("Board id: " . $bid . " not found.");
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] == "GET") {
            //just lookup
            header("Content-type: application/json");
            print($board->getJSON());
            exit();

        } else if ($_SERVER['REQUEST_METHOD'] == "POST") {

            $newBackground = false;
            if ($_REQUEST['background'] != "") {
                $newBackground = trim($_REQUEST['background']);
                if ($newBackground = "") {
                    header("HTTP/1.0 400 Bad Request");
                    print("Bad url");
                    exit();
                }
            }

            $newlength = false;
            if ($_REQUEST['length'] != "") {
                $newlength = trim($_REQUEST['length']);
            }

            $newwidth = false;
            if ($_REQUEST['width'] != "") {
                $newwidth = trim($_REQUEST['width']);
            }

            // Update via ORM
            if ($newbackground) {
                $board->setBackground($newbackground);
            }
            if ($newlength) {
                $board->setLength($newlength);
            }
            if ($newwidth) {
                $board->setWidth($newwidth);
            }

            header("Content-type: application/json");
            print($board->getJSON());
            exit();

        } else if ($_SERVER['REQUEST_METHOD'] == "DELETE") {
            $board->delete();
            header("Content-type: application/json");
            print(json_encode(true));
            exit();

        } else {
            header("HTTP/1.0 400 Bad Request");
            print("Did not understand URL");
            exit();
        }

    } else {
        header("HTTP/1.0 400 Bad Request");
        print("Not valid RESTful url");
        exit();
    }

?>
