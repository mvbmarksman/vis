<style>
</style>

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
			<!--  form template -->
			<tr id="row_-rowCtr-">
				<td>
					<input type="text" id="item_-rowCtr-"/>
					<input type="hidden" id="item_id-rowCtr-" name="item[]"/>
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