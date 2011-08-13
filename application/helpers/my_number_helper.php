<?php
function formatMoney($value)
{
	setlocale(LC_MONETARY, 'en_US.UTF-8');
	$value = round($value, 2);
	return '₱' . number_format($value, 2, '.', ',');
}