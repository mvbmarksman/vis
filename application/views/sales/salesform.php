<ul id ="errors">
</ul>

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
				<th width="100px">Buying Price</th>
				<th width="100px">Selling Price</th>
				<th width="20px">Qty</th>
				<th width="50px">Discount</th>
				<th width="30px">VAT</th>
				<th width="100px">Subtotal</th>
				<th width="10px">&nbsp;</th>
			</tr>
		</thead>
		<tbody id="salesFormBody">
			<!--  form template -->
			<tr id="row_-rowCtr-">
				<td>
					<input type="text" id="item_-rowCtr-" class="longTxt"/>
					<input type="hidden" id="item_id_-rowCtr-" name="item[]"/>
				</td>
				<td>
					<span id="buyingPrice_-rowCtr-"></span>
				</td>
				<td>
					<input type="text" id="price_-rowCtr-" name="price[]" class="mediumTxt rightAligned"/>
				</td>
				<td>
					<input name = "qty[]" type="text" class="smallTxt rightAligned" id="quantity_-rowCtr-"/>
				</td>
				<td>
					<input name = "discount[]" type="text" class="smallTxt rightAligned" id="discount_-rowCtr-"/>
				</td>
				<td>
					<input name = "vat[]" type="checkbox" id="vat_-rowCtr-" value="vat_-rowCtr-"/>
				</td>
				<td>
					<span class = "subtotal" id="subtotal_-rowCtr-"></span>
					<input type="hidden" id="subtotalVat_-rowCtr-"/>
				</td>
				<td>
					<div class="removeBtn" id="remove_-rowCtr-"></div>
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

<div id="separator"></div>
<h1>
	<img src="/public/images/icons/user.png" />
	<div>Customer Information</div>
</h1>
<div class="clear"></div>
<table id="creditForm">
	<tr>
		<td class="rightAligned">Name:</td>
		<td><input type="text" id="name" class="longTxt"></td>
	</tr>
	<tr>
		<td class="rightAligned">Address:</td>
		<td><textarea rows="3" cols="22" id="address"></textarea></td>
	</tr>
	<tr>
		<td class="rightAligned">Contact Number:</td>
		<td><input type="text" id="contact" class="longTxt"/></td>
	</tr>
	<tr>
		<td class="rightAligned">Amount Paid:</td>
		<td><input type="text" id="amountpaid" class="longTxt"/></td>
	</tr>
</table>

<div id="separator"></div>
<div class="controls" style="margin-top:0px;padding-top: 0px;">
	<div class="btnClear" style="margin-left: 580px;" >
		<a class="button" href="javascript:submitForm()"><span><img src="/public/images/icons/drive_go.png"/><p>Process Sales Form</p></span></a>
	</div>
</div>
