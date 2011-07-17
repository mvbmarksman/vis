var rowCtr = 1;
var autoCompleteData = null;

$(document).ready(function(){
	$("#row_-rowCtr-").hide();
	$(".subtotalvat").hide();
	initCreditDialog();
	initAutoCompleteData();
});


/**
 * Fetches the data used for autocomplete suggestions
 * @returns JSON
 */
function initAutoCompleteData() {
	$.post('/sales/getautocompletedata', {}, function(data){
		autoCompleteData = eval(data);
		addRow();
	});
}

/**
 * Adds a new row in the sales form
 */
function addRow() {
	var template = $("#row_-rowCtr-").html();
	template = template.replace(/-rowCtr-/g, rowCtr);
	template = '<tr id="row_' + rowCtr + '">' + template + '</tr>';
	$("#salesFormBody").append(template);
	initAutoComplete(rowCtr);
	rowCtr++;
}

/**
 * Initializes the autocomplete textbox for a particular sales form row
 * @param rowCtr
 */
function initAutoComplete(rowCtr) {
	$("#item_" + rowCtr).autocomplete(autoCompleteData, {
		formatItem: function(item) {
			return item.description;
		}
	}).result(function(event, item) {
		$("#item_id_" + rowCtr).val(item.itemDetailId);
	});
}

/**
 * Removes a row in the sales form
 * @param obj
 */
function removeRow(obj) {
	rowId = getRowCtr(obj);
	 $("#row_" + rowId).remove();
}

/**
 * Clears a sales form row
 * @param rowId
 */
function clearRow(rowId) {
	$("#price_" + rowId).html("");
	$("#qty_" + rowId).val(null);
	$("#discount_" + rowId).val(null);
	$("#vat_" + rowId).attr("checked", false);
	$("#subtotal_" + rowId).html("");
}

/**
 * Initialize the modal dialog for getting credit detail information
 */
function initCreditDialog() {
	$("#creditFormContainer").hide();
	$("#creditFormContainer").dialog({
		autoOpen: false,
		modal: true,
		title: "Credit Information",
		width: 400,
		height: 280,
		resizable: false
	});
	$("#creditContainer").hide();
}

/**
 * Launch the credit detail form modal dialog
 */
function openDialog() {
	$("#creditFormContainer").dialog("open");
}

/**
 * Saves the values entered in the credit modal dialog into the sales form
 */
function saveCredit() {
	var name = $("#name").val();
	$("#creditName span").html(name);
	$("#creditName input").val(name);

	var address = $("#address").val();
	$("#creditAddress span").html(address);
	$("#creditAddress input").val(address);

	var contact = $("#contact").val();
	$("#creditContact span").html(contact);
	$("#creditContact input").val(contact);

	var amount = $("#amountpaid").val();
	$("#creditAmount span").html(amount);
	$("#creditAmount input").val(amount);

	$("#creditContainer").fadeIn();
	$("#creditFormContainer").dialog("close");

	$("#creditDetailsBtn img").prop("src", "/public/images/icons/delete2.png");
	$("#creditDetailsBtn p").html("Clear Credit Details");
	$("#creditDetailsBtn").prop("href", "javascript:clearCredit()");
}

function clearCredit() {
	$("#creditContainer input").each(function(){
		$(this).val("");
	});
	$("#creditContainer").hide();
	$("#creditDetailsBtn img").prop("src", "/public/images/icons/add.png");
	$("#creditDetailsBtn p").html("Add Credit Details");
	$("#creditDetailsBtn").prop("href", "javascript:openDialog()");
}

function updatePrice(obj) {
	var itemSelectedVal = $(obj).val();
	var price = priceLookup[itemSelectedVal];
	var rowId = getRowCtr(obj);
	if (itemSelectedVal == 0) {
		clearRow(rowId);
		return;
	}
	$("#item_"+rowId).css("border-color","#8EA7D1");
	price = parseFloat(price).toFixed(2);
	price = addCommas(price);
	$("#price_" + rowId).html(price);
	$("#quantity_" + rowId).focus();
}

function submitForm(){
	if (validateForm() == true) {
	$("#salesForms").submit();
	}
}
function updateSubTotal(obj){
	var rowId = getRowCtr(obj);
	var subtotal = computeSubTotal(rowId);
	var quantityVal = $("#quantity_" + rowId).val();
	var discountVal = $("#discount_" + rowId).val();

	if (quantityVal <= 0 || isNaN(quantityVal)) {
		$("#qtyerror").show().html("<p style = 'margin : 3px; background-color:red; border-radius:5px'>Quantity error");
		$("#quantity_" + rowId).css("border-color","#F5646C");
		$("#qtyerror").delay(3000).fadeOut(1000);
		$("#quantity_" + rowId).focus();
	} else {
		$("#quantity_" + rowId).css("border-color","#8EA7D1");
	}

	if (discountVal < 0 || isNaN(discountVal)) {
		$("#discounterror").show().html("<p style = 'margin : 3px; background-color:red; border-radius:5px'>Discount error");
		$("#discount_" + rowId).css("border-color","#F5646C");
		$("#discounterror").delay(3000).fadeOut(1000);
		$("#discount_" + rowId).focus();
	} else {
		$("#discount_" + rowId).css("border-color","#8EA7D1");
	}

	if (isNaN(subtotal)){
		subtotal = "";
	}
	else{
		subtotal = subtotal.toFixed(2);
	}
	$("#subtotal_"+rowId).html(subtotal);
	updateVatSubTotal(obj);
}

