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
	$tkno=$_POST['tkno'];
	$fdata=$_POST['formdata'];
	$username="fin";
	$rems=$_POST['rems'];
	$query=pg_query("UPDATE npayments SET billstatus=7 WHERE transid='$tkno'");
	$query=pg_query_params($dbc,"INSERT INTO form_user_chk (tokenno,userid,form_data,remarks) VALUES ($1,$2,$3,$4)",array($tkno,$username,$fdata,$rems));
	echo "Bill Authorized";
?>