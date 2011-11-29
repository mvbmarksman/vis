<style> .tabular dt { width: 100px } </style>

<h1>Inventory Expense Form</h1>
<form name="inventoryForm" id="inventoryForm" action="/expense/inventoryexpenseform" method="POST">

	<div id="section">
		<h3>Expense Information</h3>
		<dl class="tabular">
			<dt class="item"><label>Item<em>*</em>:</label></dt>
			<dd class="item">
				<input type="text" id="item" name="item" class="longTxt"/>
				<input type="hidden" id="itemId" name="itemId" value="" />
			</dd>

			<dt class="itemName"><label>Item Name<em>*</em>:</label></dt>
			<dd class="itemName">
				<input type="text" id="itemName" name="itemName" class="longTxt"/>
			</dd>

			<dt class="productCode"><label>Product Code<em>*</em>:</label></dt>
			<dd class="productCode">
				<input type="text" id="productCode" name="productCode" class="longTxt"/>
			</dd>

			<dt class="category"><label>Category<em>*</em>:</label></dt>
			<dd class="category">
				<select id="category" name="categoryId">
					<?php foreach ($categories as $category): ?>
					<option value="<?php echo $category['categoryId'] ?>"><?php echo $category['categoryName'] ?></option>
					<?php endforeach; ?>
				</select>
			</dd>

			<dt class="itemType"><label>Item Type<em>*</em>:</label></dt>
			<dd class="itemType">
				<select id="itemType" name="itemTypeId">
					<?php foreach ($itemTypes as $itemType): ?>
					<option value="<?php echo $itemType['itemTypeId'] ?>"><?php echo $itemType['itemTypeName'] ?></option>
					<?php endforeach; ?>
				</select>
			</dd>
			<dt><label>Price<em>*</em>:</label></dt>
			<dd>
				<input type="text" id="price" name="price" class="longTxt"/>
			</dd>
			<dt><label>Quantity<em>*</em>:</label></dt>
			<dd>
				<input type="text" id="quantity" name="quantity" class="longTxt"/>
			</dd>
			<dt><label>Credit :</label></dt>
			<dd>
				<input type="checkbox" id="credit" name="credit" value="1"/>
			</dd>
		</dl>

		<h3>Supplier Information</h3>
		<dl class="tabular">
			<dt><label>Supplier :</label></dt>
			<dd>
				<input type="text" id="supplier" name="supplier" class="longTxt" title="The supplier name must be provided if there is a discount."/>
				<input type="hidden" id="supplierId" name="supplierId" />
			</dd>
			<dt><label>Address :</label></dt>
			<dd>
				<textarea id="address" name="address"></textarea>
			</dd>
			<dt>Discount :</dt>
			<dd>
				<input type="text" id="discount" name="discount" class="longTxt"/>
			</dd>
		</dl>
	</div>
	<input id="newItem" name="newItem" type="hidden" value="<?php echo !empty($newItemMode) ? '1' : '0' ?>"/>
	<input id="addAnother" name="addAnother" type="hidden" value=""/>
</form>

<div id="actionsContainer">
	<input type="button" onclick="javascript:submitAndAdd()" value="Save and Add Another"/>
	<input type="button" onclick="javascript:submit()" value="Save and Proceed to Summary"/>
</div>


<script type="text/javascript">
	var itemAutoCompleteData = null;
	var supplierAutoCompleteData = null;
	var validator;

	$(document).ready(function() {
		setValidationRules();
		initItemSection();
		initItemAutoCompleteData();
		initSupplierAutoCompleteData();

		if ($("#newItem").val() == '1') {
			renderNewItemForm();
		}
	});


	function initItemSection()
	{
		$(".productCode").hide();
		$(".itemType").hide();
		$(".category").hide();
		$(".itemName").hide();
		$(".isUsed").hide();
	}

	// Autocomplete for Items
	function initItemAutoCompleteData() {
		$.post('/item/getitemsforautocomplete', {}, function(data){
			itemAutoCompleteData = eval(data);
			initItemAutoComplete();
		});
	}

	function initItemAutoComplete() {
		$("#item").autocomplete({
			minLength: 0,
			source: itemAutoCompleteData,
			select: function(event, ui) {
				$("#item").val(ui.item.description);
				$("#itemId").val(ui.item.itemId);
				return false;
			},
			change: function(event, ui) {
				if (ui.item == null) {
					validator.showErrors({"item": "Invalid item. Please select an item from the list"});
				}
			}
		});
	}


	// Autocomplete for Suppliers
	function initSupplierAutoCompleteData() {
		$.post('/supplier/getsuppliersforautocomplete', {}, function(data){
			supplierAutoCompleteData = eval(data);
			initSupplierAutoComplete();
		});
	}

	function initSupplierAutoComplete() {
		$("#supplier").autocomplete({
			minLength: 0,
			source: supplierAutoCompleteData,
			select: function(event, ui) {
				$("#supplier").val(ui.item.name);
				$("#address").val(ui.item.address);
				$("#supplierId").val(ui.item.supplierId);
				return false;
			}
		});
	}

	function submitAndAdd()
	{
		$("#addAnother").val("1");
		$("#inventoryForm").submit();
	}

	function submit()
	{
		$('#inventoryForm').submit();
	}

	function renderNewItemForm()
	{
		$("#newItem").val(1);
		$(".item").hide();
		$(".item").hide();
		$(".itemName").show();
		$(".productCode").show();
		$(".itemType").show();
		$(".category").show();
		$(".isUsed").show();
	}


	function setValidationRules()
	{
		validator = $("#inventoryForm").validate({
			rules: {
				item: 			{ required: "#newItem:empty" },
				supplier: 		{ required: "#discount:filled" },
				itemName: 		{ required: "#newItem:filled" },
				productCode:	{ required: "#newItem:filled" },
				itemType: 		{ required: "#newItem:filled" },
				category: 		{ required: "#newItem:filled" },
				price: 			{ required: true, number: true },
				quantity: 		{ required: true, number: true },
				discount: 		{ required: false, number: true }
			}
		});
	}
</script>