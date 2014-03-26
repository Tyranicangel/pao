<?php
	include("connect.php");
	$tkno=$_POST['tkno'];
	$query=pg_fetch_array(pg_query("SELECT * FROM npayments WHERE transid='$tkno'"),null,PGSQL_ASSOC);
	if($query)
	{
		$ft=$query['formtype'];
		$fno=$query['formno'];
		$token_date = $query['tokenissuedate'];
		$bill_status = $query['billstatus'];
		$bank_no = $query['bankcode'];

		$query2 = pg_fetch_array(pg_query("SELECT * FROM pao_ddo_party WHERE bankacno = '$bank_no'"),null,PGSQL_ASSOC);
		$party_name = $query2['partyname'];

		$ddo_code = $query['ddocode'];
		$hoa = $query['hoa'];
		$gross = $query['gross'];
		$net = $query['net'];
		$pay_date = null;
		$remarks = 'none';

		switch ($bill_status) {
			case '1':
			$billpos = 'Bill with Auditor';

			break;

			case '2':
			$billpos = 'Bill with superintendent';

			break;
			
			case '3':
			$billpos = 'Bill with Officer';

			break;

			case '4':
			$billpos = 'Bill with PAO';

			break;

			case '5':
			$billpos = 'Bill with Government';

			break;

			case '6':
			$billpos = 'Bill with PAO (waiting for Approval)';

			break;

			case '7':
			$billpos = 'Bill with APAO(waiting for Approval)';

			break;

			case '10':
			
			$query3 = pg_fetch_array(pg_query("SELECT * from chq_section WHERE transid = '$tkno'")
				,null,PGSQL_ASSOC);
			$paystat = $query3['paymentstatus'];
			$pay_date = $query3['chqprepdate'];

			if($paystat=='1')
			{
				$billpos = 'Payment Done';
			}else
			{
				$billpos = 'Bill is Ready, Payment yet to be made';
			}

			break;

			case '21':
			$billpos = 'Bill with Auditor(second cycle)';

			break;

			case '22':
			$billpos = 'Bill with superintendent(second cycle)';

			break;
			
			case '23':
			$billpos = 'Bill with Officer(second cycle)';

			break;

			case '24':
			$billpos = 'Bill with PAO(second cycle)';

			break;

			

			default:
				
			break;
		}

		$main_data = array($tkno,$token_date,$party_name,$ddo_code,$hoa,$gross,$billpos,$pay_date);

		if($bill_status > 20)
		{
			$q1=pg_query("SELECT * FROM form_chk_list WHERE (formno='$fno' AND formid='$ft') OR 
				(formno='$fno' AND formid='$fno') OR (formno='C')");
			$r1=pg_fetch_all($q1);
			
			$query2=pg_query("SELECT * FROM form_user_chk WHERE tokenno ='$tkno' and userid = 'fin'");
			$result=pg_fetch_all($query2);

			$second_flag = "yes";
			$message="yes";
			$output=array($message,$main_data,$second_flag,$query,$result,$r1);
		}else
		{
			$second_flag = "no";
			$message="yes";
			$output=array($message,$main_data,$second_flag);
		}

		
	}
	else
	{
		$message="This token number is not available";
		$output=array($message);
	}
	echo json_encode($output);
?>