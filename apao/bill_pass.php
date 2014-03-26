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
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Bill Pass : Officer</title>
	<link rel="stylesheet" type="text/css" href="../styles/main_style.css"/>
	<link rel="stylesheet" type="text/css" href="../styles/auditor_css.css"/>
	<script type="text/javascript" src='../scripts/jquery.js'></script>
	<script type="text/javascript" src="../scripts/script_common.js"></script>
	<script type="text/javascript" src='../scripts/script_officer_pass.js'></script>
	<style>
	.scrutiny_table td{
		padding:5px;
		text-align:left;
	}
	.main_content_tr_scr{
		cursor:pointer;
	}
	.main_content_tr_scr:hover{
		background:#474646;
		color:#ffffff;
	}
	</style>
</head>
<body>
	<div class="main_div">
		<div class="main_div_sub">
			<div class="header">
				<div class="header_logo">
					<img src="../images/govt_logo.gif" class="logo">
				</div>
				<div class="header_heading">
					<h1>Pay and Accounts Office(PAO)</h1>
					<div class="hyd_txt">HYDERABAD</div>
				</div>
				<a href='../php_pages/logout.php'><div class="header_logout">
					Logout
				</div></a>
				<div class="warning_div">
					<span class="asterix">*</span>This is a portal to be used only by the authorized personnel of 
					the PAO office, any intruders would have serious consequences
				</div>
			</div>
			<div class="date_time_tab">
				<div class="welcome_tct">
					Welcome: <span id="user_name"><?php echo $uname; ?></span>
				</div>
				<div class="current_date_time">
					<div id="current_date">
						<?php echo $current_date; ?>
					</div>
				</div>
			</div>
			<div class="content_div">
				<div class="menu_div">
					<ul class="menu_ul">
						<a href="index.php">
							<li class="menu_li">
								<span>Home</span>
							</li>
						</a>
						<li class="menu_li">
							<span>Transactions</span>
							<div class="menu_extn">
								<ul class="menu_extn_ul">
									<a href="bill_scrutiny.php"><li>Bills to be Scrutinized</li></a>
									<a href="bill_pass.php"><li>Bills to be Passed</li></a>
									<a href="rectify_bills.php"><li>Bills to be rectified</li></a>
								</ul>
							</div>
						</li>
						<a target="_blank" href="../reports/apao_report.php">
							<li class="menu_li">
								<span>Report</span>
							</li>
						</a>
						<a href="check_bill_status_auditor.php">
							<li class="menu_li">
								<span>Check Bill Status</span>
							</li>
						</a>
						<li class="menu_li">
							<span>Settings</span>
							<div class="menu_extn">
								<ul class="menu_extn_ul">
									<a href="change_password.php">
										<li style="border:0px;">Change Password</li>
									</a>
								</ul>
							</div>
						</li>
					</ul>
				</div>
				<div class="other_content" style="height:auto;padding-bottom:20px;margin-bottom:40px;">
					<h3 class="add_agency_txt" style="background:#474646;">Bill Scrutiny</h3>
					<div class="agency_form">
						<table cellpadding="5" class="scrutiny_table" border="1" id='bill_list_tab'>
							<tr class="ddo_scrutiny_table_tr">
								<td class="td_scrutiny_table">
									SNo
								</td>
								<td class="td_scrutiny_table">
									Token No
								</td>
								<td class="td_scrutiny_table">
									Token Date
								</td>
								<td class="td_scrutiny_table">
									Agency Name
								</td>
								<td class="td_scrutiny_table">
									Ddo Code
								</td>
								<td class="td_scrutiny_table">
									Head of Account
								</td>
								<td class="td_scrutiny_table">
									Gross Amount(in Rs.)
								</td>
								<td class="td_scrutiny_table">
									Deductions(in Rs.)
								</td>
								<td class="td_scrutiny_table">
									Net Amount(in Rs.)
								</td>
							</tr>
						</table>
						<div class="bill_det_wrap" style="display:none;">
							<h4 class="add_agency_txt" style="width:610px;background:#474646;">Bill Details</h4>
							<div class="form_full_div">
								<div class="form_name" style="width:200px;">
									Token Number:
								</div> 
								<div class="input_div" id='tknno'>
									1234
								</div>
							</div>
							<div class="form_full_div">
								<div class="form_name" style="width:200px;">
									Submission Date: 
								</div> 
								<div class="input_div" id='submitdate'>
									18/2/2014
								</div>
							</div>
							<div class="form_full_div">
								<div class="form_name" style="width:200px;">
									Form No:
								</div> 
								<div class="input_div" id='formno'>
									FORM - 47
								</div>
							</div>
							<div class="form_full_div">
								<div class="form_name" style="width:200px;">
									Form Type:
								</div> 
								<div class="input_div" id='formtype'>
									FORM - 47
								</div>
							</div>
							<div class="form_full_div">
								<div class="form_name" style="width:200px;">
									Head of Account:
								</div> 
								<div class="input_div" id='hoa'>
									2000-23-2323-2341234-23432
								</div>
							</div>
							<div class="form_full_div">
								<div class="form_name" style="width:200px;">
									DDO:
								</div> 
								<div class="input_div" id='ddodesg'>
									Sample Text Here
								</div>
							</div>
							<div class='amt_dets'>
								<h4 class="add_agency_txt" style="width:610px;background:#474646;">Amount Details</h4>
								<div class='amt_dets_main'>
									<div class="form_full_div">
										<div class="form_name" style="width:200px;">
											Gross Amount:
										</div> 
										<div class="input_div" id='gross_amt'>
											19,893/-
										</div>
									</div>
									<div class="form_full_div">
										<div class="form_name" style="width:200px;">
											PT Deductions:
										</div> 
										<div class="input_div" id='pt_amt'>
											193/-
										</div>
									</div>
									<div class="form_full_div">
										<div class="form_name" style="width:200px;">
											VAT Deductions:
										</div> 
										<div class="input_div" id='vat_amt'>
											9,893/-
										</div>
									</div>
									<div class="form_full_div">
										<div class="form_name" style="width:200px;">
											IT Deductions:
										</div> 
										<div class="input_div" id='it_amt'>
											19,893/-
										</div>
									</div>
									<div class="form_full_div">
										<div class="form_name" style="width:200px;">
											Total Deductions:
										</div> 
										<div class="input_div" id='tot_amt'>
											19,893/-
										</div>
									</div>
									<div class="form_full_div">
										<div class="form_name" style="width:200px;">
											Agency Amount:
										</div> 
										<div class="input_div" id='net_amt'>
											19,893/-
										</div>
									</div>
								</div>
							</div>
							<div class='agncy_bank_dets'>
								<h4 class="add_agency_txt" style="width:610px;background:#474646;">Agency & Bank Details</h4>
								<div class="form_full_div">
									<div class="form_name" style="width:200px;">
										Agency Name:
									</div> 
									<div class="input_div" id='partyname' style="text-transform:uppercase;">
										MANAGER Q&A ACCOUNTS HYDERABAD
									</div>
								</div>
								<div class="form_full_div">
									<div class="form_name" style="width:200px;">
										Bank Name:
									</div> 
									<div class="input_div" style="text-transform:uppercase;" id='bname'>
										STATE BANK OF INDIA
									</div>
								</div>
								<div class="form_full_div">
									<div class="form_name" style="width:200px;">
										Branch Name:
									</div> 
									<div class="input_div" style="text-transform:uppercase;" id='bbranch'>
										Secunderabad
									</div>
								</div>
								<div class="form_full_div">
									<div class="form_name" style="width:200px;">
										Account Number:
									</div> 
									<div class="input_div" style="text-transform:uppercase;" id='bacno'>
										238494903489
									</div>
								</div>
								<div class="form_full_div">
									<div class="form_name" style="width:200px;">
										IFSC Code:
									</div> 
									<div class="input_div" style="text-transform:uppercase;" id='bifsc'>
										SBIN930238490
									</div>
								</div>
							</div>
							<!--<div class='scr_dets'>
								<h4 class="add_agency_txt" style="width:610px;background:#474646;margin-bottom:30px;">Scrutiny Items</h4>
								<table cellpadding="5" class="scrutiny_table" id='scrutiny_list_table' border="1">
									<tr class="ddo_scrutiny_table_tr">
										<td class="td_scrutiny_table">
											Rule No
										</td>
										<td class="td_scrutiny_table">
											Description
										</td>
										<td class="td_scrutiny_table">
											DDO Check Status
										</td>
										<td class="td_scrutiny_table">
											Auditor Check Status
										</td>
										<td class="td_scrutiny_table">
											Supt. Check Status
										</td>
										<td class="td_scrutiny_table">
											Yes
										</td>
										<td class="td_scrutiny_table">
											No
										</td>
										<td class="td_scrutiny_table">
											N/A
										</td>
									</tr>
								</table>
								<div class="form_full_div">
									<div class="form_name" style="width:200px;">
										Auditor Remarks:
									</div> 
									<div class="input_div" style="width:680px;" id='aud_rems'>
										
									</div>
								</div>
								<div class="form_full_div">
									<div class="form_name" style="width:200px;">
										Supt. Remarks:
									</div> 
									<div class="input_div" style="width:680px;" id='sup_rems'>
										
									</div>
								</div>
								<div class="form_full_div">
									<div class="form_name" style="width:300px;padding-left:10px;">
										Are there any remarks?
									</div> 
									<div class="input_div" style="width:370px;">
										<input type="radio" name="rmk_correct" id='rmk_yes'/>Yes
										 <input type="radio" name="rmk_correct" id='rmk_no' checked/>No
									</div>
									<div class="form_full_div" id='rmk_di_wrap' style='display:none;'>
										<div class="form_name" style="width:200px;">
											Remarks:
										</div> 
										<div class="input_div" style="width:680px;">
											<textarea id='remarks_area' style="width:400px;height:50px;resize:none;float:left"></textarea>
										</div>
									</div>
								</div>
							</div>-->
							<div class="form_full_div" style="padding: 30px 240px;width: 200px;">
								<button type="button" class="save_agency pass_rej" id="bill_pass">Pass Bill</button>
							</div>
						</div>
					</div>
				</div>
				<div class="footer">
					<div class="copyright">
						Copyright 2014, All rights Reserved
					</div>
					<div class="footer_menu">
						<div class="ftr_menu_each" style="border:0px;">
							<a href="#">Home</a>
						</div>
						<div class="ftr_menu_each">
							<a href="#">About</a>
						</div>
						<div class="ftr_menu_each">
							<a href="#">Contact Us</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="lightbox"></div>
	<div class="lightbox_panel">
		<img src="../images/loader.gif" alt="">
	</div>
</body>
</html>