<form id="addItemTypeForm" action="/admin_item_type/performsaveorupdate" method="POST" >
	<table>
		<tr>
			<td class="rightAligned">Item Name:</td>
			<td>
				<input type="text" id="name" name="name" class="longTxt">
				<input type="hidden" id="itemTypeId" name="itemTypeId"/>
			</td>
		</tr>
	</table>
	<input type="button" onclick="validateAndSubmit('add')" value="submit"/>
</form>