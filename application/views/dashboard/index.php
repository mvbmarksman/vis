<h1>Dashboard</h1>
<div id="dateSection"><?php echo date('F d, Y'); ?></div>
<div id="dashboard-section">
	<div>
		<h2>Inventory</h2>
		<div class="dashboard-subsection">
			<table>
				<tr>
					<td class="dashboard-subsection-header">Attention Needed</td>
					<td class="dashboard-subsection-content">
						<?php if (count($itemsLowInStock) > 0): ?>
						<ul>
							<?php foreach ($itemsLowInStock as $item): ?>
							<li>
								<a href="/item/view/<?php echo $item['itemId'] ?>">
								<?php echo isset($item['productCode']) ? '[ ' . $item['productCode'] . ' ]' : '' ?>
								<?php echo isset($item['description']) ? $item['description'] : '' ?></a>,
								<?php $stockClass = $item['totalQuantity'] == 0 ? 'high' : 'medium' ?>
								<span class="<?php echo $stockClass ?>"><?php echo $item['totalQuantity'] ?> <?php echo $item['totalQuantity'] > 1 ? 'items' : 'item' ?> left in stock.</span>
							</li>
							<?php endforeach; ?>
						</ul>
						<?php else: ?>
						<span class="subtle">Nothing to display</span>
						<?php endif ?>
					</td>
				</tr>
			</table>
		</div>

		<h2>Sales</h2>
		<div class="dashboard-subsection">
			<table>
				<tr class="joinedRows">
					<td colspan="2">Total sales for the day: <strong><?php echo formatMoney($totalSales) ?></strong></td>
				</tr>
				<tr>
					<td colspan="2"><a href="/sales/dailysales">View Sales Report for the Day</a></td>
				</tr>
			</table>
		</div>

		<h2>Expenses</h2>
		<div class="dashboard-subsection">
			<table>
				<tr class="joinedRows">
					<td colspan="2">Total expenses for the day: <strong><?php echo formatMoney($totalExpenses) ?></strong></td>
				</tr>
				<tr>
					<td><a href="/expense/dailyexpense">View Expenses Report for the Day</a></td>
				</tr>
			</table>
		</div>

		<h2>Credits</h2>
		<div class="dashboard-subsection">
			<table>
				<tr>
					<td class="dashboard-subsection-header">Overdue Collectibles</td>
					<td class="dashboard-subsection-content">
						<?php if (count($overdueCredits) > 0): ?>
						<ul>
							<?php foreach ($overdueCredits as $item): ?>
							<li>
								Transaction #<?php echo $item['salesTransactionId'] ?>,
								<span class="medium">due last <?php echo date('m-d-Y',  strtotime($item['dueDate'])) ?></span>
							</li>
							<?php endforeach ?>
						</ul>
						<?php else: ?>
						<span class="subtle">Nothing to display</span>
						<?php endif ?>
					</td>
				</tr>
				<tr>
					<td class="dashboard-subsection-header">Overdue Payables</td>
					<td class="dashboard-subsection-content">
						<?php if (count($overdueCredits) > 0): ?>
						<ul>
							<?php foreach ($overdueCredits as $item): ?>
							<li>
								Transaction #<?php echo $item['salesTransactionId'] ?>,
								<span class="medium">due last <?php echo date('m-d-Y',  strtotime($item['dueDate'])) ?></span>
							</li>
							<?php endforeach ?>
						</ul>
						<?php else: ?>
						<span class="subtle">Nothing to display</span>
						<?php endif ?>
					</td>
				</tr>
			</table>
		</div>
	</div>
</div>