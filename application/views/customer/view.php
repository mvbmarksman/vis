<?php if (empty($customer)): ?>
<div id="generalError">
Oops, this customer does not exist.
</div>
<?php else: ?>
<style>
	.summaryTable dt { margin-top: 10px }
</style>
<h1>Customer Information</h1>
<div id="section">
	<dl class="tabular">
		<dt>Customer ID:</dt><dd><?php echo $customer['customerId'] ?></dd>
		<dt>Name:</dt><dd><?php echo $customer['fullname'] ?></dd>
		<dt>Address:</dt><dd><?php echo $customer['address'] ?></dd>
		<dt>Phone No:</dt><dd><?php echo $customer['phoneNo'] ?></dd>
	</dl>

	<?php /*
	<div id="creditsSection">
		<h3>Credits:</h3>
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

	*/?>

</div>
<?php endif ?>
