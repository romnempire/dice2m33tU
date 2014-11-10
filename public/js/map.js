function dropInImage(url) {
    $('#map').append('<img src=' + url + ' class="toy draggable">');
    $(function () {
        $(".draggable").draggable({ containment: "parent" })
    });
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