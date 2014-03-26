<?php
	include_once('../php_pages/connect.php');
	$output=array();
	$query=pg_query("SELECT DISTINCT(bankname) FROM ifsccodes_n ORDER BY bankname");
	$result=pg_fetch_all($query);
	echo json_encode($result);
?>