<form id="addItemDetailForm" action="/admin_item_detail/performsaveorupdate" method="POST" >
	<table>
		<tr>
			<td class="rightAligned">Description:</td>
			<td>
				<input type="text" id="description" name="description" class="longTxt">
				<input type="hidden" id="itemDetailId" name="itemDetailId"/>
			</td>
		</tr>
		<tr>
			<td class="rightAligned">Product Code:</td>
			<td><input type="text" id="productCode" name="productCode" class="longTxt"/></td>
		</tr>
		<tr>
			<td class="rightAligned">Item Type:</td>
			<td><input type="text" id="itemTypeId" name="itemTypeId" class="longTxt"/></td>
		</tr>
		<tr>
			<td class="rightAligned">Unit:</td>
			<td><input type="text" id="unit" name="unit" class="longTxt"/></td>
		</tr>
		<tr>
			<td class="rightAligned">Buying Price:</td>
			<td><input type="text" id="buyingPrice" name="buyingPrice" class="longTxt"/></td>
		</tr>
		<tr>
			<td class="rightAligned">Used:</td>
			<td><input type="checkbox" id="isUsed" name="isUsed" class="longTxt"/></td>
		</tr>
		<tr>
			<td class="rightAligned">Supplier:</td>
			<td><input type="checkbox" id="supplierId" name="supplierId" class="longTxt"/></td>
		</tr>
	</table>
	<input type="button" onclick="validateAndSubmit('add')" value="submit"/>
</form>