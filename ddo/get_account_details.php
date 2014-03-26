<?php
	include_once('../php_pages/connect.php');
	$apno=$_POST['apno'];
	$query=pg_query("SELECT bankacno FROM pao_ddo_party WHERE agency_pan_tan='$apno'");
	$result=pg_fetch_all($query);
	echo json_encode($result);
?>