<style>
#salesForm {
	margin: 5px 10px 10px 10px;
}

#salesForm th {
	border-bottom: 1px solid silver;
	text-align: left;
	color: #545454;
	font-weight:bold;
	padding: 5px 3px;
}

#salesForm tr td {
	padding: 5px 3px;
}

#salesControls {
	margin-left: 15px;
}

.removeBtn {
	width: 16px;
	height: 16px;
	background-image: url("/public/images/icons/delete.png");
	cursor: pointer;
}

#creditFormContainer {
    background-color: #EDEFF4;
    border: 1px solid silver;
    border-radius: 5px 5px 5px 5px;
    margin: 40px 10px 10px;
    min-height: 200px;
    padding: 10px 0;
    width: 500px;
}

#creditFormContainer h1 {
    background-color: #6997BF;
    color: #FFFFFF;
    font-size: 12px;
    font-weight: bold;
    margin: 0;
    padding: 3px;
    width: 99%;
}

#creditForm {
	padding: 10px;
}

#creditForm tr td {
	padding: 8px 5px;
}

#creditForm .rightAligned {
	text-align: right;
}

#saleHeader img {
	float: left;
}
#saleHeader div {
    padding-left: 40px;
    padding-top: 5px;
}

#salesControls {
	width: 80%;
	margin-top: 10px;
}

</style>

<h1 id="saleHeader">
	<img src="/public/images/icons/wallet.png" />
	<div>Sales Form</div>
</h1>


<form name="salesForm" id="salesForms" action="/sales/managesalesform" method="POST">
	<table id="salesForm" width="80%">
		<thead>
			<tr>
				<th>Item</th>
				<th width="10%">Price</th>
				<th width="10%">Qty</th>
				<th width="10%">Discount</th>
				<th width="10%">VAT</th>
				<th width="10%">Subtotal</th>
				<th width="2%">&nbsp;</th>
			</tr>
		</thead>
		<tbody id="salesFormBody">
			<tr id="row_-rowCtr-">
				<td>
					<select id="item_-rowCtr-" name="item[]" onchange="updatePrice(this)">
						<option value="0" selected="selected">Select an item</option>
						<?php foreach ($itemDetails as $itemDetail): ?>
						<option value="<?php echo $itemDetail['itemDetailId'] ?>">
							<?php echo $itemDetail['description'] ?>
						</option>
						<?php endforeach; ?>
					</select>
				</td>
				<td>
					<span id="price_-rowCtr-">----</span>
				</td>
				<td>
					<input name = "qty[]" type="text" class="smallTxt rightAligned" id="quantity_-rowCtr-" onblur = "updateSubTotal(this)"/>
				</td>
				<td>
					<input name = "discount[]" type="text" class="smallTxt rightAligned" id="discount_-rowCtr-" onblur = "updateSubTotal(this)" />
				</td>
				<td>
					<input name = "vat[]" type="checkbox" id="vat_-rowCtr-" value="vat_-rowCtr-" onclick = "updateSubTotal(this)" />
				</td>
				<td>
					<span class = "subtotal" id="subtotal_-rowCtr-">----</span>
				</td>
				<td>
					<div class="removeBtn" id="remove_-rowCtr-" onclick="removeRow(this)"></div>
				</td>
				<td>
					<span class = "subtotalvat" id="subtotalvat_-rowCtr-">----</span>
				</td>
			</tr>
		</tbody>
	</table>
	<div id="salesControls" class="rightAligned">
		<a href="javascript:addRow()" >Add a New Row</a> | <a href="javascript:openDialog()">Credit Payment</a> | <a href="javascript:submitForm()">Checkout</a>
	</div>
	<div id = "salesSummary">
		<ul>
			<li id = "vatable"></li>
			<li id = "totalvat"></li>
			<li id = "totalprice"></li>
		</ul>
		<input type="button" onclick="submitForm()" />
	</div>
	<div id="creditFormContainer">
		<h1>Credit Form</h1>
		<table id="creditForm">
			<tr>
				<td class="rightAligned">Name:</td>
				<td><input type="text"/></td>
			</tr>
			<tr>
				<td class="rightAligned">Address:</td>
				<td><input type="text"/></td>
			</tr>
			<tr>
				<td class="rightAligned">Contact Number:</td>
				<td><input type="text"/></td>
			</tr>
			<tr>
				<td class="rightAligned">Amount Paid</td>
				<td><input type="text"/></td>
			</tr>
		</table>
	</div>

</form>


