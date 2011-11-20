<style> .tabular dt { width: 120px } </style>
<?php $this->message->display(); ?>
<ul id ="errors" style="display:none"></ul>

<h1>
	<img src="/public/images/icons/wallet.png" />
	<div>Sales Form</div>
</h1>
<div class="clear"></div>

<form name="salesForm" id="salesForms" action="/sales/salesform" method="POST">
	<table id="salesForm">
		<thead>
			<tr>
				<th>Item</th>
				<th width="100px">Suggested Price</th>
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
					<span id="suggestedSellingPrice_-rowCtr-"></span>
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
					<span class = "subtotal" id="subtotaldisplay_-rowCtr-"></span>
					<input type="hidden" id="subtotalVat_-rowCtr-"/>
					<input type="hidden" id="subtotal_-rowCtr-"/>
					<input type="hidden" id="subtotalVatable_-rowCtr-"/>
				</td>
				<td>
					<div class="removeBtn" id="remove_-rowCtr-"></div>
				</td>
			</tr>
		</tbody>
	</table>

	<div id="salesControls">
		<a href="javascript:addRow()" class="action">
			<img src="/public/images/icons/add.png">
			<span>Add a New Row</span>
		</a>
		<div class="clear"></div>
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
				<td><div class="salesSummaryValue" id="totalprice"></div><input type="hidden" id="total" value="0"/></td>
			</tr>
		</table>
	</div>

	<h3>Customer Information</h3>
	<dl class="tabular">
		<dt><label>Name<em>*</em>:</label></dt>
		<dd>
			<input type="text" id="name" name="name" class="longTxt"/>
		</dd>
		<dt><label>Address:</label></dt>
		<dd>
			<textarea id="address" name="address" rows="2" cols="22" ></textarea>
		</dd>
		<dt><label>Contact Number:</label></dt>
		<dd>
			<input type="text" id="contact" name="contact" class="longTxt"/>
		</dd>
		<dt><label>Amount Paid:</label></dt>
		<dd>
			<input type="text" id="amountPaid" name="amountPaid" class="longTxt"/><img class="creditBadge" src="/public/images/icons/iscredit.png"/>
		</dd>
		<dt class="termRow"><label>Term:</label></dt>
		<dd class="termRow">
			<select id="term" name="term" class="longSelect">
					<option value="30">30 days</option>
					<option value="60">60 days</option>
					<option value="90">90 days</option>
					<option value="120">120 days</option>
			</select>
		</dd>
	</dl>
</form>

<div id="actionsContainer">
	<input type="button" onclick="javascript:submitForm()" value="Submit and Save"/>
</div>
