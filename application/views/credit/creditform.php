<h1 id="creditpaymentformHeader">
	<div>Credit Payment Form</div>
</h1>

<form name="creditForm" id="creditForms" action="/credit/processcreditpaymentform" method="POST">
	<table id="creditForm">
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
		<tbody id="creditFormBody">
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

	<div id="creditControls">
		<a href="javascript:addRow()" >Add a New Row</a> | <a href="javascript:openDialog()">Credit Payment</a> | <a href="javascript:submitForm()">Checkout</a>-
	</div>

	<div id="creditSummaryContainer">
		<table id="creditSummary">
			<tr>
				<td class="rightAligned creditSummaryLabel">Vatable:</td>
				<td><div class="creditSummaryValue" id="vatable"></div></td>
			</tr>
			<tr>
				<td class="rightAligned creditSummaryLabel">Total Vat:</td>
				<td><div class="creditSummaryValue" id="totalvat"></div></td>
			</tr>
			<tr>
				<td class="rightAligned creditSummaryLabel">Total Price:</td>
				<td><div class="creditSummaryValue" id="totalprice"></div></td>
			</tr>
		</table>
	</div>

	<div id="creditFormContainer">
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