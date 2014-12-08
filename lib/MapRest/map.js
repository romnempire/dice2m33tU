var url_base = "http://wwwx.cs.unc.edu/Courses/comp426-f14/serust/a8";
//////////In Test Mode//////////

$(document).ready(function () {
    /*var url = window.location.protocol + "://" + window.location.host + "/" + window.location.pathname;*/
    $( '#submit' ).click(function(e) {
        var type = $('#methodselect option:selected').val();

        var bid = "";
        if ($('#bid').val()) {
            bid = "/" + $('#bid').val();
        }

        var data = $('#restform').serialize();

        $.ajax(
            url_base + "/Map.php" + bid,
            {
                type: type,
                datatype: "json",
                data: data,
                success: function(msg, status, jqXHR) {
                    alert(msg['background']);
                    $('#map').css('background', 'url(\'' + msg['background'] + '\')');
                },
                error: function(jqXHR, status, error) {
                    alert(jqXHR.responseText);
                }
            }
        );
    });
});