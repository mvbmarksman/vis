// ....................................................................... init
var rowCtr = 0;
var autoCompleteData = null;

var ERROR_DELAY = 10000;
var ERROR_FADE = 1000;

$(document).ready(function(){
	$("#row_-rowCtr-").hide();
	$(".subtotalvat").hide();
	$("#errors").hide();
	initAutoCompleteData();
	initCustomerAutoComplete();
	$("#addressRow").hide();
	$("#contactRow").hide();
	$("#newCustomerYes").click(newCustomerMode);
	$("#newCustomerNo").click(returningCustomerMode);
	$("#newCustomerNo").click();
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
	$("#item_" + rowCtr).autocomplete({
		minLength: 0,
		source: autoCompleteData,
		select: function(event, ui) {
			$("#item_" + rowCtr).val(ui.item.description);
			doAutoCompleteAction(rowCtr, ui.item);
			return false;
		},
		change: function(event, ui) { 
			if (ui.item == null) {
				showError($("#item_" + rowCtr), "Invalid item. Please select an item from the list");
				$("#item_" + rowCtr).val(null);
				$("#item_id_" + rowCtr).val(null);
				$("#price_" + rowCtr).val(null);
				$("#buyingPrice_" + rowCtr).html(null);
			}
		}		
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
	$("#quantity_" + rowCtr).focus();
}


function initCustomerAutoComplete() {
	$.post('/customer/getcustomerautocompletedata', {}, function(data){
		var customerData = eval(data);
		$("#name").autocomplete({
			minLength: 0,
			source: customerData,
			select: function(event, ui) {
				$("#name").val(ui.item.fullname);
				doCustomerAutoCompleteAction(ui.item);
				return false;
			},
			change: function(event, ui) { 
				if (ui.item == null) {
					
				}
			}
		});	
	});
}

function doCustomerAutoCompleteAction(item) {
	$("#customerId").val(item.customerId);
	$("#addressRow").show();
	$("#address").val(item.address);
	$("#contactRow").show();
	$("#contact").val(item.phoneNo);
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
	$("#subtotaldisplay_" + rowCtr).html(formatMoney(subTotal));
	$("#subtotal_" + rowCtr).html(subTotal);
	
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
	$("#subtotal_" + rowCtr).val(0);
	$("#subtotalVat_" + rowCtr).val(0);
	computeTotal();
}


function computeTotal() {
	var total = 0;
	$('input[id*="subtotal_"]').each(function(){
		total += getFloat($(this).html());
	});
	var totalVat = 0;
	$('input[id*="subtotalVat_"]').each(function(){
		totalVat += getFloat($(this).val());
	});
	vatable = total - totalVat;
	$("#vatable").html(formatMoney(vatable));
	$("#totalvat").html(formatMoney(totalVat));
	$("#totalprice").html(formatMoney(total));
	$("#amountPaid").val(total.toFixed(2));
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
			discount.val(0);
			showError(discount, "Discount must be a valid number.");
			discount.removeClass("formError");
		} else if (discount.val() > (quantity.val() * price.val())) {
			resetSubTotal(rowCtr);
			discount.val(0);
			showError(discount, "Discount given cannot be greater than the selling price.");
			discount.removeClass("formError");
		} else {
			discount.removeClass("formError");
			computeSubTotal(rowCtr);
		}
	});
	
	var amountPaid = $("#amountPaid");
	amountPaid.blur(function(){
		if (isNaN(amountPaid.val())) {
			amountPaid.val(0);
			showError(amountPaid, "Amount paid should be a valid number.");
		}
	});
	
	var name = $("#name");
	name.blur(function(){
		if (empty(name.val())) {
			$("#address").val(null);
			$("#contact").val(null);
			$("#customerId").val(null);
			showError(name, "Customer name is required.");
		} else {
			name.removeClass("formError");
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

	$('[id*="item_"]:visible').each(function(){
		var item = $(this);
		if (empty(item.val())) {
			item.addClass("formError");
			errors.push("Item is required.");
		}
	});	
	
	var name = $("#name");
	if (empty(name.val())) {
		name.addClass("formError");
		errors.push("Customer name is required.");
	}
	
	if (errors.length > 0) {
		errors = errors.unique();
		$("#errors").html("");
		for (var i = 0; i < errors.length; i++) {
			 $("#errors").append("<li>" + errors[i] + "</li>");
		}
		$("#errors").show();
		$("#errors").delay(ERROR_DELAY).fadeOut(ERROR_FADE);
		return false;
	} else {
		return true;
	}
}

function showError(obj, msg) {
	$(obj).addClass("formError");
	 $("#errors").html("<li>" + msg + "</li>");
	 $("#errors").show();
	 $("#errors").delay(ERROR_DELAY).fadeOut(ERROR_FADE);
}

function submitForm(){
	if (checkForm() == true) {
		$("#salesForms").submit();
	}
}

function newCustomerMode() {
	$("#addressRow").show();
	$("#contactRow").show();
	$("#customerId").val(null);
	$("#address").val(null);
	$("#contact").val(null);
	$("#name").autocomplete({ disabled: true });
}

function returningCustomerMode() {
	$("#name").autocomplete({ disabled: false});
	$("#name").val(null);
	$("#addressRow").hide();
	$("#contactRow").hide();
}


//........................................................... Utility Functions
function getRowCtr(obj) {
	var parts = $(obj).attr("id").split("_");
	return rowId = parts[1];
}