<?php
  header("Content type: application/json");
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset = "UTF-8">
        <title>dice2m33tU</title>
        <meta name="description" content="A minimalist virtual online gaming table.">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="css/core.css">
        <script src="http://www.cs.unc.edu/Courses/comp426-f14/jquery-1.11.1.js"></script>
        <script src="map.js"></script>
    </head>

    <body>
        <div id="top">
            <div id="title">Dungeons and Dragons</div>
        </div>

        <div id="container">
            <div id="map">
            </div>

            <div id="chat">
                <div id="rest">
                    <select id="methodselect" name="method">
                        <option value="GET">See board</option>
                        <option value="POST">Add/change board</option>
                        <option value="DELETE">Delete board</option>
                    </select>
                    <div id="parameters">
                        Board id: <input style="50em" type="text" name="bid" id="bid"><br>
                        <form id="restform" name="restform">
                            Background: <input style="50em" type="text" name="background"><br>
                            Width: <input style="50em" type="text" name="width"><br>
                            Length: <input style="50em" type="text" name="length"><br>
                        </form>
                    </div>
                    <div><button id="submit">Go</button></div>
                </div>
            </div>
        </div>
    </body>
</html>
