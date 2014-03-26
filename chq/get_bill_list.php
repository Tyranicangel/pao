<?php
	include_once('../php_pages/connect.php');
	session_start();
	if(isset($_SESSION['pao_user']))
	{
		$user_id=$_SESSION['pao_user'];
		$query=pg_query("SELECT username,counter FROM users WHERE userid='$user_id'");
		if(pg_num_rows($query))
		{
			$result=pg_fetch_array($query,null,PGSQL_ASSOC);
			$uname=$result['username'];
			$counter=$result['counter'];
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
	$output=array();
	$query=pg_query("SELECT * FROM chq_section WHERE counter='$counter' AND paymentstatus='0'");
	while($result=pg_fetch_array($query,null,PGSQL_ASSOC))
	{
		$tid=bigintval($result['transid']);
		$q1=pg_fetch_array(pg_query("SELECT * FROM (SELECT * FROM npayments WHERE transid=$tid) AS a INNER JOIN (SELECT partyname,bankacno FROM pao_ddo_party) AS b ON a.bankcode=b.bankacno"),null,PGSQL_ASSOC);
		array_push($output,$q1);
	}
	echo json_encode($output);
?>