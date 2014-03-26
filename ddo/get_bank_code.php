<?php
	include_once('../php_pages/connect.php');
	$bname=$_POST['bname'];
	$bstate=$_POST['bstate'];
	$bbranch=$_POST['bbranch'];
	$query=pg_query("SELECT ifsccode FROM ifsccodes_n WHERE bankname='$bname' AND state='$bstate' AND branch='$bbranch'");
	$result=pg_fetch_array($query,null,PGSQL_ASSOC);
	echo json_encode($result);
?>