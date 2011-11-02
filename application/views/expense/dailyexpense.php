<style>
	.tabular dt { width: 100px; padding-right: 20px; }
	#section h4 { text-align: right; }
	#summaryTable { margin-top: 5px }
</style>


<h1>Expenses</h1>
<div id="section">
	<h4>Item Expenses for <?php echo $date; ?></h4>
	<table id="summaryTable">
		<thead>
			<tr>
				<th>Item</th>
				<th width="70px">Price</th>
				<th width="15px">Quantity</th>
				<th width="50px">Discount</th>
				<th width="100px">Subtotal</th>
				<th width="10px">Credit</th>
				<th>Supplier</th>
			</tr>
		</thead>
		<tbody id="salesFormBody">
			<?php $ctr = 0; $total = 0; ?>
			<?php foreach ($itemExpenses as $itemExpense): ?>
			<?php $ctr ++; ?>
			<tr class="<?php echo $ctr % 2 == 0 ? 'hiliteRow' : ''?>">
				<td><a href="/item/detail/<?php echo $itemExpense['itemId'] ?>"><?php echo $itemExpense['description'] . ' [ ' . $itemExpense['productCode'] . ' ]' ?></a></td>
				<td class="rightAligned"><?php echo formatMoney($itemExpense['price']) ?></td>
				<td class="rightAligned"><?php echo $itemExpense['quantity'] ?></td>
				<td class="rightAligned"><?php echo $itemExpense['discount'] == 0 ? 'none ' : formatMoney($itemExpense['discount']) ?></td>
				<td class="rightAligned"><?php  echo formatMoney($itemExpense['price'] * $itemExpense['quantity'] - $itemExpense['discount']) ?></td>
				<td class="centered"><?php echo $itemExpense['isCredit'] == 0 ? 'no' : 'yes' ?></td>
				<td><a href="supplier/detail/<?php echo $itemExpense['supplierId'] ?>"><?php echo $itemExpense['name'] ?></a></td>
			</tr>
			<?php endforeach; ?>
			<?php if (count($itemExpenses) == 0): ?>
			<tr>
				<td colspan="7">No item expenses for this date.</td>
			</tr>
			<?php endif; ?>
		</tbody>
	</table>
</div>
