<form id="editItemDetailForm" action="/admin_item_detail/performsaveorupdate" method="POST" >
	<table class="adminForm">
		<tr>
			<td class="rightAligned">Description:</td>
			<td>
				<input type="text" id="description" name="description" class="longTxt" value="<?php echo $itemDetail['description'] ?>">
				<input type="hidden" id="itemDetailId" name="itemDetailId" value="<?php echo $itemDetail['itemDetailId'] ?>">
			</td>
		</tr>
		<tr>
			<td class="rightAligned">Product Code:</td>
			<td><input type="text" id="productCode" name="productCode" class="longTxt" value="<?php echo $itemDetail['productCode'] ?>"></td>
		</tr>
		<tr>
			<td class="rightAligned">Item Type:</td>
			<td><input type="text" id="itemTypeId" name="itemTypeId" class="longTxt" value="<?php echo $itemDetail['itemTypeId'] ?>"></td>
		</tr>
		<tr>
			<td class="rightAligned">Unit:</td>
			<td><input type="text" id="unit" name="unit" class="longTxt" value="<?php echo $itemDetail['unit'] ?>"></td>
		</tr>
		<tr>
			<td class="rightAligned">Buying Price:</td>
			<td><input type="text" id="buyingPrice" name="buyingPrice" class="longTxt" value="<?php echo $itemDetail['buyingPrice'] ?>"></td>
		</tr>
		<tr>
			<td class="rightAligned">Used:</td>
			<td><input type="checkbox" id="isUsed" name="isUsed" class="longTxt"
			<?php $used = ($itemDetail['isUsed'] == 1) ? 'checked="yes"' : '' ;?>
			<?php echo $used; ?>
			 ></td>
		</tr>
		<tr>
			<td class="rightAligned">Supplier:</td>
			<td><input type="text" id="supplierId" name="supplierId" class="longTxt" value="<?php echo $itemDetail['supplierId'] ?>"></td>
		</tr>
	</table>
	<input type="button" onclick="validateAndSubmit('edit')" value="submit"/>
</form>