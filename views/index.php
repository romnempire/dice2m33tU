<!DOCTYPE html>
<html>
    <head>
        <meta charset = "UTF-8">
        <title>dice2m33tU</title>
        <meta name="description" content="A minimalist virtual online gaming table.">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" type="text/css" href="css/core.css">
    </head>

    <body>
        <div id="top">
        <div id="title">Dungeons and Dragons</div>
        <div id="toplinks">
        <center>
        <a href="http://www.cs.unc.edu/Courses/comp426-f14/amrobers/a3/index.html"><div class="toplinks"><br>home</div></a>
        <a href="http://www.cs.unc.edu/Courses/comp426-f14/amrobers/a3/index.html#about"><div class="toplinks"><br>about</div></a>
        <a href="http://www.cs.unc.edu/Courses/comp426-f14/amrobers/a3/index.html#contact"><div class="toplinks"><br>more</div></a>
        </center>
        </div>
        </div>
        
        <div id="container">
            <div id="map">
                <div id="grid">
                </div>
                <div id="toybox"><h2>toybox</h2>
               
                </div>
                <div id="dice">
                	<a href="#show">
                    	<img src="http://i58.tinypic.com/242eqmf.png" width="60px" height="65px">
                    </a>
                </div>
                <div id="empty">
                	<a name="close">
						<div id="hide"></div>
					</a>
					<a name="show"></a>
					<div id="appear">
						<a name="show"></a>
						<a href="#d1s"><img src="http://i58.tinypic.com/242eqmf.png" width="60px" height="65px"></a><a href="#close">(close)</a>
					</div>
				</div>
				<div id="d1">
					<a name="d1close"><div id="d1hide"></div></a>
					<a name="d1s">
						<div id="d1show"><img src="http://i58.tinypic.com/242eqmf.png" width="60px" height="65px"><br><br><a href="#d1close">
								(close)</a>
						</div>
					</a>
				</div>
                <div id="statscontainer">
					<a name="statsclose"><div id="statshide"></div></a>
					<a name="showstats"><div id="stats">stats here!!!
						<br><br><br><a href="#statsclose">(close)</a>
					</div></a>
				</div>
            
                <div id="options">
                    <button type="button" onclick="createURLChooser(this)">Add Toy</button>
                    <button type="button" onclick="$('.griddy').toggle();return false;">Grid</button>
                    <button type="button" onclick="alert('I like food')">Stats</button>
                </div>
            </div>

            <div id="chat">
                <div id="allPosts" class="form-control">
                </div>

                <div class="input-group" id="chatinput">
                    <input id="blast" type="text" class="form-control" placeholder="send something to everyone" name="chatinput">
                    <span class="input-group-btn">
                        <button id="send" class="btn btn-success" type="button">Send</button>
                    </span>
                </div><!-- /input-group -->
            </div>
        </div>

        <!-- jQuery --> 
        <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="public/bower_components/jquery/jquery.min.js"><\/script>')</script>
        <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
        <script>window.jQuery.ui || document.write('<script src="public/bower_components/jquery-ui/jquery-ui.min.js"><\/script>')</script>

        <!-- socket.io -->
        <script src="/socket.io/socket.io.js"></script>

        <!-- APP CODE -->
        <!--for devt purposes you might want to refer to the unminifieds.
        it lets the node server serve you your updated code without running grunt-->
        <!--
        <script src="js/app.min.js"></script>
        <script src="js/map.min.js"></script>
        <script src="js/griddy.js"></script>
        -->
        <script src="js/concat.min.js"></script>
    </body>
</html>