<style>
#salesForm {
	margin: 5px 10px 10px 5px;
	width: 750px;
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
	width: 750px;
	margin-left: 35px;
}

#salesSummary {
	margin-top: 5px;
	margin-left: 570px;
}

.salesSummaryLabel {
	font-weight:bold;
	width: 70px;
	padding-right: 10px;
	padding-top: 3px;
}

#error{
	text-align: center;
	font-size: 15px;
	width : 40%;
	margin : auto;
}
</style>
<div id ="error">
	<div id = "itemerror"></div>
	<div id = "qtyerror"></div>
	<div id = "discounterror"></div>
	<div id = "crediterror"></div>
</div>
<h1 id="saleHeader">
	<img src="/public/images/icons/wallet.png" />
	<div>Sales Form</div>
</h1>

<form name="salesForm" id="salesForms" action="/sales/processsalesform" method="POST">
	<table id="salesForm">
		<thead>
			<tr>
				<th>Item</th>
				<th width="100px">Price</th>
				<th width="20px">Qty</th>
				<th width="50px">Discount</th>
				<th width="20px">VAT</th>
				<th width="100px">Subtotal</th>
				<th width="10px">&nbsp;</th>
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
					<input name = "qty[]" type="text" class="smallTxt rightAligned" id="quantity_-rowCtr-" onblur="updateSubTotal(this)"/>
				</td>
				<td>
					<input name = "discount[]" type="text" class="smallTxt rightAligned" id="discount_-rowCtr-" onblur="updateSubTotal(this)" />
				</td>
				<td>
					<input name = "vat[]" type="checkbox" id="vat_-rowCtr-" value="vat_-rowCtr-" onclick="updateSubTotal(this)" />
				</td>
				<td>
					<span class = "subtotal" id="subtotal_-rowCtr-">----</span>
				</td>
				<td>
					<div class="removeBtn" id="remove_-rowCtr-" onclick="removeRow(this)"></div>
				</td>
				<td>
					<span class="subtotalvat" id="subtotalvat_-rowCtr-">----</span>
				</td>
			</tr>
		</tbody>
	</table>

	<div id="salesControls">
		<a href="javascript:addRow()" >Add a New Row</a> | <a href="javascript:openDialog()">Credit Payment</a> | <a href="javascript:submitForm()">Checkout</a>-
	</div>

	<div id="salesSummaryContainer">
		<table id="salesSummary">
			<tr>
				<td class="rightAligned salesSummaryLabel">Vatable:</td>
				<td><div class="salesSummaryValue" id="vatable"></div></td>
			</tr>
			<tr>
				<td class="rightAligned salesSummaryLabel">Total Vat:</td>
				<td><div class="salesSummaryValue" id="totalvat"></div></td>
			</tr>
			<tr>
				<td class="rightAligned salesSummaryLabel">Total Price:</td>
				<td><div class="salesSummaryValue" id="totalprice"></div></td>
			</tr>
		</table>
	</div>

	<div id="creditFormContainer">
		<h1>Credit Form</h1>
		<table id="creditForm">
			<tr>
				<td class="rightAligned">Name:</td>
				<td><input type="text" name="name" id="name"></td>
			</tr>
			<tr>
				<td class="rightAligned">Address:</td>
				<td><textarea rows="3" cols="22" name="address" id="address"></textarea></td>
			</tr>
			<tr>
				<td class="rightAligned">Contact Number:</td>
				<td><input type="text" name="phoneno" id="phoneno" /></td>
			</tr>
			<tr>
				<td class="rightAligned">Amount Paid</td>
				<td><input type="text" name="amountpaid" id="amountpaid"/></td>
			</tr>
		</table>
	</div>

</form>


<script type="text/javascript">
	// creates a lookup so that we can update the price without an ajax call
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
		$(".subtotalvat").hide();
	});

	function updatePrice(obj) {
		var itemSelectedVal = $(obj).val();
		var price = priceLookup[itemSelectedVal];
		var rowId = getRowCtr(obj);
		if (itemSelectedVal == 0) {
			clearRow(rowId);
			return;
		}
		price = parseFloat(price).toFixed(2);
		price = addCommas(price);
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

	function openDialog() {
		$("#creditFormContainer").slideToggle('slow');
	}
	function addSalesSummary() {
		$("#vatable").html("---- ");
		$("#totalvat").html("----");
		$("#totalprice").html("----");
	}
</script>
