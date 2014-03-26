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
	$q21=pg_fetch_all(pg_query("SELECT * FROM (SELECT * FROM npayments WHERE auduser='$user_id' AND billstatus='10') AS a INNER JOIN (SELECT * FROM chq_section) AS b ON a.transid=b.transid ORDER BY hoa"));
	$output=array();
	foreach ($q21 as $k) {
		if(array_key_exists($k['hoa'],$output))
		{
			if($k['billstatus']=='1')
			{
				$output[$k['hoa']]['s1audit']=array($output[$k['hoa']]['s1audit'][0]+1,$output[$k['hoa']]['s1audit'][1]+$k['gross']);
			}
			elseif($k['billstatus']=='2')
			{
				$output[$k['hoa']]['s1sup']=array($output[$k['hoa']]['s1sup'][0]+1,$output[$k['hoa']]['s1sup'][1]+$k['gross']);
			}
			elseif($k['billstatus']=='3')
			{
				$output[$k['hoa']]['s1apao']=array($output[$k['hoa']]['s1apao'][0]+1,$output[$k['hoa']]['s1apao'][1]+$k['gross']);
			}
			elseif($k['billstatus']=='4')
			{
				$output[$k['hoa']]['s1pao']=array($output[$k['hoa']]['s1pao'][0]+1,$output[$k['hoa']]['s1pao'][1]+$k['gross']);
			}
			elseif($k['billstatus']=='5' || $k['billstatus']=='25')
			{
				$output[$k['hoa']]['govt']=array($output[$k['hoa']]['govt'][0]+1,$output[$k['hoa']]['govt'][1]+$k['gross']);
			}
			elseif($k['billstatus']=='6' || $k['billstatus']=='26')
			{
				$output[$k['hoa']]['auth']=array($output[$k['hoa']]['auth'][0]+1,$output[$k['hoa']]['auth'][1]+$k['gross']);
			}
			elseif($k['billstatus']=='7' || $k['billstatus']=='27')
			{
				$output[$k['hoa']]['approve']=array($output[$k['hoa']]['approve'][0]+1,$output[$k['hoa']]['approve'][1]+$k['gross']);
			}
			elseif($k['billstatus']=='21')
			{
				$output[$k['hoa']]['s2audit']=array($output[$k['hoa']]['s2audit'][0]+1,$output[$k['hoa']]['s2audit'][1]+$k['gross']);
			}
			elseif($k['billstatus']=='22')
			{
				$output[$k['hoa']]['s2sup']=array($output[$k['hoa']]['s2sup'][0]+1,$output[$k['hoa']]['s2sup'][1]+$k['gross']);
			}
			elseif($k['billstatus']=='23')
			{
				$output[$k['hoa']]['s2apao']=array($output[$k['hoa']]['s2apao'][0]+1,$output[$k['hoa']]['s2apao'][1]+$k['gross']);
			}
			elseif($k['billstatus']=='24')
			{
				$output[$k['hoa']]['s2pao']=array($output[$k['hoa']]['s2pao'][0]+1,$output[$k['hoa']]['s2pao'][1]+$k['gross']);
			}
			elseif($k['paymentstatus']=='1')
			{
				$output[$k['hoa']]['paid']=array($output[$k['hoa']]['paid'][0]+1,$output[$k['hoa']]['paid'][1]+$k['gross']);
			}
			elseif($k['billstatus']=='40')
			{
				$output[$k['hoa']]['reject']=array($output[$k['hoa']]['reject'][0]+1,$output[$k['hoa']]['reject'][1]+$k['gross']);
			}
			if($k['billstatus']=='10')
			{
				$output[$k['hoa']]['ready']=array($output[$k['hoa']]['ready'][0]+1,$output[$k['hoa']]['ready'][1]+$k['gross']);
			}
		}
		else
		{
			$output[$k['hoa']]=array("reject"=>array(0,0),"s1audit"=>array(0,0),"s1sup"=>array(0,0),"s1apao"=>array(0,0),"s1pao"=>array(0,0),"s2audit"=>array(0,0),"s2sup"=>array(0,0),"s2apao"=>array(0,0),"s2pao"=>array(0,0),"govt"=>array(0,0),"auth"=>array(0,0),"approve"=>array(0,0),"ready"=>array(0,0),"paid"=>array(0,0));
			if($k['billstatus']=='1')
			{
				$output[$k['hoa']]['s1audit']=array($output[$k['hoa']]['s1audit'][0]+1,$output[$k['hoa']]['s1audit'][1]+$k['gross']);
			}
			elseif($k['billstatus']=='2')
			{
				$output[$k['hoa']]['s1sup']=array($output[$k['hoa']]['s1sup'][0]+1,$output[$k['hoa']]['s1sup'][1]+$k['gross']);
			}
			elseif($k['billstatus']=='3')
			{
				$output[$k['hoa']]['s1apao']=array($output[$k['hoa']]['s1apao'][0]+1,$output[$k['hoa']]['s1apao'][1]+$k['gross']);
			}
			elseif($k['billstatus']=='4')
			{
				$output[$k['hoa']]['s1pao']=array($output[$k['hoa']]['s1pao'][0]+1,$output[$k['hoa']]['s1pao'][1]+$k['gross']);
			}
			elseif($k['billstatus']=='5' || $k['billstatus']=='25')
			{
				$output[$k['hoa']]['govt']=array($output[$k['hoa']]['govt'][0]+1,$output[$k['hoa']]['govt'][1]+$k['gross']);
			}
			elseif($k['billstatus']=='6' || $k['billstatus']=='26')
			{
				$output[$k['hoa']]['auth']=array($output[$k['hoa']]['auth'][0]+1,$output[$k['hoa']]['auth'][1]+$k['gross']);
			}
			elseif($k['billstatus']=='7' || $k['billstatus']=='27')
			{
				$output[$k['hoa']]['approve']=array($output[$k['hoa']]['approve'][0]+1,$output[$k['hoa']]['approve'][1]+$k['gross']);
			}
			elseif($k['billstatus']=='21')
			{
				$output[$k['hoa']]['s2audit']=array($output[$k['hoa']]['s2audit'][0]+1,$output[$k['hoa']]['s2audit'][1]+$k['gross']);
			}
			elseif($k['billstatus']=='22')
			{
				$output[$k['hoa']]['s2sup']=array($output[$k['hoa']]['s2sup'][0]+1,$output[$k['hoa']]['s2sup'][1]+$k['gross']);
			}
			elseif($k['billstatus']=='23')
			{
				$output[$k['hoa']]['s2apao']=array($output[$k['hoa']]['s2apao'][0]+1,$output[$k['hoa']]['s2apao'][1]+$k['gross']);
			}
			elseif($k['billstatus']=='24')
			{
				$output[$k['hoa']]['s2pao']=array($output[$k['hoa']]['s2pao'][0]+1,$output[$k['hoa']]['s2pao'][1]+$k['gross']);
			}
			elseif($k['paymentstatus']=='1')
			{
				$output[$k['hoa']]['paid']=array($output[$k['hoa']]['paid'][0]+1,$output[$k['hoa']]['paid'][1]+$k['gross']);
			}
			elseif($k['billstatus']=='40')
			{
				$output[$k['hoa']]['reject']=array($output[$k['hoa']]['reject'][0]+1,$output[$k['hoa']]['reject'][1]+$k['gross']);
			}
			if($k['billstatus']=='10')
			{
				$output[$k['hoa']]['ready']=array($output[$k['hoa']]['ready'][0]+1,$output[$k['hoa']]['ready'][1]+$k['gross']);
			}
		}
	}
