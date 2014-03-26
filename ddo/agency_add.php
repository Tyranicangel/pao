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
	$acode=$_POST['acode'];
	$aname=$_POST['aname'];
	$apstat=intval($_POST['apanstat']);
	$apno=$_POST['apanno'];
	$asalestax=$_POST['asalestax'];
	$alaborno=$_POST['alaborno'];
	$abank=$_POST['abank'];
	$aifsc=$_POST['aifsc'];
	$aaccno=$_POST['aaccno'];
	$aaddress=$_POST['aaddress'];
	$acity=$_POST['acity'];
	$adistrict=$_POST['adistrict'];
	$apin=$_POST['apin'];
	$aphone=$_POST['aphone'];
	$acell=$_POST['acell'];
	$aemail=$_POST['aemail'];
	$q=pg_fetch_array(pg_query("SELECT COUNT(*) FROM pao_ddo_party WHERE bankacno = '$aaccno'"),null,PGSQL_ASSOC);
	if($q['count']==0)
	{
		$query=pg_query_params($dbc,"INSERT INTO pao_ddo_party (ddocode,partyname,bankcode,bankacno,agency_code,pan_tan_status,agency_pan_tan,salestax_no,laborreg_no,address,city,district,pincode,phone,cellno,email) VALUES ($1,$2,$3,$4,$5,$6,$7,$8,$9,$10,$11,$12,$13,$14,$15,$16)",array($user_id,$aname,$aifsc,$aaccno,$acode,$apstat,$apno,$asalestax,$alaborno,$aaddress,$acity,$adistrict,$apin,$aphone,$acell,$aemail));
		if($query)
		{
			echo 'success';
		}
		else
		{
			echo 'Error.Please try later';
		}
	}
	else
	{
		echo 'Agency already exists';
	}
?>