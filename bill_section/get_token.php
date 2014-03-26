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
	$tid=$_POST['tid'];
	$query=pg_query("SELECT * FROM ddo_submission WHERE transid='$tid' AND billstatus='0'");
	$result=pg_fetch_all($query);
	$r=$result[0];
	$trasidslno="001";
	$transtype="20";
	$stocode="2500";
	$formno=$r['formno'];
	$hoa=$r['hoa'];
	$service="0000";
	$ddo=$r['ddocode'];
	$mmyy="042013";
	$gross=$r['gross'];
	$ptdedn=$r['ptdedn'];
	$itdedn=$r['itdedn'];
	$vatdedn=$r['vatdedn'];
	$dedn=$r['dedn'];
	$net=$r['net'];
	$tbr=$r['transid'];
	if(intval(substr($c_date,5,2))>3)
	{
		$fyear=intval(substr($c_date,0,4));
	}
	else
	{
		$fyear=intval(substr($c_date,0,4))-1;
	}
	$tdate=$c_date;
	$billstatus='1';
	$bcode=$r['bankacno'];
	$ftype=$r['transtype'];
	$query2=pg_fetch_array(pg_query("SELECT audituser FROM pao_ddo_user WHERE ddocode='$ddo'"),null,PGSQL_ASSOC);
	$aud=$query2['audituser'];
	$q33=pg_fetch_array(pg_query("SELECT * FROM users WHERE userid='$aud'"),null,PGSQL_ASSOC);
	$aud_user=$q33['username'];
	$sec=substr($aud,1,2);
	$q1=pg_fetch_array(pg_query("SELECT MAX(transid) FROM npayments WHERE fyear='$fyear'"),null,PGSQL_ASSOC);
	$fy=$fyear.(intval(substr($fyear,2,2))+1);
	if($q1['max']==null)
	{
		$transid=bigintval($fy.'00000001');
	}
	else
	{
		$transid=bigintval($q1['max'])+1;
	}
	$q=pg_query_params($dbc,"INSERT INTO npayments (transid,transtype,stocode,formno,hoa,servicemajor,ddocode,gross,dedn,net,tbrno,tokenissuedate,billstatus,bankcode,auduser,ptdedn,itdedn,vatdedn,formtype,fyear,inuser) VALUES ($1,$2,$3,$4,$5,$6,$7,$8,$9,$10,$11,$12,$13,$14,$15,$16,$17,$18,$19,$20,$21)",array($transid,$transtype,$stocode,$formno,$hoa,$service,$ddo,$gross,$dedn,$net,$tbr,$tdate,$billstatus,$bcode,$aud,$ptdedn,$itdedn,$vatdedn,$ftype,$fyear,$uname));
	$qp=pg_query("UPDATE ddo_submission SET billstatus='1' WHERE transid='$tbr'");
	echo json_encode(array($transid,$aud_user,$sec));
?>
