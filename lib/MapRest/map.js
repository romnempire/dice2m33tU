var url_base = "http://wwwp.cs.unc.edu/Courses/comp426-f14/serust/a8/Map.php/";
//////////In Test Mode//////////
$(document).ready(function () {
  $.ajax(
    url_base,
    {
      type: "GET",
      datatype: "json",
      success: function(msg, status, jqXHR) {
      }
    }
  );

  $( '#map' ).click(function(e) {
    $.ajax(
      url_base,
      {
        type: "POST",
        dataType: "json",
        success: function(msg, status, jqXHR) {
        }
    }
  });
});
