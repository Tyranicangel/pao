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
	$fname="bank_neft_MAIN_".$c_date.".txt";
	$path=$fname;
	$fp=fopen($path, 'w');
	$write_text='';
	$cqno=$_POST['chq'];
	$query=pg_query("SELECT * FROM chq_section WHERE printflag='0'");
	$qqq=pg_query("UPDATE chq_section SET chequeno='$cqno',printflag='1',chqprepdate='$c_date' WHERE printflag='0'");
	$result=pg_fetch_all($query);
	for($i=0;$i<count($result);$i++)
	{
		$tkno=bigintval($result[$i]['transid']);
		$qq=pg_fetch_array(pg_query("SELECT * FROM npayments WHERE transid='$tkno'"),null,PGSQL_ASSOC);
		$bacno=strtoupper($qq['bankcode']);
		$benfacno=$bacno;
		$ddo=$qq['ddocode'];
		$q2=pg_fetch_array(pg_query("SELECT ddodesg FROM mddo WHERE ddocode='$ddo'"),null,PGSQL_ASSOC);
		$q1=pg_fetch_array(pg_query("SELECT * FROM (SELECT * FROM pao_ddo_party WHERE bankacno='$bacno') AS a INNER JOIN (SELECT * FROM ifsccodes_n) AS b ON a.bankcode=b.ifsccode"),null,PGSQL_ASSOC);
		$tranamt1=str_pad($qq['gross'],14,0,STR_PAD_LEFT);
		$commamt="0";
		$commamt1=str_pad($commamt,20,0,STR_PAD_LEFT);
		$benfname=strtoupper(substr(trim($q1['partyname']),0,30));
		$bankcode=strtoupper($q1['bankcode']);
		$msgtype="R41";
		$remm_acno="62215551205";
		$remm_acno1=str_pad($remm_acno,17,0,STR_PAD_LEFT);
		$remm_name="PAO GOVT OF AP Hyderabad salary";
		$remm_name1=str_pad($remm_name,35,' ',STR_PAD_RIGHT);//Remitters A/c
		$remm_addr="STATE BANK OF HYDERABAD SECRETARIAT";
		$remm_addr1=str_pad($remm_addr,35,' ',STR_PAD_RIGHT);//Remitters Address
		$benfacno1=str_pad($benfacno,25,' ',STR_PAD_RIGHT);//Beneficiary A/c
		$benfacno2=substr($benfacno1,0,16);//Beneficiary A/c2
		$space7="       ";
		$benfname1=str_pad($benfname,35,' ',STR_PAD_RIGHT);//Beneficiary Name
		$benf_addr=strtoupper(substr($q2['ddodesg'],0,34));//
		$benf_addr = preg_replace('/[\/_]/', '', $benf_addr);
		$benf_addr1=str_pad($benf_addr,34,' ',STR_PAD_RIGHT);//Beneficiary Address
		$ifsccode="ANDB0001103";//rECEIVER-BANK-IFSC-CODE
		$det_pay="110310027500128";
		$det_pay1=str_pad($det_pay,35,' ',STR_PAD_LEFT);//details of payment
		$send_recv_code="   URGENT";//value=ATTN /FAST/URGENT/DETAIL/NRE
		$send_recv_code1=str_pad($send_recv_code,11,' ',STR_PAD_RIGHT);//sender-to-receiver-code
		$send_recv_info=$det_pay;
		$send_recv_info1=str_pad($send_recv_info,25,' ',STR_PAD_RIGHT);//sender-to-receiver-info
		$user_refno=$det_pay;
		$user_refno1=str_pad($user_refno,14,' ',STR_PAD_RIGHT);//UESER-REF-NO
		$email="EMLdpao-sect@ap.nic.in";
		$email1=str_pad($email,35,' ',STR_PAD_RIGHT);//Email-Id
		$subbenfname=substr($benfname1,0,25);
		$bankcode1=str_pad($bankcode,12,' ',STR_PAD_LEFT);
		$write_text=$write_text."$msgtype$tranamt1$commamt1$remm_acno1$remm_name1$remm_addr1$benfacno1$space7$benfname1$benf_addr1$bankcode1$benfacno1$space7$send_recv_code1$subbenfname$benfacno2$email1\n";
	}
	fwrite($fp,$write_text);
	fclose($fp);
	echo $fname;
?>