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
	$q2=pg_query("UPDATE chq_section SET printflag='0' WHERE paymentstatus='1' AND voch_date='$c_date' AND printflag='2'");
	$query=pg_query("SELECT * FROM (SELECT * FROM chq_section WHERE printflag='0') AS a INNER JOIN (SELECT * FROM npayments) AS b ON a.transid=b.transid");
	$result=pg_fetch_all($query);
	echo json_encode($result);
?>