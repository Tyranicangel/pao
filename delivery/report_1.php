<?php
	include_once('../php_pages/connect.php');
	session_start();
	if(isset($_SESSION['pao_user']))
	{
		$user_id=$_SESSION['pao_user'];
		$query=pg_query("SELECT username,counter FROM users WHERE userid='$user_id'");
		if(pg_num_rows($query))
		{
			$result=pg_fetch_array($query,null,PGSQL_ASSOC);
			$uname=$result['username'];
			$counter=$result['counter'];
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
	if(isset($_GET['date']))
	{
		$date=$_GET['date'];
	}
	else
	{
		header("location:report1.php");
		exit;
	}
	$q1=pg_query("SELECT * FROM chq_section WHERE chqprepdate='$date'");
	$output=array();
	while($r1=pg_fetch_array($q1,null,PGSQL_ASSOC))
	{
		$tkno=$r1['transid'];
		$q2=pg_fetch_array(pg_query("SELECT transid,ddocode,hoa,bankcode,ddocode,gross FROM npayments WHERE transid='$tkno'"),null,PGSQL_ASSOC);
		$r2=$q2['bankcode'];
		$q3=pg_fetch_array(pg_query("SELECT * FROM (SELECT partyname,bankcode FROM pao_ddo_party WHERE bankacno='$r2') AS a INNER JOIN (SELECT bankname,ifsccode FROM ifsccodes_n) AS b ON a.bankcode=b.ifsccode"),null,PGSQL_ASSOC);
		$r3=$q2['ddocode'];
		$q4=pg_fetch_array(pg_query("SELECT ddodesg FROM mddo WHERE ddocode='$r3'"),null,PGSQL_ASSOC);
		array_push($output,array($q2,$q3,$q4));
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
	<title>CHQ SECTION REPORT</title>
</head>
<body>
	<div class='form_wrap' id='print_wrap' style='float:left;'>
		<div class="agency_form">
			<div class="form_full_div">
				<table cellpadding="5" class="scrutiny_table abctab" border="1">
					<tr class="ddo_scrutiny_table_tr">
						<td class="td_scrutiny_table">
							S No
						</td>
						<td class="td_scrutiny_table">
							Party Name
						</td>
						<td class="td_scrutiny_table">
							Account No
						</td>
						<td class="td_scrutiny_table">
							Bank Name
						</td>
						<td class="td_scrutiny_table">
							IFSC Code
						</td>
						<td class="td_scrutiny_table">
							Amount
						</td>
						<td class="td_scrutiny_table">
							DDO CODE
						</td>
					</tr>
					<?php
						$count=1;
						foreach($output as $k)
						{
							echo "<tr><td>$count</td><td>".$k[1]['partyname']."</td><td>".$k[0]['bankcode']."</td><td>".$k[1]['bankname']."</td><td>".$k[1]['bankcode']."</td><td>".$k[0]['gross']."</td><td>".$k[2]['ddodesg']."(".$k[0]['ddocode'].")</td></tr>";
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