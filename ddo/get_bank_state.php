<?php
	include_once('../php_pages/connect.php');
	$bname=$_POST['bname'];
	$query=pg_query("SELECT DISTINCT(state) FROM ifsccodes_n WHERE bankname='$bname' ORDER BY state");
	$result=pg_fetch_all($query);
	echo json_encode($result);
?>