<style>
.sales_form_container li ul li {
	float: left;
	margin: 5px 15px;
}

.sales_form_row {
	clear:both;
}
</style>

<form name="salesform" id="salesform" action="/sales/managesalesform" method="POST">
	<ul class="sales_form_container">
		<li>
			<ul>
				<li>Item</li>
				<li>Price</li>
				<li>Qty</li>
				<li>Discount</li>
				<li>VAT</li>
				<li>Subtotal</li>
			</ul>
		</li>
	</ul>
	<div class="clear"></div>
	<ul>
		<li id="vatable">Vatable</li>
		<li id="totalvat">TotalVAT</li>
		<li id="total">Total</li>
	</ul>
	<input type="button" value="Submit" onClick = "submitForm()" >
</form>

<!-- used as template for dynamically adding rows -->
<div id="tpl" style="display:none">
	<li id="row_1">
		<ul class="sales_form_row">
			<li class="itemDetails">
				<select name="item[]" onchange="updatePrice(this)">
					<?php foreach ($itemDetails as $itemDetail): ?>
					<option value="<?php echo $itemDetail['itemDetailId'] ?>">
						<?php echo $itemDetail['description'] ?>
					</option>
					<?php endforeach; ?>
				</select>
			</li>
			<li class="sellingPrice">
				<?php echo $itemDetails[0]['sellingPrice'];?>
			</li>
			<li class="quantity">
				<input type="text" name="qty[]" size ="3" value="0" onblur="updateSubTotal(this)"/>
			</li>
			<li class="discount">
				<input type="text" size ="6" name="discount[]" onblur="updateSubTotal(this)" value="0.00"/>
			</li>
			<li class="vat">
				<input type="checkbox" name="vat[]" onclick="updateVatSubTotal(this)" value="0" />
			</li>
			<li class="subtotal">
				0.00
			</li>
			<li class="subtotalVAT">
				<input type="hidden" value="0.00" />
			</li>
			<li class="controls">
				<input type="button" value="add" onclick="addRow(this),updateSubTotal(this)">
			</li>
		</ul>
	</li>
</div>

<script type="text/javascript">
var priceLookup = new Array();
<?php foreach ($itemDetails as $itemDetail):?>
	priceLookup["<?php echo $itemDetail['itemDetailId']; ?>"] = "<?php echo $itemDetail['sellingPrice'] ?>";
<? endforeach; ?>
var ctr = 0;
var subtotalVATable = 0;

$(document).ready(function(){
	setupRowTemplate();
	$("#vatable").html("VATable: 0.00");
	$("#totalvat").html("Total VAT: 0.00");
	$("#total").html("Total: 0.00");

});

function addRow(obj) {
	updateVatSubTotal(obj);
	if (validateRow(obj) == true){
		$(obj).attr("value", "remove");
		$(obj).attr("onclick", "removeRow(this)");
		setupRowTemplate();
	}
}

function setupRowTemplate() {
	// get the first li in the template and set the ID
	var row = $("#tpl").children()[0];
	$(row).attr("id", "row_" + ++ctr);

	var cells = $(row).children().first().children().each(function(i){
		this.id = this.className + "_" + ctr;
	});

	$("#vat_" + ctr).children().first().attr("value", ctr);
	$(".sales_form_container").append($("#tpl").html());
}

var removeRow = function(obj) {
	computeTotal();
	$(obj).parent().parent().parent().remove();
}

function submitForm(){
	if (validateForm() == true) {
	$("#salesform").submit();
	}
}
function updatePrice(obj) {
	var itemSelectedVal = $(obj).val();
	$(obj).parent().next().html(priceLookup[itemSelectedVal]);
	var rowNo = getRowNo(obj);
	$(".discount:#discount_"+rowNo).children().val("0.00");
	$(".quantity:#quantity_"+rowNo).children().val("0");
	$(".subtotal:#subtotal_"+rowNo).html("0.00");

}

function updateSubTotal(obj){
	var rowNo = getRowNo(obj);
	var subtotal = computeSubTotal(rowNo);
	subtotal = subtotal.toFixed(2);
	$(".subtotal:#subtotal_"+rowNo).html(subtotal);
	updateVatSubTotal(obj);
	computeTotal();
}

