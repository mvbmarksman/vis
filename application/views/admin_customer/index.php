<h1>Customer List</h1>
<div id="customerFlex"></div>

<div id="customerDialog" style="display:none">
	<form id="customerForm" action="/admin_customer/performsaveorupdate" method="POST" >
		<table>
			<tr>
				<td class="rightAligned">Name:</td>
				<td>
					<input type="text" id="name" name="name" class="longTxt">
					<input type="hidden" id="customerId" name="customerId"/>
				</td>
			</tr>
			<tr>
				<td class="rightAligned">Address:</td>
				<td><textarea id="address" name="address" rows="2" cols="22" ></textarea></td>
			</tr>
			<tr>
				<td class="rightAligned">Contact Number:</td>
				<td><input type="text" id="contact" name="contact" class="longTxt"/></td>
			</tr>
		</table>
		<input type="button" onclick="validateAndSubmit()" />
	</form>
</div>

<script type="text/javascript">

	$(document).ready(function(){

		$("#customerDialog").dialog({
			autoOpen: false,
			title: "Customer Information"
		});

		$("#customerFlex").flexigrid({
			url: '/admin_customer/getgriddata',
			dataType: 'json',
			resizable: false,
			showTableToggleBtn: false,
			colModel : [
				{display: '', name : 'check', width : 30, sortable : true, align: 'center'},
				{display: 'ID', name : 'customerId', width : 50, sortable : true, align: 'center'},
				{display: 'Name', name : 'fullname', width : 250, sortable : true, align: 'left'},
				{display: 'Address', name : 'address', width : 270, sortable : true, align: 'left'},
				{display: 'Phone No', name : 'phoneNo', width : 75, sortable : true, align: 'left'}
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
				{display: 'Full Name', name : 'fullname', isdefault:true}
			],
			sortname: "fullname",
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
		$("#customerDialog").dialog('open');
	}

	function remove()
	{
		var customerIds= getIdsForDelete($("#customerFlex"), 'customerCheckbox');
		if (customerIds == null) {
			alert("Please select a customer to delete.");
			return;
		}
		$.post('/admin_customer/delete/', {customerIds:customerIds}, function(data) {
			// TODO notify user of success
			$("#customerFlex").flexReload();
		});
	}

	function edit()
	{
		var customerId = getIdForEdit($("#customerFlex"), 'customerCheckbox');
		if (customerId == null) {
			alert("Please select a customer to edit.");
			return;
		}
		$.post('/admin_customer/getcustomerdata/', {customerId:customerId}, function(data) {
			var customerData = eval("(" + data + ")");
			$("#customerId").val(customerData.customerId);
			$("#name").val(customerData.fullname);
			$("#address").val(customerData.address);
			$("#contact").val(customerData.phoneNo);
			$("#customerDialog").dialog('open');
		});
	}

	function validateAndSubmit()
	{
		var isValid = true;
		if (isValid) {
			$("#customerForm").submit();;
		}
	}

</script>
