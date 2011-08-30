<style>
	#sidebar #menu {
		margin: 10px auto;
		font-size: 12px;
	}

	ul#menu, ul#menu ul {
	  list-style-type:none;
	  margin: 0;
	  padding: 0;
	  width: 190px;
	}

	ul#menu a {
	  display: block;
	  text-decoration: none;
	}

	ul#menu li {
	  margin-top: 1px;
	}

	ul#menu li a {
	  background: #6997BF;
	  color: #fff;
	  padding: 0.5em;
	}

	ul#menu li a:hover {
	  background: #FAF1D7;
	  color: #545454;
	}

	ul#menu li ul li a {
	  background: #C3DFF7;
	  color: #545454;
	  padding-left: 20px;
	}

	ul#menu li ul li a:hover {
	  background: #FAF1D7;
	  border-left: 5px #545454 solid;
	  padding-left: 15px;
	}
</style>


<ul id="menu">
	<li>
		<a href="#">Home</a>
	</li>
	<li>
		<a href="#">Sales</a>
		<ul>
			<li><a href="/sales/salesform">Sales Form</a></li>
			<li><a href="/credit_payment/showform">Credit Payment</a></li>
			<li><a href="http://www.php.net/">Sub Menu</a></li>
		</ul>
	</li>
	<li>
		<a href="#">Expenses</a>
	</li>
	<li>
		<a href="/items/transferform">Transfer</a>
	</li>
	<li>
		<a href="#">Reports</a>
	</li>
	<li>
		<a href="#">Admin</a>
		<ul>
			<li><a href="/admin_customer">Customers</a></li>
			<li><a href="/admin_item_detail">Items</a></li>
			<li><a href="/admin_user">Users</a></li>
			<li><a href="/admin_store">Store</a></li>
			<li><a href="/admin_item_type">Item Types</a></li>
		</ul>
	</li>
</ul>

<script>
function initMenu() {
	  $('#menu ul').hide();
	  $('#menu li a').hover(
	    function() {
	      var checkElement = $(this).next();
	      if((checkElement.is('ul')) && (checkElement.is(':visible'))) {
	        return false;
	        }
	      if((checkElement.is('ul')) && (!checkElement.is(':visible'))) {
	        $('#menu ul:visible').slideUp('normal');
	        checkElement.slideDown('normal');
	        return false;
	        }
	      }
	    );
	  }
	$(document).ready(function() {initMenu();});
</script>
