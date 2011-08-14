<style>
	#filterContainer {
		margin-top: 40px;
	}
	#creditDetail {
		width: 200px;
	}
</style>

<h1>
	<img src="/public/images/icons/credit.png" />
	<div>Credit Details</div>
</h1>

<div id="filterContainer">
<label for="filter">Customer</label><input type="text" id="filter"/>
</div>

<div id="details"></div>


<script type="text/javascript">
	$(document).ready(function(){
		initAutoCompleteData();
	});

	//............................................................... autocomplete
	/**
	 * Fetches the data used for autocomplete suggestions
	 * @returns JSON
	 */
	function initAutoCompleteData()
	{
		$.post('/credit_payment/getcustomersforautocomplete', {}, function(data){
			autoCompleteData = eval(data);
			initAutoComplete(autoCompleteData);
		});
	}

	/**
	 * Initializes the autocomplete textbox for a particular sales form row
	 * @param rowCtr
	 */
	function initAutoComplete(data)
	{
		$("#filter").autocomplete({
			minLength: 0,
			source: data,
			select: function(event, ui) {
				doAutoCompleteAction(ui.item);
				$("#filter").val(ui.item.fullname);
				return false;
			},
			change: function(event, ui) {
				if (ui.item == null) {
				}
			}
		});
	}


	function doAutoCompleteAction(item)
	{
		$.post('/credit_payment/detailsforcustomer', {}, function(data){
			$('#details').html(data);
		});
	}
</script>