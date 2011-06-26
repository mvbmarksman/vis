<style>
.sales_form_container li {
	float: left;
	margin: 5px 15px;
}
</style>

<form action="/sales/salesformhandler" method="POST">
	<ul class="sales_form_container">
		<li>
			<ul class="sales_form_row">
				<li><select></select></li>
				<li>100.00</li>
				<li><input type="text" name="qty[]"/></li>
				<li><input type="text" name="discount[]"/></li>
				<li><input type="checkbox" name="vat[]"/></li>
				<li>100.00</li>
				<li><input type="button" value="add" onclick="addRow(this)"></li>
			</ul>
		</li>
	</ul>
	<div class="clear"></div>
	<input type="submit">
</form>

<!-- used as template for dynamically adding rows -->
<div id="tpl" style="display:none">
	<li>
		<ul class="sales_form_row">
			<li><select></select></li>
			<li>100.00</li>
				<li><input type="text" name="qty[]"/></li>
				<li><input type="text" name="discount[]"/></li>
				<li><input type="checkbox" name="vat[]"/></li>
			<li>100.00</li>
			<li><input type="button" value="add" onclick="addRow(this)"></li>
		</ul>
	</li>
</div>

<script type="text/javascript">
function addRow(obj) {
	$(obj).attr("value", "remove");
	$(obj).attr("onclick", "removeRow(this)");
	$(".sales_form_container").append($("#tpl").html());
}

var removeRow = function(obj) {
	$(obj).parent().parent().parent().remove();
}
</script>
