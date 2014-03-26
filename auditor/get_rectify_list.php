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
	$output=array();
	$query=pg_query("SELECT * FROM npayments WHERE auduser='$user_id' AND billstatus='21' AND fyear='$finyear' ORDER BY transid");
	while($result=pg_fetch_array($query,null,PGSQL_ASSOC))
	{
		$bcode=$result['bankcode'];
		$qq=pg_fetch_array(pg_query("SELECT partyname,bankacno FROM pao_ddo_party WHERE bankacno='$bcode'"),null,PGSQL_ASSOC);
		$ddoc=$result['ddocode'];
		$q=pg_fetch_array(pg_query("SELECT ddodesg FROM mddo WHERE ddocode='$ddoc'"),null,PGSQL_ASSOC);
		$result['ddodesg']=$q['ddodesg'];
		$result['partyname']=$qq['partyname'];
		array_push($output,$result);
	}
	echo json_encode($output);
?>