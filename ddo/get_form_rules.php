<?php
	include_once('../php_pages/connect.php');
	$formno=$_POST['formno'];
	$formid=$_POST['formid'];
	$query=pg_query("SELECT * FROM form_chk_list WHERE formid='$formno' OR formid='$formid' OR formid='C'");
	$result=pg_fetch_all($query);
	echo json_encode($result);
?>