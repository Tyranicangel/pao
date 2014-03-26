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
	$qq=pg_fetch_array(pg_query("SELECT hoa,ddocode FROM npayments WHERE transid='$tkno'"),null,PGSQL_ASSOC);
	$r1=$qq['hoa'];
	$mh=substr($r1,0,4);
	$q1=pg_fetch_array(pg_query("SELECT counter,branch FROM users WHERE userid='$user_id'"),null,PGSQL_ASSOC);
	$b=$q1['branch'];
	$q2=pg_fetch_array(pg_query("SELECT counter FROM pao_branch_mh_counter WHERE mh='$mh' AND branch='$b'"),null,PGSQL_ASSOC);
	$cno=$q2['counter'];
	$sto=2500;
	$status=0;
	$q3=pg_query_params($dbc,"INSERT INTO chq_section (stocode,branch,counter,transid,paymentstatus,finyear) VALUES ($1,$2,$3,$4,$5,$6)",array($sto,$b,$cno,$tkno,$status,$finyear));
	$query=pg_query("UPDATE npayments SET billstatus=10 WHERE transid='$tkno'");
	echo "Bill passed.Sent to counter ".$cno;
?>