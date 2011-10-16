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
								<?php echo isset($item['description']) ? $item['description'] : '' ?>
								<?php echo isset($item['productCode']) ? '[<em>' . $item['productCode'] . '</em>]' : '' ?>,
								<?php $stockClass = $item['stock'] == 0 ? 'high' : 'medium' ?>
								<span class="<?php echo $stockClass ?>"><?php echo $item['stock'] ?> items left in stock.</span>
							</li>
							<?php endforeach; ?>
						</ul>
					</td>
				</tr>
				<?php endif; ?>
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

		<h2>Sales</h2>
		<div class="dashboard-subsection">
			<table>
				<tr>
					<td class="dashboard-subsection-header">Recently Sold</td>
					<td class="dashboard-subsection-content">
						<ul>
							<li>Bosskit Adaptor Toyota T2</li>
							<li>Bosskit Adaptor Toyota T2</li>
						</ul>
					</td>
				</tr>
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