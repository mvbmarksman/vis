<h1>Item List</h1>
<div id="itemDetailFlex"></div>

<div id="itemDetailDialog" style="display:none">
	<form id="itemDetailForm" action="/admin_item_detail/performsaveorupdate" method="POST" >
		<table>
			<tr>
				<td class="rightAligned">Product Code:</td>
				<td>
					<input type="text" id="productCode" name="productCode" class="longTxt">
					<input type="hidden" id="itemDetailId" name="itemDetailId"/>
				</td>
			</tr>
			<tr>
				<td class="rightAligned">Item Type:</td>
				<td>
					<input type="text" id="itemType" name="itemType" class="longTxt">
				</td>
			</tr>
			<tr>
				<td class="rightAligned">Description:</td>
				<td>
					<input type="text" id="description" name="description" class="longTxt">
				</td>
			</tr>
			<tr>
				<td class="rightAligned">Unit </td>
				<td>
					<input type="text" id="unit" name="unit" class="longTxt">
				</td>
			</tr>
			<tr>
				<td class="rightAligned">Unit </td>
				<td>
					<input type="text" id="buyingPrice" name="buyingPrice" class="longTxt">
				</td>
			</tr>
			<tr>
				<td class="rightAligned">Unit </td>
				<td>
					<input type="checkbox" id="isUsed" name="isUsed" class="longTxt">
				</td>
			</tr>
			<tr>
				<td class="rightAligned">Supplier </td>
				<td>
					<input type="text" id="supplierId" name="supplierId" class="longTxt">
				</td>
			</tr>
		</table>
		<input type="button" onclick="validateAndSubmit()" />
	</form>
</div>

<script type="text/javascript">

	$(document).ready(function(){

		$("#itemDetailDialog").dialog({
			autoOpen: false,
			title: "User Information"
		});

		$("#itemDetailFlex").flexigrid({
			url: '/admin_item_detail/getgriddata',
			dataType: 'json',
			resizable: false,
			showTableToggleBtn: false,
			colModel : [
				{display: '', name : 'check', width : 30, sortable : true, align: 'center'},
				{display: 'Id', name : 'itemDetailId', width : 50, sortable : true, align: 'center'},
				{display: 'Product Code', name : 'productCode', width : 75, sortable : true, align: 'left'},
				{display: 'Item Type', name : 'itemTypeId', width : 75, sortable : true, align: 'left'},
				{display: 'Description', name : 'description', width : 75, sortable : true, align: 'left'},
				{display: 'Unit', name : 'unit', width : 75, sortable : true, align: 'left'},
				{display: 'Buying Price', name : 'buyingPrice', width : 75, sortable : true, align: 'left'},
				{display: 'Used', name : 'isUsed', width : 75, sortable : true, align: 'left'},
				{display: 'Supplier', name : 'supplierId', width : 75, sortable : true, align: 'left'}
				],
			buttons : [
				{name: 'Add', bclass: 'flex_add', onpress : add},
				{separator: true},
				{name: 'Edit', bclass: 'flex_edit', onpress : edit},
				{separator: true},
				{name: 'Delete', bclass: 'flex_delete', onpress : remove},
				{separator: true}
			],
			searchitems : [
				{display: 'Description', name : 'description', isdefault:true}
			],
			sortname: "description",
			sortorder: "asc",
			usepager: true,
			useRp: true,
			rp: 10,
			width: 740,
			height: "auto"
		});
	});

	function add()
	{
		$("#itemDetailDialog").dialog('open');
	}

	function remove()
	{
		var itemDetailIds= getIdsForDelete($("#itemDetailFlex"), 'itemDetailCheckbox');
		if (itemDetailIds == null) {
			alert("Please select an item to delete.");
			return;
		}
		$.post('/admin_item_detail/delete/', {itemDetailIds:itemDetailIds}, function(data) {
			// TODO notify itemDetail of success
			$("#itemDetailFlex").flexReload();
		});
	}

	function edit()
	{
		var itemDetailId = getIdForEdit($("#itemDetailFlex"), 'itemDetailCheckbox');
		if (itemDetailId == null) {
			alert("Please select a itemDetail to edit.");
			return;
		}
		$.post('/admin_item_detail/getitemDetaildata/', {itemDetailId:itemDetailId}, function(data) {
			var itemDetailData = eval("(" + data + ")");
			$("#itemDetailId").val(itemDetailData.itemDetailId);
			$("#name").val(itemDetailData.fullname);
			$("#address").val(itemDetailData.address);
			$("#contact").val(itemDetailData.phoneNo);
			$("#itemDetailDialog").dialog('open');
		});
	}

	function validateAndSubmit()
	{
		var isValid = true;
		if (isValid) {
			$("#itemDetailForm").submit();;
		}
	}

</script>
