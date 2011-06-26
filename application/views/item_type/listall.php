<div id="flex1">
</div>








<script type="text/javascript">

$(document).ready(function(){
	$("#flex1").flexigrid({
		url: '/item_type/getgriddata',
		dataType: 'json',
		colModel : [
			{display: 'ID', name : 'itemTypeId', width : 40, sortable : true, align: 'center'},
			{display: 'Name', name : 'name', width : 180, sortable : true, align: 'left'}
			],
		width: 700,
		height: 200,
		rp: 1
	});
});

</script>
