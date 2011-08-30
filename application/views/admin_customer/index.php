<div id="flashMsg" style="display:none"></div>
<div id="errorMsg" style="display:none"></div>

<h1>Customer List</h1>
<div id="customerFlex"></div>

<div id="viewCustomerDialog"></div>
<div id="addCustomerDialog"></div>
<div id="editCustomerDialog"></div>


<script type="text/javascript">

	$(document).ready(function(){
		initFlexigrid();
	});


	function initFlexigrid()
	{
		$("#customerFlex").flexigrid({
			url: '/admin_customer/getgriddata',
			dataType: 'json',
			resizable: false,
			showTableToggleBtn: false,
			colModel : [
				{display: '', name : 'check', width : 30, sortable : true, align: 'center'},
				{display: 'ID', name : 'customerId', width : 50, sortable : true, align: 'center'},
				{display: 'Name', name : 'fullname', width : 200, sortable : true, align: 'left'},
				{display: 'Address', name : 'address', width : 270, sortable : true, align: 'left'},
				{display: 'Phone No', name : 'phoneNo', width : 75, sortable : true, align: 'left'},
				{display: 'Actions', name : 'actions', width : 50, sortable : false, align: 'left'}
				],
			buttons : [
				{name: 'Add', bclass: 'flex_add', onpress : add},
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
	}


	function remove()
	{
		var customerIds= getIdsForDelete($("#customerFlex"), 'customerCheckbox');
		if (customerIds == null) {
			alert("Please select a customer to delete.");
			return;
		}
		$.post('/admin_customer/delete/', {customerIds:customerIds}, function(data) {
			flashMsg("Successfully deleted customer(s).");
			$("#customerFlex").flexReload();
		});
	}

	function validateAndSubmit(type)
	{
		var isValid = true;
		if (isValid) {

			var form = "#"+type+"CustomerForm";
			var modalDialog = "#"+type+"CustomerDialog";
			var msg = "Successfully "+type+"ed customer.";

			var action = $(form).prop("action");
			var postData = $(form).serialize();
			$.post(action, postData, function(data) {
				$(modalDialog).dialog("close");
				$("#customerFlex").flexReload();
				flashMsg(msg);
			}).error(function(data){
				$(modalDialog).dialog("close");
				$("#customerFlex").flexReload();
				flashError("A server error occurred.  Unable to save changes.");
			});
		}
	}

	function view(customerId)
	{
		$.post('/admin_customer/view/', {customerId:customerId}, function(data) {
			$("#viewCustomerDialog").html(data);
			$("#viewCustomerDialog").dialog({
				autoOpen: true,
				title: "Customer Information",
				modal: true,
				height: "auto",
				width: 400
			});
		});
	}


	function add()
	{
		$.post('/admin_customer/add/', {}, function(data) {
			$("#addCustomerDialog").html(data);
			$("#addCustomerDialog").dialog({
				autoOpen: true,
				title: "Customer Information",
				modal: true,
				height: "auto",
				width: 400
			});
		});
	}


	function edit(customerId)
	{
		$.post('/admin_customer/edit/', {customerId:customerId}, function(data) {
			$("#editCustomerDialog").html(data);
			$("#editCustomerDialog").dialog({
				autoOpen: true,
				title: "Customer Information",
				modal: true,
				height: "auto",
				width: 400
			});
		});
	}

</script>
