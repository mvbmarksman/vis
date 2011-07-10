<table id="creditPayment">
	<tr>
		<td>Contact Info</td>
	</tr>
	<tr>
		<td id="address">Address:  <?php echo $creditDetail['address'] ?></td>
	</tr>
	<tr>
		<td id="phoneno">Phone No: <?php echo $creditDetail['phoneNo'] ?></td>
	</tr>
</table>

<h2>Credit Information</h2>
<table>
	<tr>
		<th width="100px"></th>
		<th width="150px">Date</th>
		<th width="200px">Credit</th>
	</tr>
	<?php
		$ctr = 1;
		$totalCredit = 0;
		$totalPayment = 0;
		foreach ($transactionDetails as $transactionDetail):
	?>
	<tr>
		<td></td>
		<td><?php echo date("M-d-Y",strtotime( $transactionDetail['date'] ) )?></td>
			<?php $transactionCredit = number_format($transactionDetail['totalPrice'],2) ?>
			<?php $totalCredit += $transactionCredit?>
		<td id="credit_<?php echo $ctr ?>"><?php echo $transactionCredit?></td>
	</tr>
	<?php $ctr++ ?>
	<?php endforeach; ?>
</table>
<div>Total Credits: <?php echo number_format($totalCredit,2)?></div>
<?php foreach ($paymentDetails as $paymentDetail):?>
<?php $totalPayment += $paymentDetail['amount']?>
<?php endforeach; ?>
<div>Remaining Payable Credits: <?php echo number_format($totalCredit - $totalPayment,2)?> </div>

