<div id ="error">
	<div id = "itemerror"></div>
	<div id = "qtyerror"></div>
	<div id = "discounterror"></div>
	<div id = "crediterror"></div>
</div>
<h1>
	<img src="/public/images/icons/wallet.png" />
	<div>Sales Form</div>
</h1>
<div class="clear"></div>
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
					<span id="price_-rowCtr-"></span>
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
					<span class = "subtotal" id="subtotal_-rowCtr-"></span>
				</td>
				<td>
					<div class="removeBtn" id="remove_-rowCtr-" onclick="removeRow(this)"></div>
				</td>
				<td>
					<span class="subtotalvat" id="subtotalvat_-rowCtr-"></span>
				</td>
			</tr>
		</tbody>
	</table>

	<div id="salesControls">
		<a href="javascript:addRow()" >Add a New Row</a>
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

	<div id="creditContainer">
		<h2>Credit Details</h2>
		<dl>
			<dt>Name:</dt><dd id="creditName"><span></span><input type="hidden" name="creditName"/></dd>
			<dt class="hiliteRow">Address:</dt><dd id="creditAddress" class="hiliteRow"><span></span><input type="hidden" name="creditAddress"/></dd>
			<dt>Contact Number:</dt><dd id="creditContact"><span></span><input type="hidden" name="creditContact"/></dd>
			<dt class="hiliteRow">Amount Paid:</dt><dd id="creditAmount" class="hiliteRow"><span></span><input type="hidden" name="creditAmount"/></dd>
		</dl>
	</div>

</form>

<div class="controls">
	<div class="btnClear" style="margin-left: 410px;" >
		<a class="button" href="javascript:openDialog()" id="creditDetailsBtn"><span><img src="/public/images/icons/add.png"/><p>Add Credit Details</p></span></a>
		<a class="button" href="javascript:submitForm()"><span><img src="/public/images/icons/drive_go.png"/><p>Process Sales Form</p></span></a>
	</div>
</div>

<div id="creditFormContainer">
	<?php $creditdetailsform->render() ?>
</div>


<script type="text/javascript">
	// creates a lookup so that we can update the price without an ajax call
	var priceLookup = new Array();
	<?php foreach ($itemDetails as $itemDetail):?>
		priceLookup["<?php echo $itemDetail['itemDetailId']; ?>"] = "<?php echo $itemDetail['buyingPrice'] ?>";
	<? endforeach; ?>

	var rowCtr = 1;

	$(document).ready(function(){
		$("#row_-rowCtr-").hide();
		addRow();
		addSalesSummary();
		$("#creditFormContainer").hide();
		$(".subtotalvat").hide();
		$("#creditFormContainer").dialog({
			autoOpen: false,
			modal: true,
			title: "Credit Information",
			width: 400,
			height: 280,
			resizable: false
		});
		$("#creditContainer").hide();
	});

	function openDialog() {
		$("#creditFormContainer").dialog("open");
	}

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
		$("#price_" + rowId).html("");
		$("#qty_" + rowId).val(null);
		$("#discount_" + rowId).val(null);
		$("#vat_" + rowId).attr("checked", false);
		$("#subtotal_" + rowId).html("");
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

	function addSalesSummary() {
		$("#vatable").html(" ");
		$("#totalvat").html("");
		$("#totalprice").html("");
	}
</script>
