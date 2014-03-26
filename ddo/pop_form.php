<?php
	include_once('../php_pages/connect.php');
	$query = pg_query("UPDATE npayments SET billstatus=5 WHERE transid='20131400000007'" );
?>