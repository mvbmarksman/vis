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
	    border-top: 1px solid silver;
	    padding: 10px 10px 0;
	}

	#filterBody ul li {
		padding: 5px 0px;
	}
	#filterBody #actions {
		text-align:right;
		border-top: 1px dotted silver;
		padding: 3px 0;
		margin-top: 5px;
	}

</style>

<h1>Credits</h1>

<div id="filterContainer">
	<h1>Filters</h1>
		<form action="/credit/listcredits/" method="GET">
			<div id="filterBody">
				<div style="margin: 5px 7px">
					<label>Show</label>
					<select id="showFilter" name="showFilter" style="width: 130px">
						<option value="active">Active Credits</option>
						<option value="overdue">Overdue</option>
						<option value="paid">Fully Paid</option>
					</select>
					<span style="margin-left: 15px">
						<label>From</label>
						<input type="text" class="mediumTxt" id="fromDate" name="fromDate" />
					</span>
					<span style="margin-left: 15px">
						<label>To</label>
						<input type="text" class="mediumTxt" id="toDate" name="toDate" />
					</span>
				</div>
				<div id="actions">
					<span><input type="button" value="Clear Filters" onclick="javascript:clearFilters()"/></span>
					<span><input type="submit" value="Filter Results" /></span>
				</div>
			</div>
		</form>
</div>

<div id="section">
	<table class="summaryTable">
		<thead>
			<tr>
				<th width="40px">ID</th>
				<th>Customer</th>
				<th width="60px">Due Date</th>
				<th width="90px">Total Amount</th>
				<th width="90px">Amount Paid</th>
				<th width="90px">Balance</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($credits as $credit): ?>
			<?php
				$ctr = 0;
				$ctr++;
			?>
			<tr class="<?php echo $ctr % 2 == 0 ? 'hiliteRow' : ''?>">
				<td class="rightAligned">
					<a href="/sales/summary/<?php echo $credit['salesTransactionId'] ?>"><?php echo $credit['salesTransactionId'] ?></a>
				</td>
				<td><a href="/customer/view/<?php echo $credit['customerId'] ?>"><?php echo $credit['fullname'] ?></a></td>
				<td class="centered"><?php echo $credit['dueDate'] ?></td>
				<td class="rightAligned"><?php echo formatMoney($credit['totalPrice']) ?></td>
				<td class="rightAligned"><?php echo formatMoney($credit['totalAmountPaid']) ?></td>
				<td class="rightAligned"><?php echo formatMoney($credit['totalPrice'] - $credit['totalAmountPaid']) ?></td>
				<td class="centered"><a href="/credit/creditpaymentform/<?php echo $credit['salesTransactionId'] ?>">Record a Payment</a></td>
			</tr>
			<?php endforeach; ?>
			<?php if (count($credits) == 0): ?>
			<tr>
				<td colspan="7">No overdue credits.</td>
			</tr>
			<?php endif; ?>
		</tbody>
	</table>
</div>

<script type="text/javascript">
	$(document).ready(function(){
		$("#filterContent").hide();
		$("#filterContainer h1").click(function(){
			$("#filterBody").slideToggle();
		});

		$("#fromDate").datepicker({
			dateFormat: 'yy-mm-dd'
		});

		$("#toDate").datepicker({
			dateFormat: 'yy-mm-dd'
		});
	});

	function clearFilters() {
		$("#showFilter").val("active");
		$("#fromDate").val("");
		$("#toDate").val("");
		$.cookie('showFilter', null);
		$.cookie('fromDate', null);
		$.cookie('toDate', null);
	}

</script>