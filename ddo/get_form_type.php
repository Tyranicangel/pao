<?php
	include_once('../php_pages/connect.php');
	$formno=$_POST['formno'];
	$query=pg_query("SELECT DISTINCT(formid),category FROM form_chk_list WHERE formno='$formno' AND formid!='$formno'");
	$result=pg_fetch_all($query);
	echo json_encode($result);
?>