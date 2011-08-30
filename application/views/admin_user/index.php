<h1>User List</h1>
<div id="userFlex"></div>

<div id="userDialog" style="display:none">
	<form id="userForm" action="/admin_user/performsaveorupdate" method="POST" >
		<table>
			<tr>
				<td class="rightAligned">Username:</td>
				<td>
					<input type="text" id="username" name="username" class="longTxt">
					<input type="hidden" id="userId" name="userId"/>
				</td>
			</tr>
			<tr>
				<td class="rightAligned">Password:</td>
				<td>
					<input type="password" id="password" name="password" class="longTxt">
				</td>
			</tr>
			<tr>
				<td class="rightAligned">Verify Password:</td>
				<td>
					<input type="password" id="verifypassword" name="verifypassword" class="longTxt">
				</td>
			</tr>
			<tr>
				<td class="rightAligned">First Name:</td>
				<td>
					<input type="text" id="firstName" name="firstName" class="longTxt">
				</td>
			</tr>
			<tr>
				<td class="rightAligned">Last Name:</td>
				<td>
					<input type="text" id="lastName" name="lastName" class="longTxt">
				</td>
			</tr>
			<tr>
				<td class="rightAligned">Admin </td>
				<td>
					<input type="checkbox" id="isAdmin" name="isAdmin" class="longTxt">
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
		$("#userDialog").dialog({
			autoOpen: false,
			title: "User Information"
		});
	}

	function initFlexigrid()
	{
		$("#userFlex").flexigrid({
			url: '/admin_user/getgriddata',
			dataType: 'json',
			resizable: false,
			showTableToggleBtn: false,
			colModel : [
				{display: '', name : 'check', width : 30, sortable : true, align: 'center'},
				{display: 'Id', name : 'userId', width : 50, sortable : true, align: 'center'},
				{display: 'Username', name : 'username', width : 250, sortable : true, align: 'left'},
				{display: 'Password', name : 'password', width : 270, sortable : true, align: 'left'},
				{display: 'First Name', name : 'firstName', width : 75, sortable : true, align: 'left'},
				{display: 'Last Name', name : 'lastName', width : 75, sortable : true, align: 'left'},
				{display: 'Admin', name : 'isAdmin', width : 75, sortable : true, align: 'left'},
				{display: 'Actions', name : 'actions', width : 50, sortable : false, align: 'left'}
				],
			buttons : [
				{name: 'Add', bclass: 'flex_add', onpress : add},
				{separator: true},
				{name: 'Delete', bclass: 'flex_delete', onpress : remove},
				{separator: true}
			],
			searchitems : [
				{display: 'Username', name : 'username', isdefault:true}
			],
			sortname: "username",
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
		$("#userDialog").dialog('open');
	}

	function remove()
	{
		var userIds= getIdsForDelete($("#userFlex"), 'userCheckbox');
		if (userIds == null) {
			alert("Please select a user to delete.");
			return;
		}
		$.post('/admin_user/delete/', {userIds:userIds}, function(data) {
			//notify user of success
			$("#userFlex").flexReload();
		});
	}


	function validateAndSubmit()
	{
		var isValid = true;
		if (isValid) {
			$("#userForm").submit();;
		}
	}

</script>
