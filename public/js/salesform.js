// ....................................................................... init
var rowCtr = 0;
var autoCompleteData = null;
var errors = new Array();

$(document).ready(function(){
	$("#row_-rowCtr-").hide();
	$(".subtotalvat").hide();
	$("#errors").hide();
	initCreditDialog();
	initAutoCompleteData();
});

/**
 * Adds a new row in the sales form
 */
function addRow() {
	rowCtr++;
	var template = $("#row_-rowCtr-").html();
	template = template.replace(/-rowCtr-/g, rowCtr);
	template = '<tr id="row_' + rowCtr + '">' + template + '</tr>';
	$("#salesFormBody").append(template);
	initAutoComplete(rowCtr);
	$("#vat_" + rowCtr).change(function(){
		computeSubTotal(rowCtr);
	});	
	$("#remove_" + rowCtr).click(function(){
		$("#row_" + rowCtr).remove();
	});
	bindValidators(rowCtr);
	$("#item_" + rowCtr).focus();
}

// ............................................................... autocomplete
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
 * Initializes the autocomplete textbox for a particular sales form row
 * @param rowCtr
 */
function initAutoComplete(rowCtr) {
	$("#item_" + rowCtr).autocomplete(autoCompleteData, {
		formatItem: function(item) {
			return item.description;
		}
	}).result(function(event, item) {
		doAutoCompleteAction(rowCtr, item);
	});
}

/**
 * Set of actions performed when an item gets selected using the autocomplete textbox
 * @param rowCtr
 * @param item the data container
 */
function doAutoCompleteAction(rowCtr, item) {
	$("#item_id_" + rowCtr).val(item.itemDetailId);
	$("#buyingPrice_" + rowCtr).html(parseFloat(item.buyingPrice).toFixed(2));
	$("#price_" + rowCtr).val(parseFloat(item.buyingPrice).toFixed(2));
}

// ......................................................... total computations
function computeSubTotal(rowCtr) {
	var price = getFloat($("#price_" + rowCtr).val());
	var quantity = getFloat($("#quantity_" + rowCtr).val());
	var discount = getFloat($("#discount_" + rowCtr).val());
	if (price == null || quantity == null || isNaN(price) || isNaN(quantity)) {
		return;
	}
	var subTotal = price * quantity - discount;
	$("#subtotal_" + rowCtr).html(subTotal.toFixed(2));
	
	if ($("#vat_" + rowCtr).prop("checked")) {
		var subTotalVat = subTotal - subTotal / 1.12;
		subTotalVat = subTotalVat.toFixed(2);
		$("#subtotalVat_" + rowCtr).val(subTotalVat);
	} else {
		$("#subtotalVat_" + rowCtr).val(0);
	}
	computeTotal();
}


function resetSubTotal(rowCtr) {
	$("#subtotal_" + rowCtr).html("");
	$("#subtotalVat_" + rowCtr).val(null);
	computeTotal();
}


function computeTotal() {
	var total = 0;
	$('[id*="subtotal_"]:visible').each(function(){
		total += getFloat($(this).html());
	});
	var totalVat = 0;
	$('input[id*="subtotalVat_"]').each(function(){
		totalVat += getFloat($(this).val());
	});
	vatable = total - totalVat;
	$("#vatable").html(vatable.toFixed(2));
	$("#totalvat").html(totalVat.toFixed(2));
	$("#totalprice").html(total.toFixed(2));	
}

// ................................................................. validation
/**
 * Binds validators to the form elements
 * see validator.js
 * @param rowCtr
 */
function bindValidators(rowCtr) {
	var price = $("#price_" + rowCtr);
	var quantity = $("#quantity_" + rowCtr);
	var discount = $("#discount_" + rowCtr);
	var item = $("#item_" + rowCtr);
	
	item.blur(function(){
		if ($.trim(item.val()) == "") {
			showError(item, "Item is required.");
		} else {
			item.removeClass("formError");
		}
	});
	
	price.blur(function(){
		if (isNaN(price.val())) {
			resetSubTotal(rowCtr);
			price.val(null);
			showError(price, "Selling price must be a valid number.");
		} else if (price.val() <= 0) {
			resetSubTotal(rowCtr);
			price.val(null);
			showError(price, "Selling price must be a greater than zero.");
		} else if (discount.val() > (quantity.val() * price.val())) {
			resetSubTotal(rowCtr);
			price.val(null);
			showError(discount, "Discount given cannot be greater than the selling price.");
		} else {
			price.removeClass("formError");
			computeSubTotal(rowCtr);
		}
	});
	
	quantity.blur(function(){
		if (isNaN(quantity.val())) {
			resetSubTotal(rowCtr);
			quantity.val(null);
			showError(quantity, "Quantity must be a valid number.");
		} else if (quantity.val() <= 0) {
			resetSubTotal(rowCtr);
			quantity.val(null);
			showError(quantity, "Quantity must be a greater than zero.");
		} else if (discount.val() > (quantity.val() * price.val())) {
			resetSubTotal(rowCtr);
			quantity.val(null);
			showError(discount, "Discount given cannot be greater than the selling price.");
		} else {
			quantity.removeClass("formError");
			computeSubTotal(rowCtr);
		}
	});

	discount.blur(function(){
		if (isNaN(discount.val())) {
			resetSubTotal(rowCtr);
			discount.val(null);
			showError(discount, "Discount must be a valid number.");
			discount.removeClass("formError");
		} else if (discount.val() > (quantity.val() * price.val())) {
			resetSubTotal(rowCtr);
			discount.val(null);
			showError(discount, "Discount given cannot be greater than the selling price.");
		} else {
			discount.removeClass("formError");
			computeSubTotal(rowCtr);
		}
	});	
}

function checkForm() {
	var errors = new Array();
	$('[id*="price_"]:visible').each(function(){
		var price = $(this);
		if (getFloat($(this).val()) <= 0) {
			resetSubTotal(rowCtr);
			price.addClass("formError");
			errors.push("Selling price must be greater than zero.");
		}
	});
	$('[id*="quantity_"]:visible').each(function(){
		var quantity = $(this);
		if (getFloat($(this).val()) <= 0) {
			resetSubTotal(rowCtr);
			quantity.addClass("formError");
			errors.push("Quantity must be greater than zero.");
		}
	});
	if (errors.length > 0) {
		errors = errors.unique();
		$("#errors").html("");
		for (var i = 0; i < errors.length; i++) {
			 $("#errors").append("<li>" + errors[i] + "</li>");
		}
		$("#errors").show();
		$("#errors").delay(5000).fadeOut(1000);
		return false;
	} else {
		return true;
	}
}

function submitForm(){
	if (checkForm() == true) {
		$("#salesForms").submit();
	}
}

//............................................................... Credit Detail
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

//........................................................... Utility Functions
function getRowCtr(obj) {
	var parts = $(obj).attr("id").split("_");
	return rowId = parts[1];
}