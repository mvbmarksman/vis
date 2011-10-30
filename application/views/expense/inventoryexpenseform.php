<?php /* <ul id ="errors"></ul> */ ?>

<style> .tabular dt { width: 100px } </style>

<h1>Inventory Expense Form</h1>
<form name="inventoryForm" id="inventoryForm" action="/expense/processinventoryexpenseform" method="POST">

	<div id="section">
		<h3>Expense Information</h3>
		<dl class="tabular">
			<dt><label>Item<em>*</em>:</label></dt>
			<dd>
				<input type="text" id="item" name="item" class="longTxt"
					value="<?php echo !empty($item['item']) ? $item['item'] : ''?>" />
				<input type="hidden" id="item_id" name="item_id" value="" />
				&nbsp;<a href="/expense/inventoryexpensenewform">Add an item that's not yet in the inventory</a>
			</dd>
			<dt><label>Price<em>*</em>:</label></dt>
			<dd>
				<input type="text" id="price" name="price" class="longTxt"
					value="<?php echo !empty($item['price']) ? $item['price'] : ''?>" />
			</dd>
			<dt><label>Quantity<em>*</em>:</label></dt>
			<dd>
				<input type="text" id="quantity" name="quantity" class="longTxt"
					value="<?php echo !empty($item['quantity']) ? $item['quantity'] : ''?>" />
			</dd>
			<dt><label>Credit :</label></dt>
			<dd>
				<input type="checkbox" id="credit" name="credit" class="longTxt"
					<?php if (!empty($item['credit'])) echo 'checked="checked"' ?> />
			</dd>
			<dt class="termRow">Term:</dt>
			<dd class="termRow">
				<input type="text" id="term" name="term" class="longTxt"
					value="<?php echo !empty($item['term']) ? $item['credit'] : ''?>" />
			</dd>
		</dl>

		<h3>Supplier Information</h3>
		<dl class="tabular">
			<dt>Supplier Name :</dt>
			<dd>
				<input type="text" id="supplier" name="supplier" class="longTxt" title="The supplier name must be provided if there is a discount."
					value="<?php echo !empty($item['supplier']) ? $item['credit'] : ''?>" />
				<input type="hidden" id="supplier_id" name="supplier_id" />
			</dd>
			<dt>Address :</dt>
			<dd>
				<textarea id="address" name="address"></textarea>
			</dd>
			<dt>Discount :</dt>
			<dd>
				<input type="text" id="discount" name="discount" class="longTxt"
					value="<?php echo !empty($item['discount']) ? $item['credit'] : ''?>" />
			</dd>
		</dl>
	</div>
	<input type="hidden" id="addAnother" name="addAnother" value=""/>
</form>

<div id="separator"></div>
<div class="controls" style="margin-top:0px;padding-top: 0px;">
	<div class="btnClear" style="margin-left: 450px;" >
		<a class="button" href="javascript:submitAndAdd()"><span><img src="/public/images/icons/add.png"/><p>Submit and Add Another</p></span></a>
		<a class="button" href="javascript:submit()"><span><img src="/public/images/icons/accept.png"/><p>Submit</p></span></a>
	</div>
</div>

<script type="text/javascript">
	var itemAutoCompleteData = null;
	var supplierAutoCompleteData = null;

	$(document).ready(function() {
		$(".termRow").hide();
		$("#credit").click(function(){
			$(".termRow").toggle();
		});
		initItemAutoCompleteData();
		initSupplierAutoCompleteData();

		var validator = $("#inventoryForm").validate({
			rules: {
				item: "required",
				price: {
					required: true,
					number: true
				},
				quantity: {
					required: true,
					number: true
				},
				supplier: {
					required: "#discount:filled"
				}
			}
		});
	});

	function submitAndAdd()
	{
		$("#addAnother").val("1");
		$("#inventoryForm").submit();
	}

	function submit()
	{
		$('#inventoryForm').submit();
	}


	// Autocomplete for Items
	function initItemAutoCompleteData() {
		$.post('/sales/getitemsforautocomplete', {}, function(data){
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
				$("#item_id").val(ui.item.itemDetailId);
				return false;
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
				$("#supplier_id").val(ui.item.supplierId);
				return false;
			}
		});
	}

</script>
