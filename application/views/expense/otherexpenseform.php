<?php $this->message->display(); ?>

<style> .tabular dt { width: 100px } </style>

<h1>Other Expense Form</h1>

<form name="otherExpenseForm" id="otherExpenseForm" action="/expense/otherexpenseform" method="POST">

	<div id="section">
		<h3>Expense Information</h3>
		<dl class="tabular">
			<dt><label>Description<em>*</em>:</label></dt>
			<dd>
				<input type="text" id="description" name="description" class="longTxt"/>
			</dd>
			<dt><label>Price<em>*</em>:</label></dt>
			<dd>
				<input type="text" id="price" name="price" class="longTxt"/>
			</dd>
			<dt><label>Payee<em>*</em>:</label></dt>
			<dd>
				<input type="text" id="payee" name="payee" class="longTxt"/>
			</dd>
		</dl>
	</div>
	<input id="addAnother" name="addAnother" type="hidden" value=""/>
</form>

<div id="actionsContainer">
	<input type="button" onclick="javascript:submitAndAdd()" value="Save and Add Another"/>
	<input type="button" onclick="javascript:submit()" value="Save and Proceed to Summary"/>
</div>


<script type="text/javascript">
	var validator;

	$(document).ready(function() {
		setValidationRules();
	});

	function submitAndAdd()
	{
		$("#addAnother").val("1");
		$("#otherExpenseForm").submit();
	}

	function submit()
	{
		$('#otherExpenseForm').submit();
	}

	function setValidationRules()
	{
		validator = $("#otherExpenseForm").validate({
			rules: {
				description: 	{ required: true },
				price: 			{ required: true, number: true },
				payee: 			{ required: true }
			}
		});
	}

</script>
