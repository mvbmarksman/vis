
<label for="creditDetail">Name: </label>
<select name="creditDetail" id="creditDetail">
	<option class="name" value="0" selected="selected">Select Name</option>
	<?php foreach ($creditDetails as $creditDetail): ?>
		<option value="<?php echo $creditDetail['creditDetailId'] ?>">
			<?php echo $creditDetail['fullName'] ?>
		</option>
	<?php endforeach; ?>
</select>


<div id="creditDetails"></div>

<script type="text/javascript">
	$(document).ready(function(){
		$("#creditDetail").change(getCreditDetail);
	});

	function getCreditDetail() {
		var creditDetailId = $("#creditDetail").val();
		if (creditDetailId != 0){
			$.post("/credit_payment/getcreditdetail/", {creditDetailId : creditDetailId}, function(data) {
				$("#creditDetails").html(data);
			});
		}
		else{
			$("#creditDetails").html("");
		}
	}


	function updateContactInfo(obj){
		alert('updateContactInfo');
	}


</script>