<?php $this->message->display(); ?>
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
		<form action="/credit/listcredits/" method="POST" id="filterForm">
			<div id="filterBody" style="margin: 5px 7px">
				<div style="margin: 5px 7px">
					<label>Show</label>
					<select id="show_filter" name="show_filter" style="width: 130px">
						<option value="active" <?php echo $showFilter == 'active' ? 'selected="selected"' : '' ?>>Active Credits</option>
						<option value="overdue" <?php echo $showFilter == 'overdue' ? 'selected="selected"' : '' ?>>Overdue</option>
						<option value="paid" <?php echo $showFilter == 'paid' ? 'selected="selected"' : '' ?>>Fully Paid</option>
					</select>
					<span style="margin-left: 15px">
						<label>From</label>
						<input type="text" class="mediumTxt" id="fromDate_filter" name="fromDate_filter" value="<?echo $fromDate ?>"/>
					</span>
					<span style="margin-left: 15px">
						<label>To</label>
						<input type="text" class="mediumTxt" id="toDate_filter" name="toDate_filter" value="<?echo $toDate ?>" />
					</span>
				</div>
				<div id="actions">
					<span><input type="button" value="Clear Filters" onclick="javascript:clearFilters()"/></span>
					<span><input type="submit" value="Apply Filters" /></span>
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
				<th width="50px">Add Payment</th>
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
				<td class="centered"><a href="/credit/creditpaymentform/<?php echo $credit['salesTransactionId'] ?>"><img src="/public/images/icons/money_add.png" title="add payment"/></a></td>
			</tr>
			<?php endforeach; ?>
			<?php if (count($credits) == 0): ?>
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