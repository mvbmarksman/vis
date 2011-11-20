<style>
	.summaryTable dt { margin-top: 10px }
	#creditsAndPayments dt { width: 170px }
	#creditsAndPayments { padding-bottom: 0px; margin-bottom: 0px }
	.credits li { padding: 5px 0; padding-bottom: 10px !important; }
	#payments {
		float:left;
		margin-top: 3px;
		margin-left: 5px
	}
	#payments tr td { padding: 3px 0 }
	.payments {margin-top:5px;}
	.hilite { background-color: #EBF1F7 }
</style>

<h1>Customer Information</h1>
<div id="section">
	<dl class="tabular">
		<dt>Customer ID:</dt><dd><?php echo $customer['customerId'] ?></dd>
		<dt>Name:</dt><dd><?php show($customer['fullname']) ?></dd>
		<dt>Address:</dt><dd><?php show($customer['address']) ?></dd>
		<dt>Phone No:</dt><dd><?php show($customer['phoneNo']) ?></dd>
	</dl>

	<?php if (count($creditsAndPayments) > 0): ?>
	<div id="creditsSection">
		<h3>Credits:</h3>
		<ul class="credits">
		<?php $ctr = 0; ?>
		<?php foreach ($creditsAndPayments as $credit): ?>
			<li class="<?php if (++$ctr % 2 == 0) echo 'hilite'; ?>">
				<dl id="creditsAndPayments" class="tabular">
					<dt>Sales Transaction Id :</dt>
					<dd><a href="/sales/summary/<?php echo $credit['salesTransactionId'] ?>"><?php echo $credit['salesTransactionId'] ?></a></dd>
					<dt>Total Transaction Amount :</dt>
					<dd><?php echo formatMoney($credit['totalPrice']) ?></dd>
					<dt>Total Amount Paid :</dt>
					<dd><?php echo formatMoney($credit['totalAmountPaid']) ?> <?php if ($credit['isFullyPaid'] == 1):?><strong style="color: #0D6605">(Fully Paid)</strong><?php endif ?></dd>
				</dl>
				<div style="float: left; font-weight: bold; padding-left: 72px; margin-top: 5px">Credit Payments :</div>
				<table id="payments">
					<?php if (empty($credit['creditPayments'])): ?>
					<tr><td><span class="subtle">none</span></td></tr>
					<?php else: ?>
					<?php foreach ($credit['creditPayments'] as $payment): ?>
						<tr>
							<td width="100px"><?php echo formatMoney($payment['amount']) ?></td>
							<td><?php echo date('m-d-Y', strtotime($payment['datePaid'])) ?></td>
						</tr>
					<?php endforeach ?>
					<?php endif ?>
				</table>
				<div style="float: right; font-weight: bold; margin-top: 5px; margin-right: 20px"><a href="#">record a payment</a></div>
				<div style="clear: both;"></div>
			</li>
		<?php endforeach ?>
		</ul>
	</div>
	<?php endif ?>

</div>