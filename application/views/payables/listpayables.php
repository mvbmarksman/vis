<style>
	.tabular dt { width: 100px; padding-right: 20px; }
	#section h4 { text-align: left; margin-top: 5px; }
	.summaryTable { margin-top: 10px; }
	#totalContainer { margin-top: 25px; text-align: right; font-size: 13px; }
	#totalContainer strong{ font-weight: bold; }
	#section { margin-top: 10px }

	#filterContainer {
	    border: 1px solid silver;
	    margin-top: 15px;
	}

	#filterContainer h1 {
		background: url("/public/images/icons/arrow_down.png") no-repeat scroll 5px 6px #F2F2F2;
	    color: #545454;
	    cursor: pointer;
	    font-size: 12px;
	    font-weight: normal;
	    margin: 0;
	    padding: 5px 5px 5px 16px;
	}

	#filterBody ul {
	    margin: "5px 7px";
	}

	#filterBody ul li {
		margin-top: 10px;
	}

	#filterBody ul li span {
		margin-left: 15px;
	}

	#filterBody ul li span label {
		width: 200px;
		text-align: right;
	}

	#filterBody #actions {
		text-align:right;
		border-top: 1px dotted silver;
		padding: 3px 0;
		margin-top: 5px;
	}

</style>

<h1>Payables List</h1>

<div id="filterContainer">
	<h1>Filters</h1>
	<form action="/payables/listpayables/" method="POST" id="filterForm">
	<div id="filterBody">
		<ul>
			<li>
				<span>
					<label>Show</label>
					<select id="show_filter" name="show_filter" class="longTxt">
						<option value="active" <?php echo $showFilter == 'active' ? 'selected="selected"' : '' ?>>Active Credits</option>
						<option value="overdue" <?php echo $showFilter == 'overdue' ? 'selected="selected"' : '' ?>>Overdue</option>
						<option value="paid" <?php echo $showFilter == 'paid' ? 'selected="selected"' : '' ?>>Fully Paid</option>
					</select>
				</span>
				<span>
					<label>Supplier</label>
					<select id="supplier_filter" name="supplier_filter" class="longTxt">
						<option value="">Any</option>
						<?php foreach ($suppliers as $supplier): ?>
							<option value="<?php echo $supplier['supplierId'] ?>" <?php if ($supplierFilter == $supplier['supplierId']) echo 'selected="selected"' ?> >
								<?php echo $supplier['name'] ?>
							</option>
						<?php endforeach ?>
					</select>
				</span>
			</li>
			<li>
				<span>
					<label>From</label>
					<input type="text" class="longTxt" id="fromDate_filter" name="fromDate_filter" value="<?php echo $fromDate ?>"/>
				</span>
				<span style="margin-left: 46px">
					<label>To</label>
					<input type="text" class="longTxt" id="toDate_filter" name="toDate_filter" value="<?php echo $toDate ?>" />
				</span>
			</li>
			<li id="actions">
				<span><input type="button" value="Clear Filters" onclick="javascript:clearFilters()"/></span>
				<span><input type="submit" value="Filter Results" /></span>
			</li>
		</ul>
	</div>
	</form>
</div>

<div id="section">
	<table class="summaryTable">
		<thead>
			<tr>
				<th width="40px">ID</th>
				<th>Item Name</th>
				<th width="60px">Cost</th>
				<th width="120px">Supplier</th>
				<th width="90px">Transaction Date</th>
				<th width="50px">Flag as Paid</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($payables as $payable): ?>
			<?php
				$ctr = 0;
				$ctr++;
			?>
			<tr class="<?php echo $ctr % 2 == 0 ? 'hiliteRow' : ''?>">
				<td class="rightAligned">
					<a href="/expense/dailyexpense/<?php echo date('Y-m-d', strtotime($payable['dateAdded'])) ?>"><?php echo $payable['itemExpenseId'] ?></a>
				</td>
				<td>
					<a href="/item/view/<?php echo $payable['itemId'] ?>"><?php echo $payable['itemDescription'] . '[ ' . $payable['itemProductCode'] . ' ]'  ?></a>
				</td>
				<td class="rightAligned"><?php echo formatMoney($payable['price'] * $payable['quantity']) ?></td>
				<td>
					<a href="/supplier/view/<?php echo $payable['supplierId']?>"><?php show($payable['supplierName']) ?></a>
				</td>
				<td class="centered"><?php echo date('Y-m-d', strtotime($payable['dateAdded'])) ?></td>
				<td class="centered">
					<?php if ($payable['isFullyPaid'] == 0): ?>
						<a href="#"><img src="/public/images/icons/flag_green.png" title="flag as paid"/></a>
					<?php else: ?>
						<span class="fullyPaid">fully paid</span>
					<?php endif ?>

				</td>
			</tr>
			<?php endforeach; ?>
			<?php if (count($payables) == 0): ?>
			<tr>
				<td colspan="7">Nothing to display.</td>
			</tr>
			<?php endif; ?>
		</tbody>
	</table>
</div>

<script type="text/javascript">
	$(document).ready(function(){
		$("#filterBody").hide();
		$("#filterContainer h1").click(function(){
			$("#filterBody").slideToggle();
		});

		$("#fromDate_filter").datepicker({
			dateFormat: 'yy-mm-dd'
		});

		$("#toDate_filter").datepicker({
			dateFormat: 'yy-mm-dd'
		});
	});

	function clearFilters() {
                var cookiePrefix = "<?php echo $cookiePrefix ?>";
		$("#show_filter").val("active");
		$("#fromDate_filter").val("");
		$("#toDate_filter").val("");
		deleteCookie(cookiePrefix + '_show');
        deleteCookie(cookiePrefix + '_fromDate');
		deleteCookie(cookiePrefix + '_toDate');
		$("#filterForm").submit();
	}
</script>