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
				<th width="40px">ID</th>
				<th>Customer</th>
				<th width="60px">Due Date</th>
				<th width="90px">Total Amount</th>
				<th width="90px">Amount Paid</th>
				<th width="90px">Balance</th>
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
				<td class="rightAligned">
					<a href="/sales/summary/<?php echo $credit['salesTransactionId'] ?>"><?php echo $credit['salesTransactionId'] ?></a>
				</td>
				<td><a href="/customer/view/<?php echo $credit['customerId'] ?>"><?php echo $credit['fullname'] ?></a></td>
				<td class="centered"><?php echo $credit['dueDate'] ?></td>
				<td class="rightAligned"><?php echo formatMoney($credit['totalPrice']) ?></td>
				<td class="rightAligned"><?php echo formatMoney($credit['totalAmountPaid']) ?></td>
				<td class="rightAligned"><?php echo formatMoney($credit['totalPrice'] - $credit['totalAmountPaid']) ?></td>
				<td class="centered"><a href="/credit/creditpaymentform/<?php echo $credit['salesTransactionId'] ?>">Record a Payment</a></td>
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

