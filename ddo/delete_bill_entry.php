<?php
	include_once('../php_pages/connect.php');
	session_start();
	if(isset($_SESSION['pao_user']))
	{
		$user_id=$_SESSION['pao_user'];
		$query=pg_query("SELECT ddodesg FROM mddo WHERE ddocode='$user_id'");
		if(pg_num_rows($query))
		{
		}
		else
		{
			header("location:../");
			exit;
		}
	}
	else
	{
		header("location:../");
		exit;
	}
	$del_arr=$_POST['dele'];
	foreach($del_arr AS $d)
	{
		$query=pg_query("DELETE FROM ddo_submission WHERE transid='$d'");
		$qq=pg_query("DELETE FROM form_user_chk WHERE tokenno='$d'");
	}
?>