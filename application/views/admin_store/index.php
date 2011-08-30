<h1>Store List</h1>
<div id="storeFlex"></div>

<div id="storeDialog" style="display:none">
	<form id="storeForm" action="/admin_store/performsaveorupdate" method="POST" >
		<table>
			<tr>
				<td class="rightAligned">Name:</td>
				<td>
					<input type="text" id="name" name="name" class="longTxt">
					<input type="hidden" id="storeId" name="storeId"/>
				</td>
			</tr>
			<tr>
				<td class="rightAligned">Location:</td>
				<td><input type="text" id="location" name="location" class="longTxt"/></td>
			</tr>
			<tr>
		</table>
		<input type="button" onclick="validateAndSubmit()" />
	</form>
</div>

<script type="text/javascript">

	$(document).ready(function(){

		$("#storeDialog").dialog({
			autoOpen: false,
			title: "Store Information"
		});

		$("#storeFlex").flexigrid({
			url: '/admin_store/getgriddata',
			dataType: 'json',
			resizable: false,
			showTableToggleBtn: false,
			colModel : [
				{display: '', name : 'check', width : 30, sortable : true, align: 'center'},
				{display: 'Store Id', name : 'storeId', width : 50, sortable : true, align: 'center'},
				{display: 'Store Name', name : 'name', width : 250, sortable : true, align: 'left'},
				{display: 'Location', name : 'location', width : 270, sortable : true, align: 'left'},
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
				{display: 'Store Name', name : 'name', isdefault:true}
			],
			sortname: "name",
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
		$("#storeDialog").dialog('open');
	}

	function remove()
	{
		var storeIds= getIdsForDelete($("#storeFlex"), 'storeCheckbox');
		if (storeIds == null) {
			alert("Please select a store to delete.");
			return;
		}
		$.post('/admin_store/delete/', {storeIds:storeIds}, function(data) {
			// TODO notify user of success
			$("#storeFlex").flexReload();
		});
	}

	function edit()
	{
		var storeId = getIdForEdit($("#storeFlex"), 'storeCheckbox');
		if (storeId == null) {
			alert("Please select a store to edit.");
			return;
		}
		$.post('/admin_store/getstoredata/', {storeId:storeId}, function(data) {
			var storeData = eval("(" + data + ")");
			$("#storeId").val(storeData.storeId);
			$("#name").val(storeData.fullname);
			$("#address").val(storeData.address);
			$("#contact").val(storeData.phoneNo);
			$("#storeDialog").dialog('open');
		});
	}

	function validateAndSubmit()
	{
		var isValid = true;
		if (isValid) {
			$("#storeForm").submit();;
		}
	}

</script>
