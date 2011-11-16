<style>
	.tabular dt { width: 100px; padding-right: 20px; }
	#section h4 { text-align: left; margin-top: 5px; }
	.summaryTable { margin-top: 10px; }
	#totalContainer { margin-top: 25px; text-align: right; font-size: 13px; }
	#totalContainer strong{ font-weight: bold; }
</style>

<h1>Overdue Credits</h1>
<div id="section">
	<table class="summaryTable">
		<thead>
			<tr>
				<th width="70px">ID</th>
				<th>Customer</th>
				<th width="70px">Due Date</th>
				<th width="90px">Total Amount</th>
				<th width="90px">Amount Paid</th>
				<th width="90px">Collectibles</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($overdueCredits as $credit): ?>
			<?php
				$ctr = 0;
				$ctr++;
			?>
			<tr class="<?php echo $ctr % 2 == 0 ? 'hiliteRow' : ''?>">
				<td><?php echo $credit['salesTransactionId'] ?></td>
				<td><?php echo $credit['fullname'] ?></td>
				<td><?php echo $credit['dueDate'] ?></td>
				<td class="rightAligned"><?php echo formatMoney($credit['totalPrice']) ?></td>
				<td class="rightAligned"><?php echo formatMoney($credit['totalAmountPaid']) ?></td>
				<td class="rightAligned"><?php echo formatMoney($credit['totalPrice'] - $credit['totalAmountPaid']) ?></td>
				<td class="centered">Settle</td>
			</tr>
			<?php endforeach; ?>
			<?php if (count($overdueCredits) == 0): ?>
			<tr>
				<td colspan="7">No overdue credits.</td>
			</tr>
			<?php endif; ?>
		</tbody>
	</table>

</div>
