<h1> Add Customers</h1>

<form name="addCustomerForm" action="/admin_customer/addcustomer" method="POST" />
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
	<input type="submit" />
</form>



