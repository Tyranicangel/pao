<?php
	include_once('../php_pages/connect.php');
	session_start();
	$output=array();
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
	$query=pg_query("SELECT * FROM (SELECT * FROM ddo_submission WHERE transid='$tid') AS a INNER JOIN (SELECT * FROM pao_ddo_party) AS b ON a.bankacno=b.bankacno");
	$result=pg_fetch_all($query);
	$ftype=$result[0]['transtype'];
	$bcode=$result[0]['bankcode'];
	$dcode=$result[0]['ddocode'];
	$q5=pg_fetch_array(pg_query("SELECT DISTINCT(category) FROM form_chk_list WHERE formid='$ftype'"),null,PGSQL_ASSOC);
	$result[0]['ftype']=$q5['category'];
	$q3=pg_fetch_array(pg_query("SELECT * FROM ifsccodes_n WHERE ifsccode='$bcode'"),null,PGSQL_ASSOC);
	$result[0]['bname']=$q3['bankname'];
	$result[0]['bbranch']=$q3['branch'];
	$q7=pg_fetch_array(pg_query("SELECT ddodesg FROM mddo WHERE ddocode='$dcode'"),null,PGSQL_ASSOC);
	$result[0]['ddodesg']=$q7['ddodesg'];
	echo json_encode($result);
?>