var url_base = "http://wwwp.cs.unc.edu/Courses/comp426-f14/serust/a8";
//////////In Test Mode//////////
$(document).ready(function () {
  $.ajax(
    {
      type: "GET",
      datatype: "json",
      url: url_base + "/Map.php/maps",
      success: function(msg, status, jqXHR) {
        alert("Board Got!");
      },
      error: function(jqXHR, status, error) {
        alert("what happened");
      }
    }
  );

  $( '#map' ).click(function(e) {
    $.ajax(
      {
        type: "POST",
        dataType: "json",
        url: url_base + "/Map.php/maps",
        data: $(this).serialize(),
        success: function(msg, status, jqXHR) {
          alert("mrow");
        },
        error: function(jqXHR, status, error) {
          alert("meow");
        }
      }
    );
  });
});
