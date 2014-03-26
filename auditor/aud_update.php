
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
	$fdata=$_POST['formdata'];
	$username="aud";
	$rems=$_POST['rems'];
	$query=pg_query("UPDATE form_user_chk SET form_data='$fdata',remarks='$rems' WHERE tokenno='$tkno' AND userid='fin'");

?>