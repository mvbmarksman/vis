<form name="transferForm" id="transferForms" action="/items/processtransfer" method="POST">
	<table id="salesForm">
	<thead>
			<tr>
				<th width="100px">Item</th>
				<th width="20px">From</th>
				<th width="20px">To</th>
				<th width="50px">Qty</th>
			</tr>
		</thead>
	</table>
	<tbody id="salesFormBody">
		<tr>
			<td>
				<select name="item">
					<option value="0" selected="selected">Select an item</option>
					<?php foreach ($itemDetails as $itemDetail): ?>
					<option value="<?php echo $itemDetail['itemDetailId'] ?>">
						<?php echo $itemDetail['description'] ?>
					</option>
					<?php endforeach; ?>
				</select>
			</td>
			<td>
				<select name="fromstore">
					<?php $ctr = 1;
						  foreach ($storeDetails as $storeDetail): ?>
					<?php $store[$ctr] = $storeDetail['name'] ?>
					<?php $ctr++ ?>
					<?php endforeach; ?>
					<option value="1">
						From <?php echo $store[1] ?> To <?php echo $store[2] ?>
					</option>
					<option value="2">
						From <?php echo $store[2] ?> To <?php echo $store[1] ?>
					</option>

				</select>
			</td>
			<td>
				<input type="text" name="qty" />
			</td>
		</tr>
	</tbody>
	<input type = "submit" />
</form>