function updateVatSubTotal(obj){
	var rowNo = getRowNo(obj);
	var subtotal = parseFloat(computeSubTotal(rowNo));
	var subtotalVAT = subtotal / 1.12;
	subtotalVAT = subtotalVAT.toFixed(2);
	if ($(".vat:#vat_"+rowNo).children().first().prop("checked")){
		$(".subtotalVAT:#subtotalVAT_"+rowNo).children().first().val(subtotalVAT);
	}
	else {
		$(".subtotalVAT:#subtotalVAT_"+rowNo).children().first().val("0.00");
	}
	computeTotal();
}
function computeTotal() {
	var total = 0.00;
	var Vatable = 0.00;
	$(".subtotalVAT").each(function(){
		Vatable += parseFloat($(this).children().val());
		});
	$(".subtotal:visible").each(function(){
		total += parseFloat($(this).html());
		});
	total = total.toFixed(2);
	vatable = Vatable.toFixed(2);
	if (vatable > 0){
		totalvat = total - vatable;
	}
	else{
		totalvat = 0;
	}
	totalvat = totalvat.toFixed(2);
	$("#vatable").html("VATable: " + vatable);
	$("#totalvat").html("Total VAT: " + totalvat);
	$("#total").html("Total: " + total);

}

function computeSubTotal(rowNo) {
	var discount = parseFloat($(".discount:#discount_"+rowNo).children().val());
	var quantity = parseFloat($(".quantity:#quantity_"+rowNo).children().val());
	var price = parseFloat($(".sellingPrice:#sellingPrice_"+rowNo).html());
	var subtotal = quantity * price -discount;
	return subtotal;
}

function validateRow(obj){
	var rowNo = getRowNo(obj);
	var quantity = $(".quantity:#quantity_"+rowNo).children().val();
	var discount = $(".discount:#discount_"+rowNo).children().val();
	if (quantity <= 0){
		$(".quantity:#quantity_"+rowNo).children().focus();
		alert ("Quantity must be greater than 0");
		$(".quantity:#quantity_"+rowNo).children().val("0");
		return false;
	}
	else if
		(isNaN(quantity)){
		$(".quantity:#quantity_"+rowNo).children().focus();
		alert ("Quantity must be a number");
		$(".quantity:#quantity_"+rowNo).children().val("0");
		return false;
	}

	else if (discount < 0){
		$(".discount:#discount_"+rowNo).children().focus();
		alert ("Discount must be greater than or equal to 0");
		$(".discount:#discount_"+rowNo).children().val("0.00");
		return false;
	}
	else if
		(isNaN(discount)){
		$(".discount:#discount_"+rowNo).children().focus();
		alert ("Discount must be a number");
		$(".discount:#discount_"+rowNo).children().val("0.00");
		return false;
	}
	else{
		return true;
	}
}


function validateForm(){
	var isValid = true;
	$(".quantity:visible").each(function(){
		var quantity = $(this).children().val();
		console.log(quantity);
		if (quantity <= 0){
			$(this).children().val("0");
			$(this).children().focus();
			alert ("Quantity must be greater than 0");
			isValid = false;
			return ;
		}
		else if (isNaN(quantity)){
			$(this).children().val("0");
			$(this).children().focus();
			alert ("Quantity must be a number");
			isValid = false;
			return ;
		}
	});
	$(".discount:visible").each(function(){
		var discount = $(this).children().val();
		if (discount < 0){
			$(this).children().val("0.00");
			$(this).children().focus();
			alert ("Discount must be greater or equal to 0");
			isValid = false;
			return ;
		}
		else if (isNaN(discount)){
			$(this).children().val("0.00");
			$(this).children().focus();
			alert ("Discount must be a number");
			isValid = false;
			return ;
		}
	});
	return isValid;
}


function getRowNo(obj){
	var rowId = ($(obj).parent().parent().parent().attr("id"));
	var parts = rowId.split("_");
	return parts[1];
}





</script>
