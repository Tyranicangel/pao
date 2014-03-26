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
	$tdate=$c_date;
	if(intval(substr($c_date,5,2))>3)
	{
		$fyear=intval(substr($c_date,0,4));
	}
	else
	{
		$fyear=intval(substr($c_date,0,4))-1;
	}
	$q=pg_fetch_array(pg_query("SELECT MAX(voucherno) FROM chq_section WHERE finyear='$fyear'"),null,PGSQL_ASSOC);
	$r=$q['max'];
	if($r==null)
	{
		$tid=bigintval($fyear.'0000000001');
	}
	else
	{
		$tid=bigintval($r)+1;
	}
	$qq=pg_query("UPDATE chq_section SET voucherno='$tid',paymentstatus=1,voch_date='$c_date' WHERE transid='$tkno'");
	echo $tid;
	
?>