<?php
	include_once('../php_pages/connect.php');
	$query=pg_query("SELECT DISTINCT(formno) FROM form_chk_list ORDER BY formno");
	$result=pg_fetch_all($query);
	echo json_encode($result);
?>