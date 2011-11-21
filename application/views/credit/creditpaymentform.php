<?php $this->message->display(); ?>

<h1>Record Credit Payment</h1>

<form id="creditPaymentForm" action="/credit/processcreditpaymentform" method="POST">
	<dl class="tabular">
		<dt>Transaction ID :</dt>
		<dd>
			<a href="/sales/summary/<?php echo $transactionDetails['salesTransactionId'] ?>"><?php echo $transactionDetails['salesTransactionId'] ?></a>
			<input type="hidden" name="salesTransactionId" value="<?php echo $transactionDetails['salesTransactionId']?>"/>
			<input type="hidden" name="customerId" value="<?php echo $transactionDetails['customerId']?>"/>
		</dd>
		<dt>Total Amount :</dt>
		<dd><?php echo formatMoney($transactionDetails['totalPrice'])?></dd>
		<dt>Amount Paid :</dt>
		<dd><?php echo formatMoney($transactionDetails['totalAmountPaid'])?></dd>
		<dt>Balance :</dt>
		<dd>
			<?php
				$balance = $transactionDetails['totalPrice'] - $transactionDetails['totalAmountPaid'];
				echo formatMoney($balance)
			?>
			<?php if ($transactionDetails['isFullyPaid'] == 1):?><strong style="color: #0D6605">(Fully Paid)</strong><?php endif ?>
			<input type="hidden" id="balance" value="<?php echo $balance ?>" />
		</dd>
		<dt>Enter amount paid :</dt>
		<dd><input type="text" name="amount" class="longText"/></dd>
	</dl>
	<div id="actionsContainer">
		<input type="submit" value="Submit"/>
	</div>
</form>


<script type="text/javascript">

$(document).ready(function(){
	var maxAmount = $("#balance").val();
	validator = $("#creditPaymentForm").validate({
		rules: {
			amount:			{
				required: true,
				number: true,
				max: maxAmount,
				min: 1
			}
		},
		submitHandler: function(form) {
			form.submit();
		}
	});
});
</script>


