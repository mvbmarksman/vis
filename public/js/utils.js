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

Array.prototype.unique =
	  function() {
	    var a = [];
	    var l = this.length;
	    for(var i=0; i<l; i++) {
	      for(var j=i+1; j<l; j++) {
	        // If this[i] is found later in the array
	        if (this[i] === this[j])
	          j = ++i;
	      }
	      a.push(this[i]);
	    }
	    return a;
	  };
	  
