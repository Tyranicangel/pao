<?php
	include_once('../../php_pages/connect.php');
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
			header("location:../../");
			exit;
		}
	}
	else
	{
		header("location:../../");
		exit;
	}
	if(isset($_GET['auduser']))
	{
		$auduser=$_GET['auduser'];
	}
	else
	{
		header("location:../../");
		exit;	
	}
	$query=pg_fetch_all(pg_query("SELECT * FROM (SELECT * FROM (SELECT transid,tokenissuedate,hoa,gross,bankcode FROM npayments WHERE passuser='$user_id' AND auduser='$auduser') AS a INNER JOIN (SELECT transid,chqprepdate FROM chq_section WHERE paymentstatus='1') AS b ON a.transid = b.transid) as c INNER JOIN (SELECT partyname,bankacno FROM pao_ddo_party) AS d on c.bankcode = d.bankacno"));
	$query2=pg_fetch_array(pg_query("SELECT username FROM users WHERE userid='$auduser'"),NULL,PGSQL_ASSOC);
?>
<!doctype html>
	<html lang="en">
	<head>
		<meta charset="UTF-8">
		<link rel="stylesheet" type="text/css" href="../../styles/main_style.css"/>
		<script type="text/javascript" src='../../scripts/jquery.js'></script>
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
		<title>BILLS PAID</title>
	</head>
	<body>
		<div class='form_wrap' id='print_wrap' style='float:left;'>
		<div class="agency_form">
			<div class="form_full_div">
				<div><?php echo 'Auditor : '.$query2['username'] ?></div>
				<table cellpadding="5" class="scrutiny_table abctab" border="1">
								<tr class="ddo_scrutiny_table_tr">
									<td class="td_scrutiny_table">
										Serial Number
									</td>
									<td class="td_scrutiny_table">
										Token Number
									</td>
									<td class="td_scrutiny_table">
										Token Date
									</td>
									<td class="td_scrutiny_table">
										HOA
									</td>
									<td class="td_scrutiny_table">
										Agency Name
									</td>
									<td class="td_scrutiny_table">
										Bank Account
									</td>
									<td class="td_scrutiny_table">
										Amount
									</td>
								</tr>
								<tr>
									<?php
										$count=1;
										if($query)
										{
											foreach($query as $key)
											{
												echo "<tr><td class='td_scrutiny_no'>".$count."</td><td class='td_scrutiny_no'>".$key['transid']."</td><td class='td_scrutiny_no'>".$key['tokenissuedate']."</td><td class='td_scrutiny_no'>".$key['hoa']."</td><td class='td_scrutiny_no'>".$key['partyname']."</td><td class='td_scrutiny_no'>".$key['bankcode']."</td><td class='td_scrutiny_no'>".$key['gross']."</td></tr>";
												$count++;
											}
										}
										else
										{
											echo 'There are no bills under this Auditor';
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