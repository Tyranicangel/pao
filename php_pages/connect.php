<?php
	$timezone="Asia/Calcutta";
	date_default_timezone_set($timezone);
	$host='localhost';
	$user='postgres';
	$pass='noobtard123';
	$db='postgres';
	$dbc=pg_connect("host=localhost dbname=postgres user=postgres password=noobtard123") or die('Could not connect:'.pg_last_error());
	$tresult=pg_fetch_array(pg_query("SELECT NOW()"),null,PGSQL_ASSOC);
	$c_date=substr($tresult['now'], 0, 10);
	$current_date=substr($c_date,8,2).'/'.substr($c_date,5,2).'/'.substr($c_date,0,4);
	$mdate=substr($c_date,8,2).'-'.substr($c_date,5,2).'-'.substr($c_date,0,4);
	if(intval(substr($c_date,5,2))>3)
	{
		$finyear=intval(substr($c_date,0,4));
	}
	else
	{
		$finyear=intval(substr($c_date,0,4))-1;
	}
	
	function bigintval($value) {
	  $value = trim($value);
	  if (ctype_digit($value)) {
		return $value;
	  }
	  $value = preg_replace("/[^0-9](.*)$/", '', $value);
	  if (ctype_digit($value)) {
		return $value;
	  }
	  return 0;
	}
	
	function get_form_chk($data){
		if($data=='y')
		{
			return "Y";
		}
		else if($data=='n')
		{
			return "N";
		}
		else if($data=='a')
		{
			return "N/A";
		}
	}
?>