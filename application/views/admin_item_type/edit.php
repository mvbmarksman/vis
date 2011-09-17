<form id="editItemTypeForm" action="/admin_item_type/performsaveorupdate" method="POST" >
	<table class="adminForm">
		<tr>
			<td class="rightAligned">Name:</td>
			<td>
				<input type="text" id="name" name="name" class="longTxt" value="<?php echo $itemType['name'] ?>">
				<input type="hidden" id="itemTypeId" name="itemTypeId" value="<?php echo $itemType['itemTypeId'] ?>"/>
			</td>
		</tr>
		<tr>
			<td class="rightAligned">Address:</td>
			<td><textarea id="address" name="address" rows="2" cols="22" ><?php echo $customer['address'] ?></textarea></td>
		</tr>
		<tr>
			<td class="rightAligned">Contact Number:</td>
			<td><input type="text" id="contact" name="contact" class="longTxt" value="<?php echo $customer['phoneNo'] ?>" /></td>
		</tr>
	</table>
	<input type="button" onclick="validateAndSubmit('edit')" value="submit"/>
</form>