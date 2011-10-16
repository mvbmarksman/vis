<h1>Dashboard</h1>
<div id="dashboard-section">
	<div>
		<h2>Inventory</h2>
		<div class="dashboard-subsection">
			<table>
				<?php if (count($itemsLowInStock) > 0): ?>
				<tr>
					<td class="dashboard-subsection-header">Attention Needed</td>
					<td class="dashboard-subsection-content">
						<ul>
							<?php foreach ($itemsLowInStock as $item): ?>
							<li>
								<?php echo isset($item['productCode']) ? '[<em>' . $item['productCode'] . '</em>]' : '' ?>
								<?php echo isset($item['description']) ? $item['description'] : '' ?>,
								<?php $stockClass = $item['count'] == 0 ? 'high' : 'medium' ?>
								<span class="<?php echo $stockClass ?>"><?php echo $item['count'] ?> items left in stock.</span>
							</li>
							<?php endforeach; ?>
						</ul>
					</td>
				</tr>
				<?php endif; ?>
				<?php if (count($recentlyAddedItems) > 0): ?>
				<tr>
					<td class="dashboard-subsection-header">Recently Added</td>
					<td class="dashboard-subsection-content">
						<ul>
							<?php foreach ($recentlyAddedItems as $item): ?>
							<li>
								<?php echo isset($item['productCode']) ? '[<em>' . $item['productCode'] . '</em>]' : '' ?>
								<?php echo isset($item['description']) ? $item['description'] : '' ?>,
								<?php echo $item['count']?> items added
								<span class="dashboard-date"><?php echo $item['dateAdded'] ?></span>
							</li>
							<?php endforeach; ?>
						</ul>
					</td>
				</tr>
				<?php endif; ?>
			</table>
		</div>

		<h2>Sales</h2>
		<div class="dashboard-subsection">
			<table>
				<?php if (count($recentSalesTransactions) > 0): ?>
				<tr>
					<td class="dashboard-subsection-header">Recent Transactions</td>
					<td class="dashboard-subsection-content">
						<ul>
							<?php foreach ($recentSalesTransactions as $item): ?>
							<li>
								Transaction #<?php echo $item['salesTransactionId'] ?>
								<span class="dashboard-date"><?php echo $item['date'] ?></span>
							</li>
							<?php endforeach; ?>
						</ul>
					</td>
				</tr>
				<?php endif; ?>
			</table>
		</div>

		<h2>Credits</h2>
		<div class="dashboard-subsection">
			<table>
				<tr>
					<td class="dashboard-subsection-header">Attention Needed</td>
					<td class="dashboard-subsection-content">
						<ul>
							<li>Bosskit Adaptor Toyota T2, 0 items in stock</li>
							<li>Bosskit Adaptor Toyota T2, 0 items in stock</li>
						</ul>
					</td>
				</tr>
				<tr>
					<td class="dashboard-subsection-header">Recently Added</td>
					<td class="dashboard-subsection-content">
						<ul>
							<li>Bosskit Adaptor Toyota T2</li>
							<li>Bosskit Adaptor Toyota T2</li>
						</ul>
					</td>
				</tr>
			</table>
		</div>
	</div>


</div>