?>	
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="../styles/main_style.css"/>
	<script type="text/javascript" src='../scripts/jquery.js'></script>
	<script type="text/javascript">
	$(document).ready(function(){
		$('#print_bill').click(function(){
			window.print();
		});
		
	});
	</script>
	<style>
		.abctab td{
			padding:5px;
		}
		.td_scrutiny_table,.td_scrutiny_no{
			text-align:center;
		}
		.td_scrutiny_amt{
			text-align:right;
		}
	</style>
	<title>Auditor REPORT</title>
</head>
<body>
	<div class='form_wrap' id='print_wrap' style='float:left;'>
		<div class="agency_form">
			<div class="form_full_div">
				<table cellpadding="5" class="scrutiny_table abctab" border="1">
								<tr class="ddo_scrutiny_table_tr">
									<td rowspan="3" class="td_scrutiny_table">
										S.No
									</td>
									<td rowspan="3" class="td_scrutiny_table">
										Head of Account
									</td>
									<td colspan="8" class="td_scrutiny_table">
										Stage-1
									</td>
									<td colspan="8" class="td_scrutiny_table">
										Stage-2
									</td>
									<td colspan="2" rowspan="2" class="td_scrutiny_table">
										Bills With Govt.
									</td>
									<td colspan="2" rowspan="2" class="td_scrutiny_table">
										Bills Authorized
									</td>
									<td colspan="2" rowspan="2" class="td_scrutiny_table">
										Bills Approved
									</td>
									<td colspan="2" rowspan="2" class="td_scrutiny_table">
										Bills Ready
									</td>
									<td colspan="2" rowspan="2" class="td_scrutiny_table">
										Bills Paid
									</td>
									<td colspan="2" rowspan="2" class="td_scrutiny_table">
										Token Rejected
									</td>
								</tr>
								<tr class="ddo_scrutiny_table_tr">
									<td colspan="2" class="td_scrutiny_table">Auditor</td>
									<td colspan="2" class="td_scrutiny_table">Supdt</td>
									<td colspan="2" class="td_scrutiny_table">Apao</td>
									<td colspan="2" class="td_scrutiny_table">PAO</td>
									<td colspan="2" class="td_scrutiny_table">Auditor</td>
									<td colspan="2" class="td_scrutiny_table">Supdt</td>
									<td colspan="2" class="td_scrutiny_table">Apao</td>
									<td colspan="2" class="td_scrutiny_table">PAO</td>
								</tr>
								<tr class="ddo_scrutiny_table_tr">
									<td class="td_scrutiny_table">
										No
									</td>
									<td class="td_scrutiny_table">
										Amount
									</td>
									<td class="td_scrutiny_table">
										No
									</td>
									<td class="td_scrutiny_table">
										Amount
									</td>
									<td class="td_scrutiny_table">
										No
									</td>
									<td class="td_scrutiny_table">
										Amount
									</td>
									<td class="td_scrutiny_table">
										No
									</td>
									<td class="td_scrutiny_table">
										Amount
									</td>
									<td class="td_scrutiny_table">
										No
									</td>
									<td class="td_scrutiny_table">
										Amount
									</td>
									<td class="td_scrutiny_table">
										No
									</td>
									<td class="td_scrutiny_table">
										Amount
									</td>
									<td class="td_scrutiny_table">
										No
									</td>
									<td class="td_scrutiny_table">
										Amount
									</td>
									<td class="td_scrutiny_table">
										No
									</td>
									<td class="td_scrutiny_table">
										Amount
									</td>
									<td class="td_scrutiny_table">
										No
									</td>
									<td class="td_scrutiny_table">
										Amount
									</td>
									<td class="td_scrutiny_table">
										No
									</td>
									<td class="td_scrutiny_table">
										Amount
									</td>
									<td class="td_scrutiny_table">
										No
									</td>
									<td class="td_scrutiny_table">
										Amount
									</td>
									<td class="td_scrutiny_table">
										No
									</td>
									<td class="td_scrutiny_table">
										Amount
									</td>
									<td class="td_scrutiny_table">
										No
									</td>
									<td class="td_scrutiny_table">
										Amount
									</td>
									<td class="td_scrutiny_table">
										No
									</td>
									<td class="td_scrutiny_table">
										Amount
									</td>
								</tr>
								<?php
									$count=1;
									foreach($output as $key=>$value)
									{
										echo "<tr><td class='td_scrutiny_no'>".$count."</td><td class='td_scrutiny_no'>".$key."</td><td class='td_scrutiny_no'>".$value['s1audit'][0]."</td><td class='td_scrutiny_amt'>".$value['s1audit'][1]."</td><td class='td_scrutiny_no'>".$value['s1sup'][0]."</td><td class='td_scrutiny_amt'>".$value['s1sup'][1]."</td><td class='td_scrutiny_no'>".$value['s1apao'][0]."</td><td class='td_scrutiny_amt'>".$value['s1apao'][1]."</td></td><td class='td_scrutiny_no'>".$value['s1pao'][0]."</td><td class='td_scrutiny_amt'>".$value['s1pao'][1]."</td><td class='td_scrutiny_no'>".$value['s2audit'][0]."</td><td class='td_scrutiny_amt'>".$value['s2audit'][1]."</td><td class='td_scrutiny_no'>".$value['s2sup'][0]."</td><td class='td_scrutiny_amt'>".$value['s2sup'][1]."</td><td class='td_scrutiny_no'>".$value['s2apao'][0]."</td><td class='td_scrutiny_amt'>".$value['s2apao'][1]."</td></td><td class='td_scrutiny_no'>".$value['s2pao'][0]."</td><td class='td_scrutiny_amt'>".$value['s2pao'][1]."</td><td class='td_scrutiny_no'>".$value['govt'][0]."</td><td class='td_scrutiny_amt'>".$value['govt'][1]."</td><td class='td_scrutiny_no'>".$value['auth'][0]."</td><td class='td_scrutiny_amt'>".$value['auth'][1]."</td><td class='td_scrutiny_no'>".$value['approve'][0]."</td><td class='td_scrutiny_amt'>".$value['approve'][1]."</td><td class='td_scrutiny_no'>".$value['ready'][0]."</td><td class='td_scrutiny_amt'>".$value['ready'][1]."</td><td class='td_scrutiny_no'>".$value['paid'][0]."</td><td class='td_scrutiny_amt'>".$value['paid'][1]."</td><td class='td_scrutiny_no'>".$value['reject'][0]."</td><td class='td_scrutiny_amt'>".$value['reject'][1]."</td></tr>";
										$count++;
									}
								?>
				</table>
			</div>
			<div class="form_full_div" style="padding: 30px 240px;width: 200px;">
				<button type="button" class="save_agency no_print" id="print_bill">Print</button>
			</div>
		</div>
	<div>
</body>
</html>