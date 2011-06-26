<div id="flex1">
</div>


<script type="text/javascript">

$(document).ready(function(){
	$("#flex1").flexigrid({
		url: '/sales_transaction/getgriddata',
		dataType: 'json',
		colModel : [
			{display: 'ID', name : 'salesTransactionId', width : 40, sortable : true, align: 'center'},
			{display: 'Total Price', name : 'totalPrice', width : 180, sortable : true, align: 'left'}
			],
		width: 700,
		height: 200,
		rp: 1
	});
});

</script>
