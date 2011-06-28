<style>
.sales_form_container li ul li {
	float: left;
	margin: 5px 15px;
}

.sales_form_row {
	clear:both;
}
</style>

<form action="/sales/managesalesform" method="POST">
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
				<select name="item[]" onchange="updatePrice(this)">
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
				<input type="text" name="qty[]" size ="3" value="0" onblur="updateSubTotal(this) , validateQty(this)"/>
			</li>
			<li class="discount">
				<input type="text" size ="6" name="discount[]" onblur="updateSubTotal(this)" value="0.00"/>
			</li>
			<li class="vat">
				<input type="checkbox" name="vat[]" onclick="updateVatSubTotal(this)" value="0" />
			</li>
			<li class="subtotal">
				0.00
			</li>
			<li class="controls">
				<input type="button" value="add" onclick="addRow(this)">
			</li>
		</ul>
	</li>
</div>

<script type="text/javascript">
var priceLookup = new Array();
<?php foreach ($itemDetails as $itemDetail):?>
	priceLookup["<?php echo $itemDetail['itemDetailId']; ?>"] = "<?php echo $itemDetail['sellingPrice'] ?>";
<? endforeach; ?>
var ctr = 0;
var subtotalVATable = 0;

$(document).ready(function(){
	setupRowTemplate();
});

function addRow(obj) {
	$(obj).attr("value", "remove");
	$(obj).attr("onclick", "removeRow(this)");
	setupRowTemplate();
}

function setupRowTemplate() {
	// get the first li in the template and set the ID
	var row = $("#tpl").children()[0];
	$(row).attr("id", "row_" + ++ctr);

	var cells = $(row).children().first().children().each(function(i){
		this.id = this.className + "_" + ctr;
	});

	$("#vat_" + ctr).children().first().attr("value", ctr);
	$(".sales_form_container").append($("#tpl").html());
}

var removeRow = function(obj) {
	$(obj).parent().parent().parent().remove();
}

function updatePrice(obj) {
	var itemSelectedVal = $(obj).val();
	$(obj).parent().next().html(priceLookup[itemSelectedVal]);
	var rowNo = getRowNo(obj);
	$(".discount:#discount_"+rowNo).children().val("0.00");
	$(".quantity:#quantity_"+rowNo).children().val("0");
	$(".subtotal:#subtotal_"+rowNo).html("0.00");

}

function updateSubTotal(obj){
	var rowNo = getRowNo(obj);
	var discount = parseFloat($(".discount:#discount_"+rowNo).children().val());
	var quantity = parseFloat($(".quantity:#quantity_"+rowNo).children().val());
	var price = parseFloat($(".sellingPrice:#sellingPrice_"+rowNo).html());
	var subtotalVAT = 0;
	var subtotal = quantity * price -discount;
	subtotal = subtotal.toFixed(2);
	$(".subtotal:#subtotal_"+rowNo).html(subtotal);
	computeTotal();
}

function computeTotal() {
	var total = 0;
	$(".subtotal:visible").each(function(){
		total += parseInt($(this).html());
		});
	total = total.toFixed(2);
	$("#total").html("Total: " + total);
}



function updateVatSubTotal(obj){
	var rowNo = getRowNo(obj);
	if ($(".vat:#vat_"+rowNo).children().first().prop("checked")){
		subtotalVATable += parseFloat($(".subtotal:#subtotal_"+rowNo).html());

	}
	else {
		subtotalVATable -= parseFloat($(".subtotal:#subtotal_"+rowNo).html());

	}
	var totalVATable = subtotalVATable / 1.12
	var VAT = subtotalVATable - subtotalVATable / 1.12;
	totalVATable = totalVATable.toFixed(2);
	VAT = VAT.toFixed(2);
	$("#vatable").html("VATable: " + totalVATable);
	$("#totalvat").html("Total Vat: " + VAT);
}

function validateQty(obj){
	var rowNo = getRowNo(obj);
	var quantity = $(".quantity:#quantity_"+rowNo).children().val();
	if (quantity <= 0 || isNaN(quantity))
		{
	console.log(quantity);
		}
	else
		{
	console.log('success');
		}
}



function getRowNo(obj){
	var rowId = ($(obj).parent().parent().parent().attr("id"));
	var parts = rowId.split("_");
	return parts[1];
}





</script>
