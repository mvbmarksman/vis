<style>
.sales_form_container li ul li {
	float: left;
	margin: 5px 15px;
}

.sales_form_row {
	clear:both;
}
</style>

<form action="/sales/salesformhandler" method="POST">
	<ul class="sales_form_container">
		<li>
			<ul>
				<li>Item</li>
				<li>Price</li>
				<li>Qty</li>
				<li>Discount</li>
				<li>VAT</li>
				<li>Subtotal</li>
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
			<li>
				<select name="item" onchange="updatePrice(this)">
					<?php foreach ($itemDetails as $itemDetail): ?>
					<option value="<?php echo $itemDetail['itemDetailId'] ?>">
						<?php echo $itemDetail['description'] ?>
					</option>
					<?php endforeach; ?>
				</select>
			</li>
			<li>
				<?php echo $itemDetails[0]['sellingPrice'];?>
			</li>
				<li><input type="text" name="qty[]"/></li>
				<li><input type="text" name="discount[]"/></li>
				<li><input type="checkbox" name="vat[]"/></li>
			<li>100.00</li>
			<li><input type="button" value="add" onclick="addRow(this)"></li>
		</ul>
	</li>
</div>

<script type="text/javascript">
var priceLookup = new Array();
<?php foreach ($itemDetails as $itemDetail):?>
	priceLookup["<?php echo $itemDetail['itemDetailId']; ?>"] = "<?php echo $itemDetail['sellingPrice'] ?>";
<? endforeach; ?>

$(document).ready(function(){
	$(".sales_form_container").append($("#tpl").html());
});

function addRow(obj) {
	$(obj).attr("value", "remove");
	$(obj).attr("onclick", "removeRow(this)");
	$(".sales_form_container").append($("#tpl").html());
}

var removeRow = function(obj) {
	$(obj).parent().parent().parent().remove();
}

function updatePrice(obj) {
	var itemSelectedVal = $(obj).val();
	$(obj).parent().next().html(priceLookup[itemSelectedVal]);
}




</script>
