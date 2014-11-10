// connect to our socket server
var socket = io.connect('http://127.0.0.1:1337/');

var app = app || {};


// shortcut for document.ready
$(function(){
	//setup some common vars
	var $blastField = $('#blast'),
		$allPostsTextArea = $('#allPosts'),
		$clearAllPosts = $('#clearAllPosts'),
		$sendBlastButton = $('#send'),
		$mapField = $('#map');


	//SOCKET STUFF
	socket.on("blast", function(data){
		var copy = $allPostsTextArea.html();
		$allPostsTextArea.html('<p>' + copy + data.msg + "</p>");
		$allPostsTextArea.scrollTop($allPostsTextArea[0].scrollHeight - $allPostsTextArea.height());
		//.css('scrollTop', $allPostsTextArea.css('scrollHeight'));

	});

	socket.on("onthemap", function(data){
		var copy = $allPostsTextArea.html();
		$allPostsTextArea.html('<p>'+ copy + data.y + data.x + "</p>" );
		$allPostsTextArea.scrollTop($allPostsTextArea[0].scrollHeight - $allPostsTextArea.height());
	});
	
	$clearAllPosts.click(function(e){
		$allPostsTextArea.text('');
	});

	$sendBlastButton.click(function(e){

		var blast = $blastField.val();
		if(blast.length){
			socket.emit("blast", {msg:blast}, 
				function(data){
					$blastField.val('');
				});
		}


	});

	$blastField.keydown(function (e){
	    if(e.keyCode == 13){
	        $sendBlastButton.trigger('click');//lazy, but works
	    }
	});

	$mapField.click(function(e){
		socket.emit("onthemap", {x:e.pageX, y:e.pageY},	
			function(data){
					$blastField.val('');
				});
	});
	
});;function dropInImage(url) {
    $('#map').append('<img src=' + url + ' class="toy draggable">');
    $('.draggable').draggable({ containment: 'parent', start: handleDragStart,
        stop: handleDragStop, drag: handleDragDrag });
    $('draggable').on()
    $('#urlchooser').remove();
}

function createURLChooser(_this) {
    var posn = $(_this).position();
    console.log(posn.left);
    console.log(posn.top);
    if($('#urlchooser').length === 0) {
        $('#options').append('<div id="urlchooser"><input type="text"><button onclick="dropInImage($(\'#urlchooser > input\').val())">GO</button></div>');
        //$('#urlchooser').css('z-index',5);
        $('#urlchooser').css('position', 'absolute');
        $('#urlchooser').css({'left':-.5*$('#urlchooser').width(), 'top':-1.1*$('#urlchooser').height()})
    } else {
        $('#urlchooser').remove();
    }
}

//the 40 is due to the h2 padding oh god kill me
//i swaer to you this was as miserable to write as it was for you to read
function handleDropEvent( e, ui ) {
    var draggable = ui.draggable;

    if($(this).attr('id') === 'toybox') {
        draggable.css({left: draggable.position().left - $('#toybox').position().left, 
            top: draggable.position().top - $('#toybox').position().top - $('#toybox > h2').height() - 40});
    } else if ($(this).attr('id') === 'map') {
        draggable.css({left: draggable.position().left + $('#toybox').position().left,
            top: draggable.position().top});
    } else {
        draggable.css({left: '0px', top:'0px'});
    }
    $(this).append(draggable);
    //draggable.draggable({ containment: 'parent'});
}

function handleDragStart( e, ui ) {
    if($(this).parent().attr('id') === 'map'){
        $( "#map" ).droppable({ disabled: true });
    } else {
        console.log($(this).parent().attr('id'));
    }

    if($(this).parent().attr('id') === 'toybox'){
        $( "#map, #toybox" ).droppable({ disabled: true });
    } 
}

function handleDragDrag( e, ui ) {
    //ohh this is hacky.  super hacky.
    if($(this).parent().attr('id') === 'toybox'){
        if((Math.abs(ui.position.top) > $('#toybox').height()) ||
            (Math.abs(ui.position.left) > $('#toybox').width())) {
            $( "#map" ).droppable({ disabled:false });
        }
    }
}

function handleDragStop( e, ui ) {
    $( '#map, #toybox' ).droppable({ disabled: false });
}

$( '#map, #toybox' ).droppable({ accept: ".toy", drop: handleDropEvent });
$( '#toybox').draggable( {containment: 'parent'});
;$(document).ready(function(){
  $('#grid').griddy({rows:Math.floor($('#map').width()/100), rowheight: 100, rowgutter: 5, columns: Math.floor($('#map').width()/100), columnwidth: 100, columngutter: 5});
});
$.fn.griddy = function(options) {
  this.css('position','relative');
  var defaults = { rows: 10, rowheight: 0, rowgutter: 20, columns: 4, columnwidth: 0, columngutter: 20, color: '#ccc', opacity: 30 };
  var opts = $.extend(defaults, options); var o = $.meta ? $.extend({}, opts, $$.data()) : opts;
  var width = this.width(); var height = $(document).height();
  if(o.columnwidth == 0) o.columnwidth = Math.floor(width - ((o.columns-1)*o.columngutter))/o.columns;
  if(o.rowheight == 0) o.rowheight = Math.floor(height - ((o.rows-1)*o.rowgutter))/o.rows;
  this.prepend("<div class='griddy' style='display:none;overflow:hidden;position:absolute;left:0;top:0;width:100%;height:"+(height-20)+"px;'><div class='griddy-r' style='position:relative;width:100%;height:100%;display:block;overflow:hidden;'><div class='griddy-columns' style='position:absolute;top:0;left:0;width:100%;height:100%;'></div></div></div>");
  if(o.columns != 0){
    for ( var i = 0; i < o.columns; i++ ) { // columns
      if(i!=0) $('.griddy-r').append("<div style='width:"+o.columngutter+"px;display:inline;float:left;height:100%;'></div>");
      $('.griddy-r',this).append("<div style='width:"+o.columnwidth+"px;height:100%;display:block;float:left;text-align:center;position:relative;'><div style='width:100%;height:100%;position:absolute;top:0;left:0;display:block;background:"+o.color+";opacity:"+(o.opacity/100)+";filter:alpha(opacity="+o.opacity+");'></div></div>");
    }
  }
  if(o.rows != 0){
    for ( var i = 0; i < o.rows; i++ ) { // rows
      if(i!=0) $('.griddy-columns').append("<div style='height:"+o.rowgutter+"px;display:block;float:left;width:100%;'></div>");
      $('.griddy-columns',this).append("<div style='height:"+o.rowheight+"px;width:100%;float:left;display:block;line-height:"+o.rowheight+"px;position:relative;'><div style='width:100%;height:100%;position:absolute;top:0;left:0;display:block;background:"+o.color+";opacity:"+(o.opacity/100)+";filter:alpha(opacity="+o.opacity+");'></div></div>");
    }
  }
};
