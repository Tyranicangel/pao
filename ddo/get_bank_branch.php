<?php
	include_once('../php_pages/connect.php');
	$bname=$_POST['bname'];
	$bstate=$_POST['bstate'];
	$query=pg_query("SELECT DISTINCT(branch) FROM ifsccodes_n WHERE bankname='$bname' AND state='$bstate' ORDER BY branch");
	$result=pg_fetch_all($query);
	echo json_encode($result);
?>