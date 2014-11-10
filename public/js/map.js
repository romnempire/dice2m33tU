function dropInImage(url) {
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
