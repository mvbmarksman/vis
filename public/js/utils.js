function addCommas(nStr)
{
	nStr += '';
	x = nStr.split('.');
	x1 = x[0];
	x2 = x.length > 1 ? '.' + x[1] : '';
	var rgx = /(\d+)(\d{3})/;
	while (rgx.test(x1)) {
		x1 = x1.replace(rgx, '$1' + ',' + '$2');
	}
	return x1 + x2;
}

function formatMoney(amt) {
	return addCommas(amt.toFixed(2));
}


function empty(str) {
	if ($.trim(str) == "") {
		return true;
	}
	return false;
}


function getFloat(str, decimalPlaces) {
	if (!str) {
		return null;
	}
	str += "";
	var newStr = str.replace(",", "");
	return parseFloat(newStr);
}

function capitaliseFirstLetter(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
}


function getIdsForDelete(formObj, name)
{
	var ids = new Array();
	var objs = $(formObj).find(":input[name='"+name+"']:checked").each(function(){
		ids.push($(this).val());
	});
	if (ids.length == 0) {
		return null;
	}
	return ids.join(",");
}

