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
	$bgross=intval($_POST['bgross']);
	$bptded=intval($_POST['bptded']);
	$bitded=intval($_POST['bitded']);
	$bvatded=intval($_POST['bvatded']);
	$bded=$bitded+$bvatded+$bptded;
	$bnet=$bgross-$bded;
	//$hoa=$_POST['hoaname'];
	$q1=pg_query("UPDATE npayments SET gross=$bgross,dedn=$bded,net=$bnet,ptdedn=$bptded,itdedn=$bitded,vatdedn=$bvatded WHERE transid='$tkno'");
	$q2=pg_fetch_array(pg_query("SELECT tbrno FROM npayments WHERE transid=$tkno"),null,PGSQL_ASSOC);
	$transid=$q2['tbrno'];
	$q3=pg_query("UPDATE ddo_submission SET gross=$bgross,dedn=$bded,net=$bnet,ptdedn=$bptded,itdedn=$bitded,vatdedn=$bvatded WHERE transid='$transid'");
?>