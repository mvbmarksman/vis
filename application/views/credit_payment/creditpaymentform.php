<div id="creditPaymentFormContainer">
	<form name="creditPaymentForm" id="creditPaymentForms" action="/credit_payment/processcreditpaymentform" method="POST">
		<table id="creditPaymentForm">
			<tr>
				<td>
					<select name="name" onClick="hideDuplicate()" onchange="updateContactInfo(this)">
					<option class="name" value="0" selected="selected">Select a name</option>
					<?php foreach ($creditDetails as $creditDetail): ?>
					<option class="name" id="name_<?php echo $creditDetail['creditDetailId']  ?>"value="<?php echo $creditDetail['creditDetailId'] ?>">
						<?php echo $creditDetail['fullName'] ?>
					</option>
					<?php endforeach; ?>
				</td>
			</tr>
			<tr>
				<td>Contact Info</td>
			</tr>
			<tr>
				<td id="address">Address:</td>
			</tr>
			<tr>
				<td id="phoneno">Phone No:</td>
			</tr>
		</table>
		<table>
			<tr>
				<td >Credit Info</td>
			</tr>
			<tr>
				<th width="100px"></th>
				<th width="50px">Date</th>
				<th width="100px">Remaining Credit</th>
			</tr>
		</table>
	</form>
</div>

<script type="text/javascript">

	var addressLookup = new Array();
	var phoneNoLookup = new Array();
	<?php foreach ($creditDetails as $creditDetail):?>
		addressLookup["<?php echo $creditDetail['creditDetailId']; ?>"] = "<?php echo $creditDetail['address'] ?>";
		phoneNoLookup["<?php echo $creditDetail['creditDetailId']; ?>"] = "<?php echo $creditDetail['phoneNo'] ?>";
	<? endforeach; ?>

	function updateContactInfo(obj){
		var selectedName = $(obj).val();
		var address = addressLookup[selectedName];
		var phoneNo = phoneNoLookup[selectedName];
		$("#address").html("Address: " + address);
		$("#phoneno").html("Phone No: " + phoneNo);
	}

	function hideDuplicate(){
		$("select[id ^= 'name_' ]:visible").each(function()
	}

</script>