function hideDice(){
    $("#d1, #d2, #d3, #d4, #d5, #d6, #dicemenu").hide();
};
hideDice();

$(document).ready(
	function(){
		$("#dice").click( function () {
			$("#dicemenu").show("slow");
		});
		
		$("#d1click").click( function () {
			$("#d1").show("slow");
		});
	
		$("#d2click").click( function () {
			$("#d2").show("slow");
		});
		
		$("#d3click").click( function () {
			$("#d3").show("slow");
		});
		
		$("#d4click").click( function () {
			$("#d4").show("slow");
		});
		
		$("#d5click").click( function () {
			$("#d5").show("slow");
		});
		
		$("#d6click").click( function () {
			$("#d6").show("slow");
		});
		
		$("#closed1").click( function () {
			$("#d1").hide();
		});
		
		$("#closed2").click( function () {
			$("#d2").hide();
		});
		
		$("#closed3").click( function () {
			$("#d3").hide();
		});
		
		$("#closed4").click( function () {
			$("#d4").hide();
		});
		
		$("#closed5").click( function () {
			$("#d5").hide();
		});
		
		$("#closed6").click( function () {
			$("#d6").hide();
		});
		
		$("#close").click( function () {
            hideDice();
		});
	}
)
