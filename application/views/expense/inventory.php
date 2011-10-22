<?php /*
<ul id ="errors"></ul>
*/ ?>

<h1>Inventory Expense Form</h1>
<div class="clear"></div>

<form name="inventoryForm" action="/expense/processinventoryform" method="POST">
	<table id="inventoryForm">
		<thead>
			<tr>
				<th>Item</th>
				<th width="100px">Price</th>
				<th width="100px">Qty</th>
				<th width="20px">Credit</th>
				<th width="50px">Term</th>
				<th width="30px">Supplier</th>
				<th width="30px"></th>
			</tr>
		</thead>
		<tbody id="inventoryFormBody">
			<!--  form template -->
			<tr id="row_-rowCtr-">
				<td><input type="text" id="item_-rowCtr-" name="item[]" class="longTxt" /></td>
				<td><input type="text" id="price_-rowCtr-" name="price[]" class="mediumTxt" /></td>
				<td><input type="text" id="qty_-rowCtr-" name="qty[]" class="smallTxt" /></td>
				<td><input type="checkbox" id="credit_-rowCtr-" name="credit[]" /></td>
				<td><input type="text" id="term_-rowCtr-" name="term[]" class="smallTxt" /></td>
				<td><input type="text" id="supplier_-rowCtr-" name="supplier[]" class="longTxt" /></td>
				<td><div class="removeBtn" id="remove_-rowCtr-"></div></td>
			</tr>
		</tbody>
	</table>

	<div id="controls">
		<a href="javascript:addRow()" class="action">
			<img src="/public/images/icons/add.png">
			<span>Add a New Row</span>
		</a>
		<div class="clear"></div>
	</div>
</form>

<div id="separator"></div>
<div class="controls" style="margin-top:0px;padding-top: 0px;">
	<div class="btnClear" style="margin-left: 580px;" >
		<a class="button" href="javascript:submitForm()"><span><img src="/public/images/icons/drive_go.png"/><p>Submit and Save</p></span></a>
	</div>
</div>
