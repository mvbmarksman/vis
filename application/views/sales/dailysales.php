<h1>Daily Sales Report</h1>
<div id="section">
    <div style="text-align: right">
        <label>Expense Report for:</label>
        <input type="text" id="datepicker" name="datepicker" value="<?php echo $date ?>"/>
    </div>

    <table class="summaryTable" style="margin-top: 15px">
        <thead>
            <tr>
                <th width="50px">Transaction ID</th>
                <th width="100px">Total Amount</th>
                <th width="50px">Is Credit</th>
                <th width="10px">Credit Payments</th>
                <th>Customer</th>
            </tr>
        </thead>
        <tbody id="salesFormBody">
            <?php
            $ctr = 0;
            $total = 0;
            ?>
            <?php foreach ($salesTransactions as $salesTransaction): ?>
                <?php
                $ctr++;
                $total += $salesTransaction['totalPrice'];
                ?>
                <tr class="<?php echo $ctr % 2 == 0 ? 'hiliteRow' : '' ?>">
                    <td><a href="/sales/summary/<?php echo $salesTransaction['salesTransactionId'] ?>"><?php echo $salesTransaction['salesTransactionId']?></a></td>
                    <td class="rightAligned"><?php echo formatMoney($salesTransaction['totalPrice']) ?></td>
                    <td class="centered"><?php echo empty($salesTransaction['isCredit']) ? 'no' : 'yes' ?></td>
                    <td class="centered">
                        <?php if (empty($salesTransaction['isCredit'])) {
                            echo '<span class="subtle">n/a</span>';
                        } else {
                            if (!empty($salesTransaction['isFullyPaid'])) {
                                echo 'fully paid';
                            } else {
                                echo formatMoney($salesTransaction['totalAmountPaid']);
                            }
                        }
                        ?>
                    </td>
                    <td><a href="/customer/view/<?php echo $salesTransaction['customerId'] ?>"><?php echo $salesTransaction['fullname'] ?></a></td>

                </tr>
            <?php endforeach; ?>
            <?php if (count($salesTransactions) == 0): ?>
                <tr>
                    <td colspan="7">No sales transactions for this date.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <?php if ($total > 0) : ?>
    <div style="text-align:right; margin-top:15px">
        <strong>Total Sales :</strong> <?php echo formatMoney($total) ?>
    </div>
    <?php endif ?>
</div>

<script type="text/javascript">
	$(document).ready(function(){
		$("#datepicker").datepicker({
			dateFormat: 'yy-mm-dd',
			onSelect: function(dateText, inst) {
				document.location = '/sales/dailysales/' + dateText;
			}
		});
	});
</script>