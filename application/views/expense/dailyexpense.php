<style>
	.tabular dt { width: 100px; padding-right: 20px; }
	#section h4 { text-align: left; margin-top: 5px; }
	.summaryTable { margin-top: 10px; }
	#totalContainer { margin-top: 25px; text-align: right; font-size: 13px; }
	#totalContainer strong{ font-weight: bold; }
</style>

<h1>Daily Expense Report</h1>
<div id="section">
	<div style="text-align: right">
		<label>Expense Report for:</label>
		<input type="text" id="datepicker" name="datepicker" value="<?php echo $date ?>"/>
	</div>

	<h4>Inventory Expenses</h4>
	<table class="summaryTable">
		<thead>
			<tr>
				<th>Item</th>
				<th width="70px">Price</th>
				<th width="15px">Quantity</th>
				<th width="50px">Discount</th>
				<th width="10px">Credit</th>
				<th>Supplier</th>
				<th width="100px">Subtotal</th>
			</tr>
		</thead>
		<tbody id="salesFormBody">
			<?php $ctr = 0; $total = 0; ?>
			<?php foreach ($itemExpenses as $itemExpense): ?>
			<?php
				$ctr++;
				$subTotal = $itemExpense['price'] * $itemExpense['quantity'] - $itemExpense['discount'];
				$total += $subTotal;
			?>
			<tr class="<?php echo $ctr % 2 == 0 ? 'hiliteRow' : ''?>">
				<td><a href="/item/detail/<?php echo $itemExpense['itemId'] ?>"><?php echo $itemExpense['description'] . ' [ ' . $itemExpense['productCode'] . ' ]' ?></a></td>
				<td class="rightAligned"><?php echo formatMoney($itemExpense['price']) ?></td>
				<td class="rightAligned"><?php echo $itemExpense['quantity'] ?></td>
				<td class="rightAligned"><?php echo $itemExpense['discount'] == 0 ? 'none ' : formatMoney($itemExpense['discount']) ?></td>
				<td class="centered"><?php echo $itemExpense['isCredit'] == 0 ? 'no' : 'yes' ?></td>
				<td>
					<?php if (!(empty($itemExpense['name']))): ?>
						<a href="supplier/detail/<?php echo $itemExpense['supplierId'] ?>"><?php echo $itemExpense['name'] ?></a>
					<?php else: ?>
						not provided
					<?php endif; ?>
				</td>
				<td class="rightAligned"><?php  echo formatMoney($itemExpense['price'] * $itemExpense['quantity'] - $itemExpense['discount']) ?></td>
			</tr>
			<?php endforeach; ?>
			<?php if (count($itemExpenses) == 0): ?>
			<tr>
				<td colspan="7">No item expenses for this date.</td>
			</tr>
			<?php endif; ?>
		</tbody>
	</table>

	<h4 style="margin-top: 25px">Other Expenses</h4>
	<table class="summaryTable">
		<thead>
			<tr>
				<th>Description</th>
				<th width="70px">Price</th>
				<th width="200px">Payee</th>
				<th width="10px">Credit</th>
				<th width="100px">Subtotal</th>
			</tr>
		</thead>
		<tbody id="salesFormBody">
			<?php $ctr = 0;?>
			<?php foreach ($otherExpenses as $otherExpense): ?>
			<?php
				$ctr++;
				$subTotal = $otherExpense['price'];
				$total += $subTotal;
			?>
			<tr class="<?php echo $ctr % 2 == 0 ? 'hiliteRow' : ''?>">
				<td><?php echo $otherExpense['description']?></td>
				<td class="rightAligned"><?php echo formatMoney($otherExpense['price']) ?></td>
				<td><?php echo $otherExpense['payee'] ?></td>
				<td class="centered"><?php echo $otherExpense['isCredit'] == 0 ? 'no' : 'yes' ?></td>
				<td class="rightAligned"><?php  echo formatMoney($subTotal) ?></td>
			</tr>
			<?php endforeach; ?>
			<?php if (count($otherExpenses) == 0): ?>
			<tr>
				<td colspan="5">No other expenses for this date.</td>
			</tr>
			<?php endif; ?>
		</tbody>
	</table>

	<div id="totalContainer">
		<strong>Total Expenses: </strong>₱ <?php echo formatMoney($total) ?>
	</div>

</div>

<script type="text/javascript">
	$(document).ready(function(){
		$("#datepicker").datepicker({
			dateFormat: 'yy-mm-dd',
			onSelect: function(dateText, inst) {
				document.location = '/expense/dailyexpense/' + dateText;
			}
		});
	});
</script>