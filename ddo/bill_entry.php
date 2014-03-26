<?php
	include_once('../php_pages/connect.php');
	session_start();
	if(isset($_SESSION['pao_user']))
	{
		$user_id=$_SESSION['pao_user'];
		$query=pg_query("SELECT ddodesg FROM mddo WHERE ddocode='$user_id'");
		if(pg_num_rows($query))
		{
			$result=pg_fetch_array($query,null,PGSQL_ASSOC);
			$uname=$result['ddodesg'];
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
	<title>Bill Entry : DDO</title>
	<link rel="stylesheet" type="text/css" href="../styles/main_style.css"/>
	<script type="text/javascript" src='../scripts/jquery.js'></script>
	<script type="text/javascript" src='../scripts/script_common.js'></script>
	<script type="text/javascript" src='../scripts/script_bill_entry.js'></script>
	<style>
	.scrutiny_table td
	{
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
							<span>Masters</span>
							<div class="menu_extn" style="padding:0px;">
								<ul class="menu_extn_ul">
									<a href="add_new_agency.php"><li style="border:0px;">Add New Agency</li></a>
								</ul>
							</div>
						</li>
						<li class="menu_li">
							<span>Transactions</span>
							<div class="menu_extn">
								<ul class="menu_extn_ul">
									<a href="bill_entry.php"><li>Bill Entry</li></a>
									<a href="delete_bill.php"><li>Bills Submitted/Delete</li></a>
									<!--<li style="border:0px;">LA- R & R Transactions</li>-->
								</ul>
							</div>
						</li>
						<li class="menu_li">
							<span>Reports</span>
							<div class="menu_extn">
								<ul class="menu_extn_ul">
									<a href="print.php"><li>Print</li></a>
									<a href='../reports/ddo_report.php' target='_blank'><li>DDO Report</li></a>
									<!--<li>Abstracts</li>
									<li>Bills Pending</li>
									<li>Bills Ready</li>
									<li>Bills Autorized & Paid</li>
									<li>Bills Paid Statement</li>
									<li>Recoveries</li>
									<li>LA Reports</li>
									<li style="border:0px;">Department Codes</li>-->
								</ul>
							</div>
						</li>
						<a href="check_bill.php">
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
					<h3 class="add_agency_txt" style="background:#474646;" id='bill_header'>Bill Entry</h3>
					<div class="agency_form">
						<div class="form_full_div" id='form_pan'>
							<div class="form_name" style="width:200px;">Enter PAN/TAN/TEMP Reg No:<span class="asterix">*</span></div> 
							<div class="input_div">
								<input type="text" class="form_input_agency" id="pan_tan_entry"/>
							</div>
						</div>
						<div class="form_full_div" id='form_acno'>
							<div class="form_name" style="width:200px;">Select Bank A/c No:<span class="asterix">*</span></div> 
							<div class="input_div">
								<select class="select_bank" id='select_account_options'>
									<option value="__select__" id='sample_ac_no'>--SELECT--</option>
								</select>
							</div>
						</div>
						<div class='form_wrap' id='agency_wrap' style='float:left;display:none;'>
							<h4 class="add_agency_txt" style="width:610px;">Agency & Bank Details</h4>
							<div class="form_full_div">
								<div class="form_name" style="width:200px;">Bank Name:<span class="asterix">*</span></div> 
								<div class="input_div" id='abankname'>
									STATE BANK OF INDIA	
								</div>
							</div>
							<div class="form_full_div">
								<div class="form_name" style="width:200px;">Branch Name:<span class="asterix">*</span></div> 
								<div class="input_div" id='abankbranch'>
									NUZVD
								</div>
							</div>
							<div class="form_full_div">
								<div class="form_name" style="width:200px;">IFSC Code:<span class="asterix">*</span></div> 
								<div class="input_div" id='abankifsc'>
									SBIN100000789
								</div>
							</div>
							<div class="form_full_div">
								<div class="form_name" style="width:200px;">Agency Name:<span class="asterix">*</span></div> 
								<div class="input_div" id='aname' style="text-transform:uppercase;">
									Executive Engineers Association of India Ltd.
								</div>
							</div>
							<h4 class="add_agency_txt" style="width:610px;">Bill Details</h4>
							<div class="form_full_div">
								<div class="form_name" style="width:200px;">Bill No:<span class="asterix">*</span></div> 
								<div class="input_div">
									<input type="text" class="form_input_agency" id="div_bill_no"/>
								</div>
							</div>
							<div class="form_full_div">
								<div class="form_name" style="width:200px;">Form No:<span class="asterix">*</span></div> 
								<div class="input_div">
									<select class="select_bank" id='form_select_option'>
										<option value="__select__" id='sample_form_option'>--SELECT--</option>
									</select>
								</div>
							</div>
							<div class="form_full_div">
								<div class="form_name" style="width:200px;">Form Type:<span class="asterix">*</span></div> 
								<div class="input_div">
									<select class="select_bank" id='form_type_option'>
										<option value="__select__" id='sample_formt_option'>--SELECT--</option>
									</select>
								</div>
							</div>
							<div class="form_full_div">
								<div class="form_name" style="width:200px;">Head of Account:<span class="asterix">*</span></div> 
								<div class="input_div">
									<select class="select_bank" id='hoa_select_option'>
										<option value="__select__" id='sample_hoa_select'>--SELECT--</option>
									</select>
								</div>
							</div>
							<h4 class="add_agency_txt" style="width:610px;">Amount Details</h4>
							<div class="form_full_div">
								<div class="form_name" style="width:200px;">Gross Amount:<span class="asterix">*</span></div> 
								<div class="input_div">
									<input type="text" class="form_input_agency" id="gross_amount"/>
								</div>
							</div>
							<div class="form_full_div">
								<div class="form_name" style="width:200px;">IT deductions:<span class="asterix">*</span></div> 
								<div class="input_div">
									<input type="text" class="form_input_agency" id="it_deduction" value="0"/>
								</div>
							</div>
							<div class="form_full_div">
								<div class="form_name" style="width:200px;">PT deductions:<span class="asterix">*</span></div> 
								<div class="input_div">
									<input type="text" class="form_input_agency" id="pt_deduction" value="0"/>
								</div>
							</div>
							<div class="form_full_div">
								<div class="form_name" style="width:200px;">VAT deductions:<span class="asterix">*</span></div> 
								<div class="input_div">
									<input type="text" class="form_input_agency" id="vat_deduction" value="0"/>
								</div>
							</div>
							<div class="form_full_div">
								<div class="form_name" style="width:200px;">AGENCY Amount:<span class="asterix">*</span></div> 
								<div class="input_div">
									<input type="text" class="form_input_agency" style='background:#fcf0c9;' id="net_amt" readonly/>
								</div>
							</div>
							<!--<div class="form_full_div">
								<div class="form_name" style="width:200px;">Enter Major Head:<span class="asterix">*</span></div> 
								<div class="input_div">
									<input type="text" class="form_input_agency" id="major_head"/>
								</div>
							</div>
							<div class="form_full_div" style="text-align:center;font-family:arial;font-weight:bold;font-size:14px;">
								<input type="radio" name="voted_charged"/> Voted
								<input type="radio" name="voted_charged"/> Charged
							</div>-->
						</div>
						<div class='form_wrap' id='scrutiny_wrap' style='float:left;display:none;width:680px;'>
							<h4 class="add_agency_txt" style="width:610px;">Scrutiny Items</h4>
							<table cellpadding="5" class="scrutiny_table" border="1">
								<tr class="ddo_scrutiny_table_tr">
									<td class="td_scrutiny_table">
										SNo
									</td>
									<td class="td_scrutiny_table">
										Descritpion
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
							<div class="form_full_div" style="padding: 30px 245px;width: 500px;">
								<button type="button" class="save_agency" id="submit_bill">Submit Bill</button>
								<button type="button" class="save_agency" id="clear_bill" style="margin-left:10px;display:none;">Clear</button>
							</div>
							<div id='error_div' style="float:left;width:680px;font-family:Arial;font-size:14px;color:#da231b;text-align:center;display:none;">Please enter all the necessary fields</div>
						</div>
					</div>
					<iframe style='display:none;' id='print_frame' src="" frameborder="0" width="780" height="1645"></iframe>
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