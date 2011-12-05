<style>
.subHeader {
	background: #FFFEE0;
}
</style>

<h1>Supplier Information</h1>
<div id="section">
	<dl class="tabular">
		<dt>Supplier ID:</dt><dd><?php echo $supplier['supplierId'] ?></dd>
		<dt>Name:</dt><dd><?php show($supplier['name']) ?></dd>
		<dt>Address:</dt><dd><?php show($supplier['address']) ?></dd>
	</dl>

	<?php if (count($itemsSupplied) > 0): ?>
	<div id="itemsSection">
		<h3>Items supplied:</h3>
		<table class="summaryTable">
			<thead>
				<tr>
					<td>Transaction ID</td>
					<td>Price</td>
					<td>Transaction Date</td>
				</tr>
			</thead>
			<tbody>
			<?php foreach ($itemsSupplied as $item): ?>
				<tr>
					<td colspan="3" class="subHeader"><a href="/item/view/<?php echo $item['itemId'] ?>"><?php echo $item['description'] . '[ ' . $item['productCode'] . ' ]' ?></a></td>
				</tr>
				<?php foreach ($item['prices'] as $price): ?>
					<tr>
						<td><a href="/expense/dailyexpense/<?php echo date('Y-m-d', strtotime($price['dateAdded'])) ?>"><?php echo $price['itemExpenseId'] ?></a></td>
						<td><?php echo formatMoney($price['price']) ?></td>
						<td><?php echo date('m-d-Y', strtotime($price['dateAdded'])) ?></td>
					</tr>
				<?php endforeach ?>
		<?php endforeach ?>
			</tbody>
		</table>
	</div>
	<?php endif ?>
</div>