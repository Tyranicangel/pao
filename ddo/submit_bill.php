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

	$abankno=$_POST['abankno'];
	$dbillno=intval($_POST['dbillno']);
	$bformno=$_POST['bformno'];
	$ttype=$_POST['bformtype'];
	$bgross=intval($_POST['bgross']);
	$bptded=intval($_POST['bptded']);
	$bitded=intval($_POST['bitded']);
	$bvatded=intval($_POST['bvatded']);
	$bhoa=$_POST['bhoa'];
	$bded=$bitded+$bvatded+$bptded;
	$bnet=$bgross-$bded;
	$bstatus=0;
	$tdate=$c_date;
	if(intval(substr($c_date,5,2))>3)
	{
		$fyear=intval(substr($c_date,0,4));
	}
	else
	{
		$fyear=intval(substr($c_date,0,4))-1;
	}
	$q=pg_fetch_array(pg_query("SELECT MAX(transid) FROM ddo_submission WHERE fyear='$fyear'"),null,PGSQL_ASSOC);
	$r=$q['max'];
	if($r==null)
	{
		$tid=bigintval($fyear.'0000000001');
	}
	else
	{
		$tid=bigintval($r)+1;
	}
	$query=pg_query_params($dbc,"INSERT INTO ddo_submission (transid,transtype,formno,hoa,billid,ddocode,gross,dedn,net,billstatus,bankacno,tokenissuedate,ptdedn,itdedn,vatdedn,fyear) VALUES ($1,$2,$3,$4,$5,$6,$7,$8,$9,$10,$11,$12,$13,$14,$15,$16)",array($tid,$ttype,$bformno,$bhoa,$dbillno,$user_id,$bgross,$bded,$bnet,$bstatus,$abankno,$tdate,$bptded,$bitded,$bvatded,$fyear));
	$t=pg_fetch_array(pg_query("SELECT MAX(transid) FROM ddo_submission WHERE ddocode='$user_id'"),null,PGSQL_ASSOC);
	if($query)
	{
		echo $tid;
	}
	else
	{
		echo 'fail';
	}
?>