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
	<title>Bills Ready : Cheque Section</title>
	<link rel="stylesheet" type="text/css" href="../styles/main_style.css"/>
	<link rel="stylesheet" type="text/css" href="../styles/auditor_css.css"/>
	<script type="text/javascript" src='../scripts/jquery.js'></script>
	<script type="text/javascript" src="../scripts/script_common.js"></script>
	<script type="text/javascript" src='../scripts/script_chq_ready.js'></script>
	<style>
	.scrutiny_table td{
		padding:5px;
		text-align:left;
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
									<a href="bill_scrutiny.php"><li>Bills Ready</li></a>
								</ul>
							</div>
						</li>
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
					<h3 class="add_agency_txt" style="background:#474646;">Bills Ready List</h3>
					<div class="agency_form">
						<div class="form_full_div" id='transid_div'>
								<div class="form_name" style="width:200px;">Enter Transaction Id:<span class="asterix">*</span></div> 
								<div class="input_div">
									<input type="text" style="width:400px;" class="form_input_agency" id="sec_no_token"/>
								</div>
						</div>
						<div class="form_full_div" style="padding: 20px 240px;width: 200px;">
							<button type="button" class="save_agency" id="start_scrutiny" >Show Bill</button>
						</div>
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
							<div class="form_full_div" style="padding: 30px 240px;width: 200px;">
								<button type="button" class="save_agency" id="forward_to_supt">Generate Vocher</button>
							</div>
						</div>
						<h4 class="add_agency_txt" id='token_no_main' style="width:610px;background:#da231b;display:none;">Token No: 349823IHIWUEHF89798</h4>
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