<script type="text/javascript">
	// creates a lookup so that we can update the price
	// without an ajax call
	var priceLookup = new Array();
	<?php foreach ($itemDetails as $itemDetail):?>
		priceLookup["<?php echo $itemDetail['itemDetailId']; ?>"] = "<?php echo $itemDetail['sellingPrice'] ?>";
	<? endforeach; ?>

	var rowCtr = 1;

	$(document).ready(function(){
		$("#row_-rowCtr-").hide();
		addRow();
		addSalesSummary();
		$("#creditFormContainer").hide();
		$(".subtotalvat").hide()
	});

	function updatePrice(obj) {
		var itemSelectedVal = $(obj).val();
		var price = priceLookup[itemSelectedVal];
		var rowId = getRowCtr(obj);
		if (itemSelectedVal == 0) {
			clearRow(rowId);
			return;
		}
		$("#price_" + rowId).html(price);
	}

	function addRow() {
		var template = $("#row_-rowCtr-").html();
		template = template.replace(/-rowCtr-/g, rowCtr);
		template = '<tr id="row_' + rowCtr + '">' + template + '</tr>';
		$("#salesFormBody").append(template);
		rowCtr++;
	}

	function removeRow(obj) {
		rowId = getRowCtr(obj);
		 $("#row_" + rowId).remove();
	}

	function clearRow(rowId) {
		$("#price_" + rowId).html("----");
		$("#qty_" + rowId).val(null);
		$("#discount_" + rowId).val(null);
		$("#vat_" + rowId).attr("checked", false);
		$("#subtotal_" + rowId).html("----");
	}
	function submitForm(){
		if (validateForm() == true) {
		$("#salesForms").submit();
		}
	}
	function updateSubTotal(obj){
		var rowId = getRowCtr(obj);
		var subtotal = computeSubTotal(rowId);
		if (isNaN(subtotal)){
			subtotal = "----";
		}
		else{
			subtotal = subtotal.toFixed(2);
		}1
		$("#subtotal_"+rowId).html(subtotal);
		updateVatSubTotal(obj);
	}

	function updateVatSubTotal(obj){
		var rowId = getRowCtr(obj);
		var subtotal = parseFloat(computeSubTotal(rowId));
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
			if (isNaN(parseFloat($(this).html()))){
				totalvat += 0 ;
			}
			else {
				totalvat += parseFloat($(this).html());
			}
			});
		$(".subtotal:visible").each(function(){
			total += parseFloat($(this).html());
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
		$("#vatable").html("Vatable:	" + vatable);
		$("#totalvat").html("Total VAT:	" + totalvat);
		$("#totalprice").html("Total Price:	" + total);

	}

	function computeSubTotal(rowId) {
		var discount = parseFloat($("#discount_"+rowId).val());
		var quantity = parseFloat($("#quantity_"+rowId).val());
		var price = parseFloat($("#price_"+rowId).html());
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
		console.log(rowCtr);
		return subtotal;
	}



	function validateForm(){
		var isValid = true;
		$("select[id ^= 'item_' ]:visible").each(function(){
			var item = $(this).val();
			if (item == 0){
				$(this).focus();
				alert ("You must choose an item");
				isValid = false;
				return ;
			}
		});
		$("input[id ^= 'quantity_' ]:visible").each(function(){
			var quantity = $(this).val();
			if (quantity <= 0){
				$(this).val("");
				$(this).focus();
				alert ("Quantity must be greater than 0");
				isValid = false;
				return ;
			}
			else if (isNaN(quantity)){
				$(this).val("");
				$(this).focus();
				alert ("Quantity must be a number");
				isValid = false;
				return ;
			}
		});
		$("input[id ^= 'discount_' ]:visible").each(function(){
			var discount = $(this).val();
			if (discount < 0){
				$(this).val("0.00");
				$(this).focus();
				alert ("Discount must be greater or equal to 0");
				isValid = false;
				return ;
			}
			else if (isNaN(discount)){
				$(this).val("0.00");
				$(this).focus();
				alert ("Discount must be a number");
				isValid = false;
				return ;
			}
		});

		return isValid;
	}

	function getRowCtr(obj) {
		var parts = $(obj).attr("id").split("_");
		return rowId = parts[1];
	}

	function openDialog() {
		//$("#creditFormContainer").dialog("open");
		$("#creditFormContainer").slideToggle('slow');
	}
	function addSalesSummary() {
		$("#vatable").html("Vatable: ---- ");
		$("#totalvat").html("Total VAT: ----")
		$("#totalprice").html("Total Price: ----")
	}


</script>




	<?php /*?>

	<ul class="sales_form_container">
		<li>
			<ul id="salesFormHeader">
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
<?php*/?>