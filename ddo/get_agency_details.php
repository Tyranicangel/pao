<?php
	include_once('../php_pages/connect.php');
	$acno=$_POST['acno'];
	$query=pg_query("SELECT * FROM (SELECT * FROM pao_ddo_party WHERE bankacno='$acno') AS a INNER JOIN (SELECT * FROM ifsccodes_n) AS b ON a.bankcode=b.ifsccode");
	$result=pg_fetch_all($query);
	echo json_encode($result);
?>