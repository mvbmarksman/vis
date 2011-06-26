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
	<ul>
		<li id="vatable">Vatable</li>
		<li id="totalvat">TotalVAT</li>
		<li id="total">Total</li>
	</ul>
	<input type="submit">
</form>

<!-- used as template for dynamically adding rows -->
<div id="tpl" style="display:none">
	<li id="row_1">
		<ul class="sales_form_row">
			<li class="itemDetails">
				<select name="item" onchange="updatePrice(this)">
					<?php foreach ($itemDetails as $itemDetail): ?>
					<option value="<?php echo $itemDetail['itemDetailId'] ?>">
						<?php echo $itemDetail['description'] ?>
					</option>
					<?php endforeach; ?>
				</select>
			</li>
			<li class="sellingPrice">
				<?php echo $itemDetails[0]['sellingPrice'];?>
			</li>
			<li class="quantity">
				<input type="text" name="qty[]" size ="3" value="0" onblur="updateSubTotal(this)"/>
			</li>
			<li class="discount">
				<input type="text" size ="6" name="discount[]" value="0.00"/>
			</li>
			<li class="vat">
				<input type="checkbox" name="vat[]"/>
			</li>
			<li class="subtotal">
				5
			</li>
			<li class="controls">
				<input type="button" value="add" onclick="addRow(this)">
			</li>
		</ul>
	</li>
</div>

<input type="button" onclick="computeTotal()">

<script type="text/javascript">
var priceLookup = new Array();
<?php foreach ($itemDetails as $itemDetail):?>
	priceLookup["<?php echo $itemDetail['itemDetailId']; ?>"] = "<?php echo $itemDetail['sellingPrice'] ?>";
<? endforeach; ?>
var ctr = 1;

$(document).ready(function(){
	$(".sales_form_container").append($("#tpl").html());
});

function addRow(obj) {
	$(obj).attr("value", "remove");
	$(obj).attr("onclick", "removeRow(this)");

	// get the first li in the template and set the ID
	var row = $("#tpl").children()[0];
	$(row).attr("id", "row_" + ++ctr);

	var cells = $(row).children().first().children().each(function(i){
		this.id = this.className + "_" + ctr;
	});

	$(".sales_form_container").append($("#tpl").html());
}

var removeRow = function(obj) {
	$(obj).parent().parent().parent().remove();
}

function updatePrice(obj) {
	var itemSelectedVal = $(obj).val();
	$(obj).parent().next().html(priceLookup[itemSelectedVal]);
}

function updateSubTotal(obj){
	alert("test");
}

function computeTotal() {
	var total = 0;
	$(".subtotal:visible").each(function(){
		total += parseInt($(this).html());
		return total;
	});
	console.log(total);
}


</script>
