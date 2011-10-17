<style>
	.tabular dt { width: 100px }
</style>
<h1>Item Detail</h1>
<div id="section">
	<h3>Supplier Information</h3>
	<dl class="tabular">
		<dt>Product Code:</dt><dd><?php echo $item['productCode'] ?></dd>
		<dt>Description:</dt><dd><?php echo $item['description'] ?></dd>
		<dt>Item Type:</dt><dd><?php echo $item['itemTypeName'] ?></dd>
		<dt>Used:</dt><dd><?php echo $item['isUsed'] ? 'yes' : 'no' ?></dd>
		<dt>Items in Stock:</dt><dd><?php echo $item['count'] ?></dd>
	</dl>

	<h3>Supplier Information</h3>
	<dl class="tabular">
		<dt>Supplier:</dt><dd><?php echo !empty($item['supplierName']) ? $item['supplierName'] : "<span class='subtle'>no information</span>" ?></dd>
		<dt>Discount Given:</dt><dd><?php echo !empty($item['supplierDiscount']) ? $item['supplierDiscount'] : "<span class='subtle'>no information</span>" ?></dd>
	</dl>
</div>

