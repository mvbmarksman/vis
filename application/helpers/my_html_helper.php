<?php
function show($value = null)
{
	if (empty($value)) {
		echo "<span class='subtle'>No data</span>";
		return;
	}
	echo $value;
}
