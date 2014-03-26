<?php
	include_once('../php_pages/connect.php');
	if(isset($_GET['tid']))
	{
		$tid=$_GET['tid'];
	}
	$q=pg_query("SELECT * FROM ddo_submission WHERE transid='$tid'");
	$r=pg_fetch_array($q,null,PGSQL_ASSOC);
	$bkno=$r['bankacno'];
	$q2=pg_fetch_array(pg_query("SELECT * FROM pao_ddo_party WHERE bankacno='$bkno'"),null,PGSQL_ASSOC);
	$bcode=$q2['bankcode'];
	$q3=pg_fetch_array(pg_query("SELECT * FROM ifsccodes_n WHERE ifsccode='$bcode'"),null,PGSQL_ASSOC);
	$hoa_name=$r['hoa'];
	$hoa=substr($hoa_name,0,4)."-".substr($hoa_name,4,2)."-".substr($hoa_name,6,3)."-".substr($hoa_name,9,2)."-".substr($hoa_name,11,2)."-".substr($hoa_name,13,3)."-".substr($hoa_name,16,3)."-".substr($hoa_name,19);
	$ddocode=$r['ddocode'];
	$ft=$r['transtype'];
	$q4=pg_fetch_array(pg_query("SELECT * FROM mddo WHERE ddocode='$ddocode'"),null,PGSQL_ASSOC);
	$q5=pg_fetch_array(pg_query("SELECT DISTINCT(category) FROM form_chk_list WHERE formid='$ft'"),null,PGSQL_ASSOC);
	$form_no =$r['formno'];
	$scr = pg_query("SELECT * FROM form_chk_list WHERE formid='$form_no' OR formid='$ft' ");
	$desc = array();
	$desc = pg_fetch_all($scr);
	$tt = pg_fetch_array(pg_query("SELECT * FROM form_user_chk WHERE tokenno = '$tid' and userid='ddo'"),null,PGSQL_ASSOC);
	$form_data = $tt['form_data'];
	$ddo_chk_ans = explode("|", $form_data);
	$main_chk_ans = array();
	for ($i=0; $i < count($ddo_chk_ans)- 1 ; $i++) 
	{ 
		$y = explode(":",$ddo_chk_ans[$i]);
		$main_chk_ans[$y[0]] = $y[1]; 
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
			text-align:left;
		}
	</style>
