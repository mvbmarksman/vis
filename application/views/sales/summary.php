<style>
	.tabular dt { width: 90px; }
</style>
<h1>Transaction Summary</h1>
<table class="summaryTable">
	<thead>
		<tr>
			<th>Item</th>
			<th width="100px">Selling Price</th>
			<th width="20px">Qty</th>
			<th width="50px">Discount</th>
			<th width="20px">VAT</th>
			<th width="100px">Subtotal</th>
		</tr>
	</thead>
	<tbody id="salesFormBody">
		<?php $ctr = 0;$vatTotal = 0; ?>
		<?php foreach ($items as $item): ?>
		<?php $ctr ++; ?>
		<tr class="<?php echo $ctr % 2 == 0 ? 'hiliteRow' : ''?>">
			<td><?php echo $item['description'] ?></td>
			<td class="rightAligned"><?php echo formatMoney($item['sellingPrice']) ?></td>
			<td class="rightAligned"><?php echo $item['qty'] ?></td>
			<td class="centered"><?php echo $item['discount'] ? formatMoney($item['discount']) : '<span class="subtle">none</span>' ?></td>
			<td class="centered"><img src="/public/images/icons/<?php echo ! empty($item['vatable']) ? "accept.png" : "cross.png" ?>"/></td>
			<td class="rightAligned"><?php echo formatMoney($item['subTotal']) ?></td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>
<?php $item = array_pop($items); ?>

<div id="salesSummaryContainer">
	<table id="salesSummary">
		<tr>
			<td class="rightAligned salesSummaryLabel" width="100px">Vatable:</td>
			<td><div class="salesSummaryValue rightAligned" id="vatable"><?php echo formatMoney($item['totalVatable']) ?> </div></td>
		</tr>
		<tr>
			<td class="rightAligned salesSummaryLabel">Total Vat:</td>
			<td><div class="salesSummaryValue rightAligned" id="totalvat"><?php echo formatMoney($item['totalVat']) ?></div></td>
		</tr>
		<tr>
			<td class="rightAligned salesSummaryLabel">Total Price:</td>
			<td><div class="salesSummaryValue rightAligned" id="totalprice"><?php echo formatMoney($item['totalPrice']) ?></div></td>
		</tr>
	</table>
</div>

<h3>Customer Information</h3>
<dl class="tabular">
	<dt><label>Name :</label></dt>
	<dd><?php echo $item['fullname']; ?></dd>
	<dt><label>Address :</label></dt>
	<dd><?php echo $item['address']; ?></dd>
	<dt><label>Phone No :</label></dt>
	<dd><?php echo $item['phoneNo'] ?></dd>
	<dt><label>Amount Paid :</label></dt>
	<dd><?php echo formatMoney($item['totalAmountPaid']) ?></dd>
</dl>
