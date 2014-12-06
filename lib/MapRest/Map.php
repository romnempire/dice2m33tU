<?php
    //  require_once 'orm/Board.php';
    ///////////In Test Mode///////////
    ini_set('display_errors', '1');
    error_reporting(E_ALL);

    $path_components = explode('/', $_SERVER['PATH_INFO']);
    // first check if null
    // then check if post
    // then check if empty get
    // then check if post with variables
    // then check if get with variables

    if ($path_components == null) {

        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            // Create new Board item

            if (!isset($_REQUEST['background'])) {
                header("HTTP/1.0 400 Bad Request");
                print("Missing background");
                exit();
            }

            $background = trim($_REQUEST['background']);
            if ($background == "") {
                header("HTTP/1.0 400 Bad Request");
                print("Bad url");
                exit();
            }

            $length = "";
            if (isset($_REQUEST['length'])) {
                $length = trim($_REQUEST['length']);
            }

            $width = "";
            if (isset($_REQUEST['width'])) {
                $width = trim($_REQUEST['width']);
            }

            // Create new Board via ORM
            $session = "pets"; ///////REPLACE/////////

            //$board = Board::create($session, $background, $length, $width);

            //Report if failed
    //        if ($board == null) {
    //            echo '<script language="javascript">';
    //            echo 'alert("merrow")';
    //            echo '</script>';
    //            header("HTTP/1.0 500 Server Error");
    //            print("Server couldn't create new board");
    //            exit();
    //        }

            //Generate JSON encoding of new Board
            header("Content-type: application/JSON");
            //print($board->getJSON());
            exit();

        } else if ($_SERVER['REQUEST_METHOD'] == "GET") {
            // ID not specified, then must be asking for index
            header("Content-type: application/json");
            //print(json_encode(Board::getAllBoards()));
            exit();
        } else {
            // URL cannot be parsed
            header("HTTP/1.0 400 Bad Request");
            print("Did not understand URL");
        }
    }
    //URL form
    // /Map.php/maps/<id>
    else if ((count($path_components) >= 3) && ($path_components[2] != "")) {

        //Interpret <id> as integer and look up via ORM
        $bid = intval($path_components[2]);

        if ($_SERVER['PATH_INFO'] == "POST") {
            //$board = Board::findByID($bid);

    //        if ($board == null) {
    //            // Board not found
    //            header("HTTP/1.0 404 Not Found");
    //            print("Board id: " . $bid . " not found while attempting update.");
    //            exit();
    //        }

            // Validate values
            $newbackground = false;
            if (isset($_REQUEST['background'])) {
                $newbackground = trim($_REQUEST['background']);
                if ($newbackground = "") {
                    header("HTTP/1.0 400 Bad Request");
                    print("Bad url");
                    exit();
                }
            }

            $newlength = false;
            if (isset($_REQUEST['length'])) {
                $newlength = trim($_REQUEST['length']);
            }

            $newwidth = false;
            if (isset($_REQUEST['width'])) {
                $newwidth = trim($_REQUEST['width']);
            }

            // Update via ORM
            if ($newbackground) {
                //$board->setBackground($newbackground);
            }
            if ($newlength) {
                //$board->setLength($newlength);
            }
            if ($newwidth) {
                //$board->setWidth($newwidth);
            }

            // Return JSON encoding of updated board
            header("Content type: application/json");
            //print($board->getJSON());
            exit();

        } else { // GET

            // GET with resource type path return an index of resources
            // parameters can be used to provide filter parameters

            // GET with an instance path
            // retrieves a representation of resource named by id

            // GET with delete
            // deletes

            // Look up object with ORM
            //$board = Board::findByID($bid);

            if ($bid == null) {
                //Board not found
                header("HTTP/1.0 404 Not Found");
                print("Board id: " . $bid . " not found.");
                exit();
            }

            // Check if delete
            if (isset($_REQUEST['delete'])) {
                //$board->delete();
                header("Content-type: application/json");
                print(json_encode(true));
                exit();
            }

            // Normal lookup
            // Generate JSON encoding as response
            header("Content-type: application/json");
            //print($board->getJSON());
            exit();
        }

    } else {
        // Error in URL
        header("HTTP/1.0 400 Bad Request");
        print("Did not understand URL");
    }

?>