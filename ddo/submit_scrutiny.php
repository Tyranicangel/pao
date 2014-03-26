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
	$tid=$_POST['tid'];
	$username="ddo";
	$fdata=$_POST['chklist'];
	$query=pg_query_params($dbc,"INSERT INTO form_user_chk (tokenno,userid,form_data) VALUES ($1,$2,$3)",array($tid,$username,$fdata));
?>