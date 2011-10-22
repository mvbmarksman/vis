// ....................................................................... init
var rowCtr = 0;
var autoCompleteData = null;

var ERROR_DELAY = 10000;
var ERROR_FADE = 1000;

$(document).ready(function(){
	$("#row_-rowCtr-").hide();
	addRow();
});



/**
 * Adds a new row in the sales form
 */
function addRow() {
	rowCtr++;
	var template = $("#row_-rowCtr-").html();
	template = template.replace(/-rowCtr-/g, rowCtr);
	template = '<tr id="row_' + rowCtr + '">' + template + '</tr>';
	$("#inventoryFormBody").append(template);

	$("#vat_" + rowCtr).change(function(){
		var rowCtr = getRowCtr(this);
		computeSubTotal(rowCtr);
	});	

	$("#remove_" + rowCtr).click(function(){
		var rowCtr = getRowCtr(this);
		$("#row_" + rowCtr).remove();
	});

	$("#item_" + rowCtr).focus();
}

//........................................................... Utility Functions
function getRowCtr(obj) {
	var parts = $(obj).attr("id").split("_");
	return rowId = parts[1];
}
