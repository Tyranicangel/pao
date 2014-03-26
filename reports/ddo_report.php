<?php
	include_once('../php_pages/connect.php');
	session_start();
	if(isset($_SESSION['pao_user']))
	{
		$user_id=$_SESSION['pao_user'];
		$query=pg_query("SELECT ddodesg FROM mddo WHERE ddocode='$user_id'");
		if(pg_num_rows($query))
		{
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
	$query=pg_fetch_array(pg_query("SELECT COUNT(*),SUM(gross) FROM ddo_submission WHERE ddocode='$user_id'"),null,PGSQL_ASSOC);
	$query2=pg_fetch_array(pg_query("SELECT COUNT(*),SUM(gross) FROM npayments WHERE ddocode='$user_id'"),null,PGSQL_ASSOC);
	$query4=pg_fetch_array(pg_query("SELECT COUNT(*),SUM(gross) FROM npayments WHERE ddocode='$user_id' AND billstatus='40'"),null,PGSQL_ASSOC);
	$query5=pg_fetch_array(pg_query("SELECT COUNT(*),SUM(gross) FROM npayments WHERE ddocode='$user_id' AND billstatus='1'"),null,PGSQL_ASSOC);
	$query6=pg_fetch_array(pg_query("SELECT COUNT(*),SUM(gross) FROM npayments WHERE ddocode='$user_id' AND billstatus='2'"),null,PGSQL_ASSOC);
	$query7=pg_fetch_array(pg_query("SELECT COUNT(*),SUM(gross) FROM npayments WHERE ddocode='$user_id' AND billstatus='3'"),null,PGSQL_ASSOC);
	$query8=pg_fetch_array(pg_query("SELECT COUNT(*),SUM(gross) FROM npayments WHERE ddocode='$user_id' AND billstatus='4'"),null,PGSQL_ASSOC);
	$query9=pg_fetch_array(pg_query("SELECT COUNT(*),SUM(gross) FROM npayments WHERE ddocode='$user_id' AND billstatus='5' OR billstatus='25'"),null,PGSQL_ASSOC);
	$query10=pg_fetch_array(pg_query("SELECT COUNT(*),SUM(gross) FROM npayments WHERE ddocode='$user_id' AND billstatus='6' OR billstatus='26'"),null,PGSQL_ASSOC);
	$query11=pg_fetch_array(pg_query("SELECT COUNT(*),SUM(gross) FROM npayments WHERE ddocode='$user_id' AND billstatus='7' OR billstatus='27'"),null,PGSQL_ASSOC);
	$query12=pg_fetch_array(pg_query("SELECT COUNT(*),SUM(gross) FROM npayments WHERE ddocode='$user_id' AND billstatus='10'"),null,PGSQL_ASSOC);
	$query13=pg_fetch_array(pg_query("SELECT COUNT(*),SUM(gross) FROM npayments WHERE ddocode='$user_id' AND billstatus='21'"),null,PGSQL_ASSOC);
	$query14=pg_fetch_array(pg_query("SELECT COUNT(*),SUM(gross) FROM npayments WHERE ddocode='$user_id' AND billstatus='22'"),null,PGSQL_ASSOC);
	$query15=pg_fetch_array(pg_query("SELECT COUNT(*),SUM(gross) FROM npayments WHERE ddocode='$user_id' AND billstatus='23'"),null,PGSQL_ASSOC);
	$query16=pg_fetch_array(pg_query("SELECT COUNT(*),SUM(gross) FROM npayments WHERE ddocode='$user_id' AND billstatus='24'"),null,PGSQL_ASSOC);
	$query20=pg_fetch_array(pg_query("SELECT COUNT(*),SUM(gross) FROM (SELECT * FROM npayments WHERE ddocode='$user_id' AND billstatus='10') AS a INNER JOIN (SELECT * FROM chq_section WHERE paymentstatus='1') AS b ON a.transid=b.transid"),null,PGSQL_ASSOC);
	//$q21=pg_fetch_all(pg_query("SELECT COUNT(*),SUM(gross),hoa FROM (SELECT * FROM npayments WHERE ddocode='$user_id' AND billstatus='10') AS a INNER JOIN (SELECT * FROM chq_section) AS b ON a.transid=b.transid GROUP BY hoa"));

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
	<title>DDO REPORT</title>
</head>
<body>
	<div class='form_wrap' id='print_wrap' style='float:left;'>
		<div class="agency_form">
			<div class="form_full_div">
				<table cellpadding="5" class="scrutiny_table abctab" border="1">
								<tr class="ddo_scrutiny_table_tr">
									<td colspan="2" class="td_scrutiny_table">
										Bills Filed
									</td>
									<td colspan="2" class="td_scrutiny_table">
										Token Generated
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
								</tr>
								<tr>
									<td class='td_scrutiny_no'>
										<?php 
											if($query['count']==0)
											{
												echo '0';
											}
											else
											{
												echo "<a href='ddo_bills/reports_bills_filed.php' target='_blank'>".$query['count']."</a>";
											}
										?>
									</td>
									<td class='td_scrutiny_amt'>
										<?php echo $query['sum']?>
									</td>
									<td class='td_scrutiny_no'>
										<?php 
											if($query2['count']==0)
											{
												echo '0';
											}
											else
											{
												echo "<a href='ddo_bills/reports_token_generated.php' target='_blank'>".$query2['count']."</a>";
											}
										?>
									</td>
									<td class='td_scrutiny_amt'>
										<?php echo $query2['sum']?>
									</td>
									<td class='td_scrutiny_no'>
										<?php 
											if($query4['count']==0)
											{
												echo '0';
											}
											else
											{
												echo "<a href='ddo_bills/reports_token_rejected.php' target='_blank'>".$query4['count']."</a>";
											}
										?>
									</td>
									<td class='td_scrutiny_amt'>
										<?php echo $query4['sum']?>
									</td>
								</tr>	
				</table>									
				<table cellpadding="5" class="scrutiny_table abctab" border="1">
								<tr class="ddo_scrutiny_table_tr">	
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
									<td class='td_scrutiny_no'>
										<?php 
											if($query5['count']==0)
											{
												echo '0';
											}
											else
											{
												echo "<a href='ddo_bills/reports_stage1_auditor.php' target='_blank'>".$query5['count']."</a>";
											}
										?>
									</td>
									<td class='td_scrutiny_amt'>
										<?php echo $query5['sum']?>
									</td>
									<td class='td_scrutiny_no'>
										<?php 
											if($query6['count']==0)
											{
												echo '0';
											}
											else
											{
												echo "<a href='ddo_bills/reports_stage1_supdt.php' target='_blank'>".$query6['count']."</a>";
											}
										?>
									</td>
									<td class='td_scrutiny_amt'>
										<?php echo $query6['sum']?>
									</td>
									<td class='td_scrutiny_no'>
										<?php 
											if($query7['count']==0)
											{
												echo '0';
											}
											else
											{
												echo "<a href='ddo_bills/reports_stage1_apao.php' target='_blank'>".$query7['count']."</a>";
											}
										?>
									</td>
									<td class='td_scrutiny_amt'>
										<?php echo $query7['sum']?>
									</td>
									<td class='td_scrutiny_no'>
										<?php 
											if($query8['count']==0)
											{
												echo '0';
											}
											else
											{
												echo "<a href='ddo_bills/reports_stage1_pao.php' target='_blank'>".$query8['count']."</a>";
											}
										?>
									</td>
									<td class='td_scrutiny_amt'>
										<?php echo $query8['sum']?>
									</td>
								</tr>	
				</table>
				<table cellpadding="5" class="scrutiny_table abctab" border="1">								
								<tr class="ddo_scrutiny_table_tr">	
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
									<td class='td_scrutiny_no'>
										<?php 
											if($query13['count']==0)
											{
												echo '0';
											}
											else
											{
												echo "<a href='ddo_bills/reports_stage2_auditor.php' target='_blank'>".$query13['count']."</a>";
											}
										?>
									</td>
									<td class='td_scrutiny_amt'>
										<?php echo $query13['sum']?>
									</td>
									<td class='td_scrutiny_no'>
										<?php 
											if($query14['count']==0)
											{
												echo '0';
											}
											else
											{
												echo "<a href='ddo_bills/reports_stage2_supdt.php' target='_blank'>".$query14['count']."</a>";
											}
										?>
									</td>
									<td class='td_scrutiny_amt'>
										<?php echo $query14['sum']?>
									</td>
									<td class='td_scrutiny_no'>
										<?php 
											if($query15['count']==0)
											{
												echo '0';
											}
											else
											{
												echo "<a href='ddo_bills/reports_stage2_apao.php' target='_blank'>".$query15['count']."</a>";
											}
										?>
									</td>
									<td class='td_scrutiny_amt'>
										<?php echo $query15['sum']?>
									</td>
									<td class='td_scrutiny_no'>
										<?php 
											if($query16['count']==0)
											{
												echo '0';
											}
											else
											{
												echo "<a href='ddo_billsreports_stage2_pao.php' target='_blank'>".$query16['count']."</a>";
											}
										?>
									</td>
									<td class='td_scrutiny_amt'>
										<?php echo $query16['sum']?>
									</td>
								</tr>	
				</table>
				<table cellpadding="5" class="scrutiny_table abctab" border="1">								
								<tr class="ddo_scrutiny_table_tr">	
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
								</tr>
								<tr>	
									<td class='td_scrutiny_no'>
										<?php 
											if($query9['count']==0)
											{
												echo '0';
											}
											else
											{
												echo "<a href='ddo_bills/reports_bills_govt.php' target='_blank'>".$query9['count']."</a>";
											}
										?>
									</td>
									<td class='td_scrutiny_amt'>
										<?php echo $query9['sum']?>
									</td>
									<td class='td_scrutiny_no'>
										<?php 
											if($query10['count']==0)
											{
												echo '0';
											}
											else
											{
												echo "<a href='ddo_bills/reports_bills_auth.php' target='_blank'>".$query10['count']."</a>";
											}
										?>
									</td>
									<td class='td_scrutiny_amt'>
										<?php echo $query10['sum']?>
									</td>
									<td class='td_scrutiny_no'>
										<?php 
											if($query11['count']==0)
											{
												echo '0';
											}
											else
											{
												echo "<a href='ddo_bills/reports_bills_approved.php' target='_blank'>".$query11['count']."</a>";
											}
										?>
									</td>
									<td class='td_scrutiny_amt'>
										<?php echo $query11['sum']?>
									</td>
									<td class='td_scrutiny_no'>
										<?php 
											if($query12['count']==0)
											{
												echo '0';
											}
											else
											{
												echo "<a href='ddo_bills/reports_bills_ready.php' target='_blank'>".$query12['count']."</a>";
											}
										?>
									</td>
									<td class='td_scrutiny_amt'>
										<?php echo $query12['sum']?>
									</td>
									<td class='td_scrutiny_no'>
										<?php 
											if($query20['count']==0)
											{
												echo '0';
											}
											else
											{
												echo "<a href='ddo_bills/reports_bills_paid.php' target='_blank'>".$query20['count']."</a>";
											}
										?>
									</td>
									<td class='td_scrutiny_amt'>
										<?php echo $query20['sum']?>
									</td>
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