function updateVatSubTotal(obj){
	var rowId = getRowCtr(obj);
	var subtotal = getFloat(computeSubTotal(rowId));
	var subtotalVAT = subtotal - subtotal / 1.12;
	subtotalVAT = subtotalVAT.toFixed(2);
	if ($("#vat_"+rowId).first().prop("checked")){
		$("#subtotalvat_"+rowId).html(subtotalVAT);
	}
	else {
		$("#subtotalvat_"+rowId).html("0");
	}
	computeTotal();
}


function computeTotal() {
	var total = 0.00;
	var totalvat = 0.00;
	$(".subtotalvat").each(function(){
		if (isNaN(getFloat($(this).html()))){
			totalvat += 0 ;
		}
		else {
			totalvat += getFloat($(this).html());
		}
		});
	$(".subtotal:visible").each(function(){
		total += getFloat($(this).html());
		});
	if (totalvat > 0){
		vatable = total - totalvat;
		}
	else{
		vatable = 0;
		}
	if (isNaN(total)){
		addSalesSummary();
		return;
	}
	else{
		total = total.toFixed(2);
		totalvat = totalvat.toFixed(2);
	}
	$("#vatable").html(vatable);
	$("#totalvat").html(totalvat);
	$("#totalprice").html(total);

}

function computeSubTotal(rowId) {
	var discount = getFloat($("#discount_"+rowId).val());
	var quantity = getFloat($("#quantity_"+rowId).val());
	var price = getFloat($("#price_"+rowId).html());
	if (isNaN(quantity)){
		quantity = 0;
	}
	if (isNaN(discount)){
		discount = 0;
	}
	var subtotal = quantity * price -discount;
	if (isNaN(subtotal)){
		subtotal = "---";
	}
	return subtotal;
}



function validateForm(){
	var isValid = true;
	$("select[id ^= 'item_' ]:visible").each(function(){
		var item = $(this).val();
		if (item == 0){
			$("#itemerror").show().html("<p style = 'margin : 3px; background-color:red; border-radius:5px'>You must choose an item ");
			$("#itemerror").delay(2000).fadeOut(1000);
			$(this).css("border-color","#F5646C");
			isValid = false;
		}
	});
	var qtyNaNError = false;
	var qtyNotCountingNoError
	$("input[id ^= 'quantity_' ]:visible").each(function(){
		var quantity = $(this).val();
		if (quantity <= 0){
			$(this).css("border-color","#F5646C");
			$(this).focus();
			$("#qtyerror").show().html("<p style = 'margin : 3px; background-color:red; border-radius:5px'>Quantity must be greater than 0 ");
			$("#qtyerror").delay(3000).fadeOut(1000);
			isValid = false;
		}
		else if (isNaN(quantity)){
			$(this).css("border-color","#F5646C");
			$(this).focus();
			$("#qtyerror").show().html("<p style = 'margin : 3px; background-color:red; border-radius:5px'>Quantity must be a number ");
			$("#qtyerror").delay(3000).fadeOut(1000);
			isValid = false;
		}
	});
	$("input[id ^= 'discount_' ]:visible").each(function(){
		var discount = $(this).val();
		if (discount < 0){
			$(this).css("border-color","#F5646C");
			$(this).focus();
			$("#discounterror").show().html("<p style = 'margin : 3px; background-color:red; border-radius:5px'>Discount must be greater or equal to 0 ");
			$("#discounterror").delay(4000).fadeOut(1000);
			isValid = false;
		}
		else if (isNaN(discount)){
			$(this).css("border-color","#F5646C");
			$(this).focus();
			$("#discounterror").show().html("<p style = 'margin : 3px; background-color:red; border-radius:5px'>Discount must be a number ");
			$("#discounterror").delay(4000).fadeOut(1000);
			isValid = false;
		}
	});

	if (!($("#creditFormContainer")).is(":visible")) {
		return isValid;
	}

	if (isNaN(($("input#amountpaid")).val()))
	{
		$("input#amountpaid").css("border-color","#F5646C");
		$("input#amountpaid").val("");
		$("#crediterror").show().html("<p style = 'margin : 3px; background-color:red; border-radius:5px'>Amount Paid must be a number ");
		$("#crediterror").delay(4000).fadeOut(1000);
		isValid = false;
	}

	if ((($("input#amountpaid")).val())>= parseInt(($("#totalprice").html())))
	{
		$("input#amountpaid").css("border-color","#F5646C");
		$("input#amountpaid").val("");
		$("#crediterror").show().html("<p style = 'margin : 3px; background-color:red; border-radius:5px'>Amount paid must be less than the total price ").delay(1000).fade(5000);
		$("#crediterror").delay(4000).fadeOut(1000);
		isValid = false;
	}
	if (($("input#amountpaid").val()) == "")
	{
		$("input#amountpaid").css("border-color","#F5646C");
		$("input#amountpaid").val("");
		$("#crediterror").show().html("<p style = 'margin : 3px; background-color:red; border-radius:5px'>Amount paid should not be empty <p>");
		$("#crediterror").delay(4000).fadeOut(1000);
		isValid = false;
	}
	$("#error").fadeout(10000);
	return isValid;
}

function getRowCtr(obj) {
	var parts = $(obj).attr("id").split("_");
	return rowId = parts[1];
}
