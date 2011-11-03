var ERROR_DELAY = 10000;
var ERROR_FADE = 1000;

function fadeSystemMessages() {
	$(".message-error").delay(ERROR_DELAY).fadeOut(ERROR_FADE);
	$(".message-notice").delay(ERROR_DELAY).fadeOut(ERROR_FADE);
	$(".message-success").delay(ERROR_DELAY).fadeOut(ERROR_FADE);
}