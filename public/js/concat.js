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
		$options = $('#options');
		
		addActionHandler(); // to dice
		$('#slider').hide();


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
		var target = e.target;
		if (target.id = '#options') {
			return true;
		} else {
			socket.emit("onthemap", {x:e.pageX, y:e.pageY},	
				function(data){
					$blastField.val('');
				});
		}
	});
	
});


function showStats(e) {
	//var $player = e.target;
	//make statbox visible in clicked area	
}

// animates dice to slide left/right when clicked
function addActionHandler() {
	var isDiceBarVisible = false;
	$('#icon').click( function() {
		if (isDiceBarVisible) {
			$('#slider').hide();
		}
		else {
			$('#slider').show();
		}
		isDiceBarVisible = !isDiceBarVisible;
	});
	var lastOpen;
	$('#slider > div > img').click(function() {
		var options = $(this).next('ul');
		if (!options.length)
			return;
		if (lastOpen) {
			// if the options are already shown
			if (lastOpen.hasClass('open') && $(this).hasClass('open')) {
				options.fadeIn();
				$(this).removeClass('open');
				lastOpen = null;
			} else { // if this is a different dice option than already showing
				lastOpen.find('ul').fadeOut();
				lastOpen.removeClass('open');
				options.fadeIn();
				$(this).addClass('open');
				lastOpen = $(this);
			}
		} else {
			options.fadeIn();
			$(this).addClass('open');
			lastOpen = $(this);
		}
		return false;
	});
}