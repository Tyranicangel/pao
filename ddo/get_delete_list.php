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
	$dfrom=$_POST['dfrom'];
	$dto=$_POST['dto'];
	$query=pg_query("SELECT * FROM ddo_submission WHERE tokenissuedate >= '$dfrom' AND tokenissuedate <='$dto' AND billstatus='0' AND ddocode='$user_id'");
	$result=pg_fetch_all($query);
	echo json_encode($result);
?>