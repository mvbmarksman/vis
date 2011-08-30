<h1>Item Type List</h1>
<div id="itemTypeFlex"></div>

<div id="itemTypeDialog" style="display:none">
	<form id="itemTypeForm" action="/admin_item_type/performsaveorupdate" method="POST" >
		<table>
			<tr>
				<td class="rightAligned">Name:</td>
				<td>
					<input type="text" id="name" name="name" class="longTxt">
					<input type="hidden" id="itemTypeId" name="itemTypeId"/>
				</td>
			</tr>
		</table>
		<input type="button" onclick="validateAndSubmit()" value="submit"/>
	</form>
</div>

<script type="text/javascript">

	$(document).ready(function(){
		initAddDialog();
		initFlexigrid();
	});

	function initAddDialog()
	{
		$("#itemTypeDialog").dialog({
			autoOpen: false,
			title: "Item Type Information"
		});
	}

	function initFlexigrid()
	{
		$("#itemTypeFlex").flexigrid({
			url: '/admin_item_type/getgriddata',
			dataType: 'json',
			resizable: false,
			showTableToggleBtn: false,
			colModel : [
				{display: '', name : 'check', width : 30, sortable : true, align: 'center'},
				{display: 'Item Type Id', name : 'itemTypeId', width : 50, sortable : true, align: 'center'},
				{display: 'Item Type Name', name : 'name', width : 250, sortable : true, align: 'left'},
				{display: 'Actions', name : 'actions', width : 50, sortable : false, align: 'left'}
				],
			buttons : [
				{name: 'Add', bclass: 'flex_add', onpress : add},
				{separator: true},
				{name: 'Delete', bclass: 'flex_delete', onpress : remove},
				{separator: true}
			],
			searchitems : [
				{display: 'Item Type Name', name : 'name', isdefault:true}
			],
			sortname: "name",
			sortorder: "asc",
			usepager: true,
			useRp: true,
			rp: 10,
			width: 740,
			height: "auto"
		});
	}

	function add()
	{
		$("#itemTypeDialog").dialog('open');
	}

	function remove()
	{
		var itemTypeIds= getIdsForDelete($("#itemTypeFlex"), 'itemTypeCheckbox');
		if (itemTypeIds == null) {
			alert("Please select a itemType to delete.");
			return;
		}
		$.post('/admin_item_type/delete/', {itemTypeIds:itemTypeIds}, function(data) {
			//notify user of success
			$("#itemTypeFlex").flexReload();
		});
	}


	function validateAndSubmit()
	{
		var isValid = true;
		if (isValid) {
			$("#itemTypeForm").submit();;
		}
	}

</script>
