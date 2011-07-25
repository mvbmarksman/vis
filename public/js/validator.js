function numberValidator(obj, msg) {
	if (isNaN(obj.val())) {
		showError(obj, msg);
	} else {
		obj.removeClass("formError");
	}
}

function greaterThanZeroValidator(obj, msg) {
	if (obj.val() <= 0) {
		showError(obj, msg);
	} else {
		obj.removeClass("formError");
	}
}


function discountValidator(discountObj, sellingPriceObj, qtyObj, msg) {
	if (discountObj.val() > (sellingPriceObj.val() * qtyObj.val())) {
		showError(discountObj, msg);
	} else {
		discountObj.removeClass("formError");
	}
}

function showError(obj, msg) {
	$(obj).addClass("formError");
	 $("#errors").html("<li>" + msg + "</li>");
	 $("#errors").show();
	 $("#errors").delay(5000).fadeOut(1000);
}