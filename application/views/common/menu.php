<ul id="menu">
	<li>
		<a href="/dashboard/index">Dashboard</a>
	</li>
	<li>
		<a href="#" class="arrowCursor">Sales</a>
		<ul>
			<li><a href="/sales/salesform">Sales Form</a></li>
			<li><a href="/sales/dailysales">Daily Sales Report</a></li>
		</ul>
	</li>
	<li>
		<a href="#" class="arrowCursor">Expenses</a>
		<ul>
			<li><a href="/expense/inventoryexpenseform">Inventory Expense Form</a></li>
			<li><a href="/expense/inventoryexpenseform/1">New Item Expense Form</a></li>
			<li><a href="/expense/otherexpenseform">Other Expense Form</a></li>
			<li><a href="/expense/dailyexpense">Daily Expense Report</a></li>
		</ul>
	</li>
	<li>
		<a href="/credit/listcredits">Credit List</a>
	</li>
	<li>
		<a href="/payables/listpayables">Payables List</a>
	</li>
	<li>
		<a href="#">Reports</a>
	</li>
	<li>
		<a href="#" class="arrowCursor">Admin</a>
		<ul>
			<li><a href="/admin_customer">Customers</a></li>
			<li><a href="/admin_item_detail">Items</a></li>
			<li><a href="/admin_user">Users</a></li>
			<li><a href="/admin_item_type">Item Types</a></li>
		</ul>
	</li>
</ul>

<script>
function initMenu() {
	  //$('#menu ul').hide();
	  $('#menu li a').hover(
	    function() {
	      var checkElement = $(this).next();
	      if((checkElement.is('ul')) && (checkElement.is(':visible'))) {
	        return false;
	        }
	      if((checkElement.is('ul')) && (!checkElement.is(':visible'))) {
	        //$('#menu ul:visible').slideUp('normal');
	        checkElement.slideDown('normal');
	        return false;
	        }
	      }
	    );
}
$(document).ready(function() {initMenu();});
</script>
