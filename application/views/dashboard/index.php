<h1>Dashboard</h1>
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
								<a href="/item_detail/view/<?php echo $item['itemId'] ?>">
								<?php echo isset($item['productCode']) ? '[ ' . $item['productCode'] . ' ]' : '' ?>
								<?php echo isset($item['description']) ? $item['description'] : '' ?></a>,
								<?php $stockClass = $item['totalQuantity'] == 0 ? 'high' : 'medium' ?>
								<span class="<?php echo $stockClass ?>"><?php echo $item['totalQuantity'] ?> items left in stock.</span>
							</li>
							<?php endforeach; ?>
						</ul>
						<?php else: ?>
						<span class="subtle">Nothing to display</span>
						<?php endif ?>
					</td>
				</tr>
				<tr>
					<td class="dashboard-subsection-header">Recently Added</td>
					<td class="dashboard-subsection-content">
						<?php if (count($recentlyAddedItems) > 0): ?>
						<ul>
							<?php foreach ($recentlyAddedItems as $item): ?>
							<li>
								<a href="/item_detail/view/<?php echo $item['itemId'] ?>">
								<?php echo isset($item['productCode']) ? '[ ' . $item['productCode'] . ' ]' : '' ?>
								<?php echo isset($item['description']) ? $item['description'] : '' ?></a>,
								<?php echo $item['count']?> items added
								<span class="dashboard-date"><?php echo $item['dateAdded'] ?></span>
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
				<tr>
					<td class="dashboard-subsection-header">Recent Transactions</td>
					<td class="dashboard-subsection-content">
						<?php if (count($recentSalesTransactions) > 0): ?>
						<ul>
							<?php foreach ($recentSalesTransactions as $item): ?>
							<li>
								Transaction #<?php echo $item['salesTransactionId'] ?>
								<span class="dashboard-date"><?php echo $item['date'] ?></span>
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

		<h2>Credits</h2>
		<div class="dashboard-subsection">
			<table>
				<tr>
					<td class="dashboard-subsection-header">Overdue</td>
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