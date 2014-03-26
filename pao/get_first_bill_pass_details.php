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
	$tno=$_POST['tkno'];
	$query=pg_query("SELECT * FROM npayments WHERE transid='$tno'");
	$result=pg_fetch_array($query,null,PGSQL_ASSOC);
	$ft=$result['formtype'];
	$fno=$result['formno'];
	$q1=pg_query("SELECT * FROM form_chk_list WHERE (formno='$fno' AND formid='$ft') OR (formno='$fno' AND formid='$fno')");
	$r1=pg_fetch_all($q1);
	$result['frules']=$r1;
	$ddoc=$result['ddocode'];
	$hoa=$result['hoa'];
	$q10=pg_fetch_array(pg_query("SELECT * FROM mddocumbudget WHERE hoa='$hoa' AND ddocode='$ddoc'"),null,PGSQL_ASSOC);
	if(!$q10)
	{
		$result['auth']=0;
		$result['exp']=0;
	}
	else
	{
		$result['auth']=$q10['authorised'];
		$result['exp']=$q10['expenditure'];
	}
	$q2=pg_fetch_array(pg_query("SELECT ddodesg FROM mddo WHERE ddocode='$ddoc'"),null,PGSQL_ASSOC);
	$result['ddodesg']=$q2['ddodesg'];
	$bcode=$result['bankcode'];
	$q3=pg_fetch_array(pg_query("SELECT * FROM (SELECT partyname,bankcode FROM pao_ddo_party WHERE bankacno='$bcode') AS a INNER JOIN (SELECT bankname,branch,ifsccode FROM ifsccodes_n) AS b ON a.bankcode=b.ifsccode"),null,PGSQL_ASSOC);
	$result['partydets']=$q3;
	$transid=$result['tbrno'];
	$tkno=$result['transid'];
	$q4=pg_fetch_array(pg_query("SELECT * FROM form_user_chk WHERE tokenno='$transid' AND userid='ddo'"),null,PGSQL_ASSOC);
	$result['form_ddo_chk']=$q4;
	$q4=pg_fetch_array(pg_query("SELECT * FROM form_user_chk WHERE tokenno='$tkno' AND userid='aud'"),null,PGSQL_ASSOC);
	$result['form_aud_chk']=$q4;
	$q4=pg_fetch_array(pg_query("SELECT * FROM form_user_chk WHERE tokenno='$tkno' AND userid='sup'"),null,PGSQL_ASSOC);
	$result['form_sup_chk']=$q4;
	$q9=pg_query("SELECT DISTINCT(hoa) FROM mddohoa WHERE ddocode='$ddoc'");
	$r9=pg_fetch_all($q9);
	$result['hoalist']=$r9;
	echo json_encode($result);
?>