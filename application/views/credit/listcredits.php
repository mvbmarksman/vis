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

<h1>Credit List</h1>

<div id="filterContainer">
	<h1>Filters</h1>
		<form action="/credit/listcredits/" method="GET" id="filterForm">
			<div id="filterBody">
				<div style="margin: 5px 7px">
					<label>Show</label>
					<select id="showFilter" name="showFilter" style="width: 130px">
						<option value="active" <?php echo $showFilter == 'active' ? 'selected="selected"' : '' ?>>Active Credits</option>
						<option value="overdue" <?php echo $showFilter == 'overdue' ? 'selected="selected"' : '' ?>>Overdue</option>
						<option value="paid" <?php echo $showFilter == 'paid' ? 'selected="selected"' : '' ?>>Fully Paid</option>
					</select>
					<span style="margin-left: 15px">
						<label>From</label>
						<input type="text" class="mediumTxt" id="fromDate" name="fromDate" value="<?echo $fromDate ?>"/>
					</span>
					<span style="margin-left: 15px">
						<label>To</label>
						<input type="text" class="mediumTxt" id="toDate" name="toDate" value="<?echo $toDate ?>" />
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
				<th width="60px">Transaction Date</th>
                                <th width="60px">Due Date</th>
				<th width="60px">Total Amount</th>
				<th width="60px">Amount Paid</th>
				<th width="60px">Balance</th>
				<th width="80px">Actions</th>
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
				<td class="centered"><?php echo date('Y-m-d', strtotime($credit['transactionDate'])) ?></td>
                                <td class="centered"><?php echo $credit['dueDate'] ?></td>
				<td class="rightAligned"><?php echo formatMoney($credit['totalPrice']) ?></td>
				<td class="rightAligned"><?php echo formatMoney($credit['totalAmountPaid']) ?></td>
				<td class="rightAligned"><?php echo formatMoney($credit['totalPrice'] - $credit['totalAmountPaid']) ?></td>
				<td class="centered"><a href="/credit/creditpaymentform/<?php echo $credit['salesTransactionId'] ?>">Add Payment</a></td>
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
		$("#filterBody").hide();
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
                deleteCookie('filter_showFilter');
                deleteCookie('filter_fromDate');
                deleteCookie('filter_toDate');
		$("#filterForm").submit();
	}
</script>