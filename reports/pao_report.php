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
	$q21=pg_fetch_all(pg_query("SELECT * FROM (SELECT * FROM npayments) AS a INNER JOIN (SELECT * FROM chq_section) AS b ON a.transid=b.transid ORDER BY passuser"));
	
	$output=array();
	foreach ($q21 as $k) {
		if(array_key_exists($k['passuser'],$output))
		{
			if($k['billstatus']=='1')
			{
				$output[$k['passuser']]['s1audit']=array($output[$k['passuser']]['s1audit'][0]+1,$output[$k['passuser']]['s1audit'][1]+$k['gross']);
			}
			elseif($k['billstatus']=='2')
			{
				$output[$k['passuser']]['s1sup']=array($output[$k['passuser']]['s1sup'][0]+1,$output[$k['passuser']]['s1sup'][1]+$k['gross']);
			}
			elseif($k['billstatus']=='3')
			{
				$output[$k['passuser']]['s1apao']=array($output[$k['passuser']]['s1apao'][0]+1,$output[$k['passuser']]['s1apao'][1]+$k['gross']);
			}
			elseif($k['billstatus']=='4')
			{
				$output[$k['passuser']]['s1pao']=array($output[$k['passuser']]['s1pao'][0]+1,$output[$k['passuser']]['s1pao'][1]+$k['gross']);
			}
			elseif($k['billstatus']=='5' || $k['billstatus']=='25')
			{
				$output[$k['passuser']]['govt']=array($output[$k['passuser']]['govt'][0]+1,$output[$k['passuser']]['govt'][1]+$k['gross']);
			}
			elseif($k['billstatus']=='6' || $k['billstatus']=='26')
			{
				$output[$k['passuser']]['auth']=array($output[$k['passuser']]['auth'][0]+1,$output[$k['passuser']]['auth'][1]+$k['gross']);
			}
			elseif($k['billstatus']=='7' || $k['billstatus']=='27')
			{
				$output[$k['passuser']]['approve']=array($output[$k['passuser']]['approve'][0]+1,$output[$k['passuser']]['approve'][1]+$k['gross']);
			}
			elseif($k['billstatus']=='21')
			{
				$output[$k['passuser']]['s2audit']=array($output[$k['passuser']]['s2audit'][0]+1,$output[$k['passuser']]['s2audit'][1]+$k['gross']);
			}
			elseif($k['billstatus']=='22')
			{
				$output[$k['passuser']]['s2sup']=array($output[$k['passuser']]['s2sup'][0]+1,$output[$k['passuser']]['s2sup'][1]+$k['gross']);
			}
			elseif($k['billstatus']=='23')
			{
				$output[$k['passuser']]['s2apao']=array($output[$k['passuser']]['s2apao'][0]+1,$output[$k['passuser']]['s2apao'][1]+$k['gross']);
			}
			elseif($k['billstatus']=='24')
			{
				$output[$k['passuser']]['s2pao']=array($output[$k['passuser']]['s2pao'][0]+1,$output[$k['passuser']]['s2pao'][1]+$k['gross']);
			}
			elseif($k['paymentstatus']=='1')
			{
				$output[$k['passuser']]['paid']=array($output[$k['passuser']]['paid'][0]+1,$output[$k['passuser']]['paid'][1]+$k['gross']);
			}
			elseif($k['billstatus']=='40')
			{
				$output[$k['passuser']]['reject']=array($output[$k['passuser']]['reject'][0]+1,$output[$k['passuser']]['reject'][1]+$k['gross']);
			}
			if($k['billstatus']=='10')
			{
				$output[$k['passuser']]['ready']=array($output[$k['passuser']]['ready'][0]+1,$output[$k['passuser']]['ready'][1]+$k['gross']);
			}
		}
		else
		{
			$output[$k['passuser']]=array("reject"=>array(0,0),"s1audit"=>array(0,0),"s1sup"=>array(0,0),"s1apao"=>array(0,0),"s1pao"=>array(0,0),"s2audit"=>array(0,0),"s2sup"=>array(0,0),"s2apao"=>array(0,0),"s2pao"=>array(0,0),"govt"=>array(0,0),"auth"=>array(0,0),"approve"=>array(0,0),"ready"=>array(0,0),"paid"=>array(0,0));
			if($k['billstatus']=='1')
			{
				$output[$k['passuser']]['s1audit']=array($output[$k['passuser']]['s1audit'][0]+1,$output[$k['passuser']]['s1audit'][1]+$k['gross']);
			}
			elseif($k['billstatus']=='2')
			{
				$output[$k['passuser']]['s1sup']=array($output[$k['passuser']]['s1sup'][0]+1,$output[$k['passuser']]['s1sup'][1]+$k['gross']);
			}
			elseif($k['billstatus']=='3')
			{
				$output[$k['passuser']]['s1apao']=array($output[$k['passuser']]['s1apao'][0]+1,$output[$k['passuser']]['s1apao'][1]+$k['gross']);
			}
			elseif($k['billstatus']=='4')
			{
				$output[$k['passuser']]['s1pao']=array($output[$k['passuser']]['s1pao'][0]+1,$output[$k['passuser']]['s1pao'][1]+$k['gross']);
			}
			elseif($k['billstatus']=='5' || $k['billstatus']=='25')
			{
				$output[$k['passuser']]['govt']=array($output[$k['passuser']]['govt'][0]+1,$output[$k['passuser']]['govt'][1]+$k['gross']);
			}
			elseif($k['billstatus']=='6' || $k['billstatus']=='26')
			{
				$output[$k['passuser']]['auth']=array($output[$k['passuser']]['auth'][0]+1,$output[$k['passuser']]['auth'][1]+$k['gross']);
			}
			elseif($k['billstatus']=='7' || $k['billstatus']=='27')
			{
				$output[$k['passuser']]['approve']=array($output[$k['passuser']]['approve'][0]+1,$output[$k['passuser']]['approve'][1]+$k['gross']);
			}
			elseif($k['billstatus']=='21')
			{
				$output[$k['passuser']]['s2audit']=array($output[$k['passuser']]['s2audit'][0]+1,$output[$k['passuser']]['s2audit'][1]+$k['gross']);
			}
			elseif($k['billstatus']=='22')
			{
				$output[$k['passuser']]['s2sup']=array($output[$k['passuser']]['s2sup'][0]+1,$output[$k['passuser']]['s2sup'][1]+$k['gross']);
			}
			elseif($k['billstatus']=='23')
			{
				$output[$k['passuser']]['s2apao']=array($output[$k['passuser']]['s2apao'][0]+1,$output[$k['passuser']]['s2apao'][1]+$k['gross']);
			}
			elseif($k['billstatus']=='24')
			{
				$output[$k['passuser']]['s2pao']=array($output[$k['passuser']]['s2pao'][0]+1,$output[$k['passuser']]['s2pao'][1]+$k['gross']);
			}
			elseif($k['paymentstatus']=='1')
			{
				$output[$k['passuser']]['paid']=array($output[$k['passuser']]['paid'][0]+1,$output[$k['passuser']]['paid'][1]+$k['gross']);
			}
			elseif($k['billstatus']=='40')
			{
				$output[$k['passuser']]['reject']=array($output[$k['passuser']]['reject'][0]+1,$output[$k['passuser']]['reject'][1]+$k['gross']);
			}
			if($k['billstatus']=='10')
			{
				$output[$k['passuser']]['ready']=array($output[$k['passuser']]['ready'][0]+1,$output[$k['passuser']]['ready'][1]+$k['gross']);
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
							Section
						</td>
						<td colspan="8" class="td_scrutiny_table">
							Stage-1
						</td>
					</tr>
					<tr class="ddo_scrutiny_table_tr">
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
					</tr>
					<tr>
						<?php
							$count=1;
							foreach($output as $key=>$value)
							{
								$query2=pg_fetch_array(pg_query("SELECT section FROM section_map WHERE suptid='$key'"),NULL,PGSQL_ASSOC);	
								echo "<tr><td class='td_scrutiny_no'>".$count."</td><td class='td_scrutiny_no'>".$query2['section']."</td><td class='td_scrutiny_no'>";
								if($value['s1audit'][0]==0)
								{
									echo '0';
								}else
								{
									echo "<a href='pao_bills/pao_s1audit.php?supt=".$key."' target='_blank'>".$value['s1audit'][0]."</a>";
								}
								echo "</td><td class='td_scrutiny_amt'>".$value['s1audit'][1]."</td><td class='td_scrutiny_no'>";
								if($value['s1sup'][0]==0)
								{
									echo '0';
								}else
								{
									echo "<a href='pao_bills/pao_s1supdt.php?supt=".$key."' target='_blank'>".$value['s1sup'][0]."</a>";
								}
								echo "</td><td class='td_scrutiny_amt'>".$value['s1sup'][1]."</td><td class='td_scrutiny_no'>";
								if($value['s1apao'][0]==0)
								{
									echo '0';
								}else
								{
									echo "<a href='pao_bills/pao_s1apao.php?supt=".$key."' target='_blank'>".$value['s1apao'][0]."</a>";
								}
								echo "</td><td class='td_scrutiny_amt'>".$value['s1apao'][1]."</td></td><td class='td_scrutiny_no'>";
								if($value['s1pao'][0]==0)
								{
									echo '0';
								}else
								{
									echo "<a href='pao_bills/pao_s1pao.php?supt=".$key."' target='_blank'>".$value['s1pao'][0]."</a>";
								}
								echo "</td><td class='td_scrutiny_amt'>".$value['s1pao'][1]."</td>";
								$count++;
							}
						?>
					</tr>
				</table>
				<table cellpadding="5" class="scrutiny_table abctab" border="1">
					<tr class="ddo_scrutiny_table_tr">
						<td rowspan="3" class="td_scrutiny_table">
							S.No
						</td>
						<td rowspan="3" class="td_scrutiny_table">
							Section
						</td>
						<td colspan="8" class="td_scrutiny_table">
							Stage-2
						</td>
					</tr>
					<tr class="ddo_scrutiny_table_tr">
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
					</tr>
					<tr>
						<?php
							$count=1;
							foreach($output as $key=>$value)
							{
								$query2=pg_fetch_array(pg_query("SELECT section FROM section_map WHERE suptid='$key'"),NULL,PGSQL_ASSOC);	
								echo "<tr><td class='td_scrutiny_no'>".$count."</td><td class='td_scrutiny_no'>".$query2['section']."</td><td class='td_scrutiny_no'>";
								if($value['s2audit'][0]==0)
								{
									echo '0';
								}else
								{
									echo "<a href='pao_bills/pao_s2audit.php?supt=".$key."' target='_blank'>".$value['s2audit'][0]."</a>";
								}
								echo "</td><td class='td_scrutiny_amt'>".$value['s2audit'][1]."</td><td class='td_scrutiny_no'>";
								if($value['s2sup'][0]==0)
								{
									echo '0';
								}else
								{
									echo "<a href='pao_bills/pao_s2supdt.php?supt=".$key."' target='_blank'>".$value['s2sup'][0]."</a>";
								}
								echo "</td><td class='td_scrutiny_amt'>".$value['s2sup'][1]."</td><td class='td_scrutiny_no'>";
								if($value['s2apao'][0]==0)
								{
									echo '0';
								}else
								{
									echo "<a href='pao_bills/pao_s2apao.php?supt=".$key."' target='_blank'>".$value['s2apao'][0]."</a>";
								}
								echo "</td><td class='td_scrutiny_amt'>".$value['s2apao'][1]."</td></td><td class='td_scrutiny_no'>";
								if($value['s2pao'][0]==0)
								{
									echo '0';
								}else
								{
									echo "<a href='pao_bills/pao_s2pao.php?supt=".$key."' target='_blank'>".$value['s2pao'][0]."</a>";
								}
								echo "</td><td class='td_scrutiny_amt'>".$value['s2pao'][1]."</td>";
								$count++;
							}
						?>
					</tr>
				</table>
				<table cellpadding="5" class="scrutiny_table abctab" border="1">
					<tr class="ddo_scrutiny_table_tr">
						<td rowspan="3" class="td_scrutiny_table">
							S.No
						</td>
						<td rowspan="3" class="td_scrutiny_table">
							Section
						</td>
						<td colspan="2" class="td_scrutiny_table">
							Bills With Govt.
						</td>
						<td colspan="2" class="td_scrutiny_table">
							Bills Authorized
						</td>
						<td colspan="2" class="td_scrutiny_table">
							Bills Approved
						</td>
						<td colspan="2" class="td_scrutiny_table">
							Bills Ready
						</td>
						<td colspan="2" class="td_scrutiny_table">
							Bills Paid
						</td>
						<td colspan="2" class="td_scrutiny_table">
							Token Rejected
						</td>
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
					</tr>
					<tr>
						<?php
							$count=1;
							foreach($output as $key=>$value)
							{
								$query2=pg_fetch_array(pg_query("SELECT section FROM section_map WHERE suptid='$key'"),NULL,PGSQL_ASSOC);	
								echo "<tr><td class='td_scrutiny_no'>".$count."</td><td class='td_scrutiny_no'>".$query2['section']."</td><td class='td_scrutiny_no'>";
								if($value['govt'][0]==0)
								{
									echo '0';
								}else
								{
									echo "<a href='pao_bills/pao_bills_govt.php?supt=".$key."' target='_blank'>".$value['govt'][0]."</a>";
								}
								echo "</td><td class='td_scrutiny_amt'>".$value['govt'][1]."</td><td class='td_scrutiny_no'>";
								if($value['auth'][0]==0)
								{
									echo '0';
								}else
								{
									echo "<a href='pao_bills/pao_bills_auth.php?supt=".$key."' target='_blank'>".$value['auth'][0]."</a>";
								}
								echo "</td><td class='td_scrutiny_amt'>".$value['auth'][1]."</td><td class='td_scrutiny_no'>";
								if($value['approve'][0]==0)
								{
									echo '0';
								}else
								{
									echo "<a href='pao_bills/pao_bills_approved.php?supt=".$key."' target='_blank'>".$value['approve'][0]."</a>";
								}
								echo "</td><td class='td_scrutiny_amt'>".$value['approve'][1]."</td><td class='td_scrutiny_no'>";
								if($value['ready'][0]==0)
								{
									echo '0';
								}else
								{
									echo "<a href='pao_bills/pao_bills_ready.php?supt=".$key."' target='_blank'>".$value['ready'][0]."</a>";
								}
								echo "</td><td class='td_scrutiny_amt'>".$value['ready'][1]."</td><td class='td_scrutiny_no'>";
								if($value['paid'][0]==0)
								{
									echo '0';
								}else
								{
									echo "<a href='pao_bills/pao_bills_paid.php?supt=".$key."' target='_blank'>".$value['paid'][0]."</a>";
								}
								echo "</td><td class='td_scrutiny_amt'>".$value['paid'][1]."</td><td class='td_scrutiny_no'>";
								if($value['reject'][0]==0)
								{
									echo '0';
								}else
								{
									echo "<a href='pao_bills/pao_token_rejected.php?supt=".$key."' target='_blank'>".$value['reject'][0]."</a>";
								}
								echo "</td><td class='td_scrutiny_amt'>".$value['reject'][1]."</td></tr>";
								$count++;
							}
						?>
					</tr>
				</table>
			</div>
			<div class="form_full_div" style="padding: 30px 240px;width: 200px;">
				<button type="button" class="save_agency no_print" id="print_bill">Print</button>
			</div>
		</div>
	<div>
</body>
</html>