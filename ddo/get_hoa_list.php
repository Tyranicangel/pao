<?php
	include_once('../php_pages/connect.php');
	session_start();
	$user_id=$_SESSION['pao_user'];
	session_write_close();
	$query=pg_query("SELECT DISTINCT(hoa) FROM mddohoa WHERE ddocode='$user_id' ORDER BY hoa");
	$result=pg_fetch_all($query);
	echo json_encode($result);
?>