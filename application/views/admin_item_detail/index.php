<div id="flashMsg" style="display:none"></div>
<div id="errorMsg" style="display:none"></div>

<h1>Item Detail List</h1>
<div id="itemDetailFlex"></div>

<div id="viewItemDetailDialog"></div>
<div id="addItemDetailDialog"></div>
<div id="editItemDetailDialog"></div>

<script type="text/javascript">

	$(document).ready(function(){
		initFlexigrid();
	});


	function initFlexigrid()
	{
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
				{display: 'Supplier', name : 'supplierId', width : 75, sortable : true, align: 'left'},
				{display: 'Actions', name : 'actions', width : 50, sortable : false, align: 'left'}
				],
			buttons : [
						{name: 'Add', bclass: 'flex_add', onpress : add},
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
	}

	function remove()
	{
		var itemDetailIds= getIdsForDelete($("#itemDetailFlex"), 'itemDetailCheckbox');
		if (itemDetailIds == null) {
			alert("Please select an item to delete.");
			return;
		}
		$.post('/admin_item_detail/delete/', {itemDetailIds:itemDetailIds}, function(data) {
			flashMsg("Successfully deleted item(s).");
			$("#itemDetailFlex").flexReload();
		});
	}


	function validateAndSubmit(type)
	{
		var isValid = true;
		if (isValid) {

			var form = "#"+type+"ItemDetailForm";
			var modalDialog = "#"+type+"ItemDetailDialog";
			var msg = "Successfully "+type+"ed item detail.";

			var action = $(form).prop("action");
			var postData = $(form).serialize();
			$.post(action, postData, function(data) {
				$(modalDialog).dialog("close");
				$("#itemDetailFlex").flexReload();
				flashMsg(msg);
			}).error(function(data){
				$(modalDialog).dialog("close");
				$("#itemDetailFlex").flexReload();
				flashError("A server error occurred.  Unable to save changes.");
			});
		}
	}

	function view(itemDetailId)
	{
		$.post('/admin_item_detail/view/', {itemDetailId:itemDetailId}, function(data) {
			$("#viewItemDetailDialog").html(data);
			$("#viewItemDetailDialog").dialog({
				autoOpen: true,
				title: "Item Detail Information",
				modal: true,
				height: "auto",
				width: 400
			});
		});
	}


	function add()
	{
		$.post('/admin_item_detail/add/', {}, function(data) {
			$("#addItemDetailDialog").html(data);
			$("#addItemDetailDialog").dialog({
				autoOpen: true,
				title: "Item Detail Information",
				modal: true,
				height: "auto",
				width: 400
			});
		});
	}


	function edit(itemDetailId)
	{
		$.post('/admin_item_detail/edit/', {itemDetailId:itemDetailId}, function(data) {
			$("#editItemDetailDialog").html(data);
			$("#editItemDetailDialog").dialog({
				autoOpen: true,
				title: "Item Detail Information",
				modal: true,
				height: "auto",
				width: 400
			});
		});
	}

</script>
