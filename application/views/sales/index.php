<?php
	echo form_open('sales/salesInput');
	echo form_label('Item Detail ID', 'Item Detail ID').form_input($fitemDetailId) . '<br />';
	echo form_label('Unit Price', 'Unit Price'). form_input($funitPrice) . '<br />';
	echo form_label('Qty', 'Qty') . form_input($fqty) . '<br />';
	echo form_label('Discount', 'Discount'). form_input($fdiscount) . '<br />';
	echo form_label('Store Id', 'Store Id'). form_input($fstoreId) . '<br />';
	echo form_label('VAT','VAT') . form_checkbox($fisVAT) . '<br />';
	echo form_label('Full Payment', 'Full Payment'). form_checkbox($fisFullyPaid) . '<br />';
	echo form_submit('submit');
?>










