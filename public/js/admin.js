var MSG_DELAY = 10000;
var MSG_FADE = 1000;


function flashMsg(message)
{
	$("#errorMsg").hide();
	$("#flashMsg").html(message);
	$("#flashMsg").show();
	$("#flashMsg").delay(MSG_DELAY).fadeOut(MSG_FADE);
}


function flashError(message)
{
	$("#flashMsg").hide();
	$("#errorMsg").html(message);
	$("#errorMsg").show();
	$("#errorMsg").delay(MSG_DELAY).fadeOut(MSG_FADE);
}