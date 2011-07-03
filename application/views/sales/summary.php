<h1>Transaction Summary</h1>

<table id="summaryTable">
	<thead>
		<tr>
			<th>Item</th>
			<th width="100px">Price</th>
			<th width="20px">Qty</th>
			<th width="50px">Discount</th>
			<th width="20px">VAT</th>
			<th width="100px">Subtotal</th>
		</tr>
	</thead>
	<tbody id="salesFormBody">
		<?php foreach ($items as $item): ?>
		<tr>
			<td><?php echo $item['description'] ?></td>
			<td><?php echo $item['unitPrice'] ?></td>
		</tr>
		<?php endforeach; ?>
	</tbody>
	
</table>