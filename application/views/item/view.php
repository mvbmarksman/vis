<style>
	.summaryTable dt { margin-top: 10px }
	#buyingPricesSection { margin-top: 20px }
</style>
<h1>Item Detail</h1>
<div id="section">
	<h3>Item Information</h3>
	<dl class="tabular">
		<dt>Description:</dt><dd><?php echo $item['description'] ?></dd>
		<dt>Product Code:</dt><dd><?php echo $item['productCode'] ?></dd>
		<dt>Category:</dt><dd><?php echo $item['categoryName'] ?></dd>
		<dt>Item Type:</dt><dd><?php echo $item['itemTypeName'] ?></dd>
		<dt>Suggested Price:</dt><dd><?php echo formatMoney($item['suggestedSellingPrice']) ?></dd>
		<dt>Items in Stock:</dt><dd><?php echo $item['totalQuantity'] ?></dd>
	</dl>

	<div id="knownSuppliersSection">
		<h3>Known suppliers for this item</h3>
		<table class="summaryTable">
			<thead>
				<tr>
					<th>Name</th>
					<th>Address</th>
					<th width="90px">Discount Given</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($suppliers as $supplier): ?>
				<tr>
					<td><?php echo $supplier['name']?></td>
					<td><?php echo $supplier['address']?></td>
					<td class="rightAligned"><?php echo formatMoney($supplier['discount'])?></td>
				</tr>
				<?php endforeach ?>
				<?php if (count($suppliers) == 0): ?>
				<tr>
					<td colspan="3" class="subtle">No suppliers to display.</td>
				</tr>
				<?php endif ?>
			</tbody>
		</table>
	</div>

	<div id="buyingPricesSection">
		<h3>Latest buying prices for this item:</h3>
		<table class="summaryTable">
			<thead>
				<tr>
					<th width="140px">Date of Purchase</th>
					<th width="90px">Buying Price</th>
					<th>Supplier</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($buyingPrices as $buyingPrice): ?>
				<tr>
					<td><?php echo formatDate($buyingPrice['dateAdded']) ?></td>
					<td class="rightAligned"><?php echo formatMoney($buyingPrice['price']) ?></td>
					<td><?php echo $buyingPrice['supplierName'] == null ? "<span class='subtle'>none provided</span>" : $buyingPrice['supplierName'] ?></td>
				</tr>
				<?php endforeach ?>
				<?php if (count($buyingPrices) == 0): ?>
				<tr>
					<td colspan="3" class="subtle">No buying prices to display.</td>
				</tr>
				<?php endif ?>
			</tbody>
		</table>
	</div>

</div>

