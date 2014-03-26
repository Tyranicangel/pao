<?php
	include_once('../php_pages/connect.php');
	session_start();
	if(isset($_SESSION['pao_user']))
	{
		$user_id=$_SESSION['pao_user'];
		$query=pg_query("SELECT username FROM users WHERE userid='$user_id'");
		if(pg_num_rows($query))
		{
			$result=pg_fetch_array($query,null,PGSQL_ASSOC);
			$uname=$result['username'];
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
	$oldpass=md5($_POST['oldpass']);
	$newpass=md5($_POST['newpass']);
	$query=pg_fetch_array(pg_query("SELECT ddopass FROM mddo WHERE ddocode='$user_id'"),null,PGSQL_ASSOC);
	if($oldpass==$query['password'])
	{
		$query1=pg_query("UPDATE mddo SET ddopass='$newpass' WHERE ddocode='$user_id'");
		echo 'success';
	}
	else
	{
		echo 'You have entered wrong password';
	}
?>