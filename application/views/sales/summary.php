<style>
#summaryTable {
	font-size: 12px;
	margin-top: 20px;
	width: 750px;
}
#summaryTable thead tr {
	background-color: #6997BF;
	color: #eee;
	text-align: center;
	font-weight: bold;
}
#summaryTable thead tr th {padding: 5px;}
#summaryTable tr {
	color: #333;
	border: 1px solid silver;
}
#summaryTable td {
	padding: 3px;
	border: 1px solid silver;
}

.odd {
	background: #fff;
}
.even {
	background: #FAF4E1;
}

#creditContainer {
	margin-top: 20px;
}

.grayed {
	color: #999;
	font-style: italic;
}

#creditTable {
	font-size: 12px;
	margin-top: 5px;
	width: 750px;
}

#creditTable tr {
	color: #333;
}
#creditTable td {
	padding: 3px;
	border: 1px solid silver;
}

.labelCol {
	width: 80px;
	font-weight: bold;
	padding: 3px 10px !important;
}

#salesSummary {
	margin-top: 5px;
	margin-left: 630px;
}

.salesSummaryLabel {
	font-weight:bold;
	width: 70px;
	padding-right: 10px;
	padding-top: 3px;
}

</style>

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
		<?php $ctr = 0;$vatTotal = 0; ?>
		<?php foreach ($items as $item): ?>
		<?php $ctr ++; ?>
		<tr class="<?php echo $ctr % 2 == 0 ? 'even' : 'odd'?>">
			<td><?php echo $item['description'] ?></td>
			<td class="rightAligned"><?php echo number_format($item['unitPrice'], 2) ?></td>
			<td class="rightAligned"><?php echo $item['qty'] ?></td>
			<td class="centered"><?php echo $item['discount'] ? $item['discount'] : '<span class="grayed">none</span>' ?></td>
			<td class="centered"><img src="/public/images/icons/<?php echo $item['isVAT'] ? "accept.png" : "cross.png" ?>"/></td>
			<td class="rightAligned"><?php echo number_Format($item['qty'] * $item['unitPrice'] - $item['discount'], 2) ?></td>
		</tr>
		<?php
			if ($item['isVAT'])
				$vatTotal += ($item['qty'] * $item['unitPrice'] - $item['discount']) / 1.12; ?>
		<?php endforeach; ?>
	</tbody>
</table>
<?php $item = array_pop($items); ?>

<div id="salesSummaryContainer">
	<table id="salesSummary">
		<tr>
			<td class="rightAligned salesSummaryLabel">Vatable:</td>
			<td><div class="salesSummaryValue" id="vatable"><?php echo number_Format($vatTotal , 2)?> </div></td>
		</tr>
		<tr>
			<td class="rightAligned salesSummaryLabel">Total Vat:</td>
			<td><div class="salesSummaryValue" id="totalvat"><?php echo number_Format($vatTotal * 0.12 , 2)?></div></td>
		</tr>
		<tr>
			<td class="rightAligned salesSummaryLabel">Total Price:</td>
			<td><div class="salesSummaryValue" id="totalprice"><?php echo number_Format($item['totalPrice'], 2)?></div></td>
		</tr>
	</table>
</div>

<?php if ($item['creditId']): ?>
	<div id="creditContainer">
		<h2>Credit Information</h2>
		<table id="creditTable">
			<tr>
				<td class="labelCol">Full Name</td>
				<td><?php echo $item['fullName'] ?></td>
			</tr>
			<tr class="even">
				<td class="labelCol">Address</td>
				<td><?php echo $item['address'] ?></td>
			</tr>
			<tr>
				<td class="labelCol">Phone No</td>
				<td><?php echo $item['phoneNo'] ?></td>
			</tr>
			<tr class="even">
				<td class="labelCol">Amount Paid</td>
				<td><?php echo number_Format($item['amountPaid'], 2) ?></td>
			</tr>
		</table>
	</div>
<?php endif; ?>