</head>
<body>
	<div class='form_wrap' id='print_wrap' style='float:left;'>
		<h3 class="add_agency_txt no_print" style="background:#474646;">Bill Print Preview</h3>
		<div class="agency_form">
			<h4 class="add_agency_txt" style="width:610px;background:#474646;">Bill Details</h4>
			<div class="form_full_div">
				<div class="form_name" style="width:200px;">
					Transaction Id:
				</div> 
				<div class="input_div">
					<?php echo $r['transid']; ?>
				</div>
			</div>
			<div class="form_full_div">
				<div class="form_name" style="width:200px;">
					Submission Date: 
				</div> 
				<div class="input_div">
					<?php echo substr($r['tokenissuedate'],8,2).'/'.substr($r['tokenissuedate'],5,2).'/'.substr($r['tokenissuedate'],0,4); ?>
				</div>
			</div>
			<div class="form_full_div">
				<div class="form_name" style="width:200px;">
					Token Number:
				</div> 
				<div class="input_div">
					
				</div>
			</div>
			<div class="form_full_div">
				<div class="form_name" style="width:200px;">
					Form No:
				</div> 
				<div class="input_div">
					<?php echo $r['formno']; ?>
				</div>
			</div>
			<div class="form_full_div">
				<div class="form_name" style="width:200px;">
					Form Type:
				</div> 
				<div class="input_div">
					<?php echo $q5['category']; ?>
				</div>
			</div>
			<div class="form_full_div">
				<div class="form_name" style="width:200px;">
					Head of Account:
				</div> 
				<div class="input_div">
					<?php echo $hoa; ?>
				</div>
			</div>
			<div class="form_full_div">
				<div class="form_name" style="width:200px;">
					DDO:
				</div> 
				<div class="input_div">
					<?php echo $q4['ddodesg'].'('.$ddocode.')'; ?>
				</div>
			</div>
			<h4 class="add_agency_txt" style="width:610px;background:#474646;">Amount Details</h4>
			<div class="form_full_div">
				<div class="form_name" style="width:200px;">
					Gross Amount:
				</div> 
				<div class="input_div">
					<?php echo $r['gross']; ?>
				</div>
			</div>
			<div class="form_full_div">
				<div class="form_name" style="width:200px;">
					PT Deductions:
				</div> 
				<div class="input_div">
					<?php echo $r['ptdedn']; ?>
				</div>
			</div>
			<div class="form_full_div">
				<div class="form_name" style="width:200px;">
					IT Deductions:
				</div> 
				<div class="input_div">
					<?php echo $r['itdedn']; ?>
				</div>
			</div>
			<div class="form_full_div">
				<div class="form_name" style="width:200px;">
					VAT Deductions:
				</div> 
				<div class="input_div">
					<?php echo $r['vatdedn']; ?>
				</div>
			</div>
			<div class="form_full_div">
				<div class="form_name" style="width:200px;">
					Agency Amount:
				</div> 
				<div class="input_div">
					<?php echo $r['net']; ?>
				</div>
			</div>
			<!--<div class="form_full_div">
				<div class="form_name" style="width:200px;">
					Running A/c Bill No:
				</div> 
				<div class="input_div">
					
				</div>
			</div>
			<div class="form_full_div">
				<div class="form_name" style="width:200px;">
					Division:
				</div> 
				<div class="input_div">
					Mr. Satyanarayana Rao
				</div>
			</div>-->
			<h4 class="add_agency_txt" style="width:610px;background:#474646;">Agency & Bank Details</h4>
			<div class="form_full_div">
				<div class="form_name" style="width:200px;">
					Agency Name:
				</div> 
				<div class="input_div" style="text-transform:uppercase;">
					<?php echo $q2['partyname']; ?>
				</div>
			</div>
			<div class="form_full_div">
				<div class="form_name" style="width:200px;">
					Bank Name:
				</div> 
				<div class="input_div">
					<?php echo $q3['bankname']; ?>
				</div>
			</div>
			<div class="form_full_div">
				<div class="form_name" style="width:200px;">
					Branch Name:
				</div> 
				<div class="input_div">
					<?php echo $q3['branch']; ?>
				</div>
			</div>
			<div class="form_full_div">
				<div class="form_name" style="width:200px;">
					Account Number:
				</div> 
				<div class="input_div">
					<?php echo $bkno;?>
				</div>
			</div>
			<div class="form_full_div">
				<div class="form_name" style="width:200px;">
					IFSC Code:
				</div> 
				<div class="input_div">
					<?php echo $q2['bankcode'];?>
				</div>
			</div>
			<h4 class="add_agency_txt" style="width:610px;background:#474646;margin-top:50px;margin-bottom:50px;">Scrutiny Details</h4>
			<div class="form_full_div">
				<table cellpadding="5" class="scrutiny_table abctab" border="1">
								<tr class="ddo_scrutiny_table_tr">
									<td class="td_scrutiny_table">
										SNo
									</td>
									<td class="td_scrutiny_table">
										Descritpion
									</td>
									<td class="td_scrutiny_table">
										Enclosed 
									</td>
								</tr> 
					<?php 
						$j = 1;
						for ($i=0; $i < count($desc); $i++) { 
							$samp = $desc[$i]['formref'];
							echo ('<tr>');
								echo ('<td>'.$j.'</td>');
								echo ('<td>'.$desc[$i]['formdesc'].'</td>');
								echo ('<td>'.get_form_chk($main_chk_ans[$samp]).'</td>');
							echo('</tr>');
							$j++;
						}
					 ?>
				</table>
			</div>
			<div class="form_full_div">
				<div class="ddo_sign" style="float:right;font-weight:bold;font-family:arial;font-size:12px;padding:60px; 20px;">
					(Signature of the DDO)<br><br>
					DDO Designation: <?php echo $q4['ddodesg']; ?>
				</div>
			</div>
			<div class="form_full_div" style="padding: 30px 240px;width: 200px;">
				<button type="button" class="save_agency no_print" id="print_bill">Print</button>
			</div>
		</div>
	<div>
</body>
</html>