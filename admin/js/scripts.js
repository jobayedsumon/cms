
var div_box = "<div id='load-screen'><div id='loading'></div></div>";

$("body").prepend(div_box);

$("#load-screen").delay(0).fadeOut(700, function() {
	$(this).remove();


});

$(document).ready(function() {

	tinymce.init({ selector:'textarea' });

	$("#selectAllBoxes").click(function(event) {

		if(this.checked) {

			$(".checkBoxes").each(function() {
				this.checked = true;
			});

		} else {

			$(".checkBoxes").each(function() {
				this.checked = false;
			});
		}

	});
	
});

function loadUsersOnline() {

	$.get("functions.php?onlineusers=result", function(data) {

		$(".usersonline").text(data);

	});

}

setInterval(function() {

	loadUsersOnline();

}, 3000);



