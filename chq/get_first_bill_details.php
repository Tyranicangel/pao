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
	$tkno=$_POST['tkno'];
	$query1=pg_fetch_array(pg_query("SELECT * FROM chq_section WHERE counter='$counter' AND paymentstatus='0' AND transid='$tkno'"),null,PGSQL_ASSOC);
	$tsid=$query1['transid'];
	$query=pg_query("SELECT * FROM npayments WHERE transid='$tsid'");
	$result=pg_fetch_array($query,null,PGSQL_ASSOC);
	$ft=$result['formtype'];
	$fno=$result['formno'];
	$q1=pg_query("SELECT * FROM form_chk_list WHERE (formno='$fno' AND formid='$ft') OR (formno='$fno' AND formid='$fno')");
	$r1=pg_fetch_all($q1);
	$result['frules']=$r1;
	$ddoc=$result['ddocode'];
	$q2=pg_fetch_array(pg_query("SELECT ddodesg FROM mddo WHERE ddocode='$ddoc'"),null,PGSQL_ASSOC);
	$result['ddodesg']=$q2['ddodesg'];
	$bcode=$result['bankcode'];
	$q3=pg_fetch_array(pg_query("SELECT * FROM (SELECT partyname,bankcode FROM pao_ddo_party WHERE bankacno='$bcode') AS a INNER JOIN (SELECT bankname,branch,ifsccode FROM ifsccodes_n) AS b ON a.bankcode=b.ifsccode"),null,PGSQL_ASSOC);
	$result['partydets']=$q3;
	echo json_encode($result);
?>