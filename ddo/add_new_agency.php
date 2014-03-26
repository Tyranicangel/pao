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
	$r1=pg_fetch_array(pg_query("SELECT MAX(agency_pan_tan) FROM pao_ddo_party WHERE pan_tan_status=3"));
	$tmp_id=substr($r1['max'],0,5).(intval(substr($r1['max'],5))+1);
	$r2=pg_fetch_array(pg_query("SELECT MAX(agency_code) FROM pao_ddo_party"));
	$agency_code=intval($r2['max'])+1;

?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Add Agency : DDO</title>
	<link rel="stylesheet" type="text/css" href="../styles/main_style.css"/>
	<script type="text/javascript" src='../scripts/jquery.js'></script>
	<script type="text/javascript" src='../scripts/script_common.js'></script>
	<script type="text/javascript" src='../scripts/script_add_agency.js'></script>
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
									<a href="delete_bill.php"><li>Bills Submitted</li></a>
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
					<h3 class="add_agency_txt">Add a New Agency</h3>
					<div class="agency_form">
						<div class="form_full_div">
							<div class="form_name">Agency Code:</div> 
							<div class="input_div">
								<input type="text" class="form_input_agency" id="agency_code" value="<?php echo $agency_code;?>" style='background:#fcf0c9;' readonly/>
							</div>
						</div>
						<div class="form_full_div">
							<div class="form_name">Agency Name:<span class="asterix">*</span></div> 
							<div class="input_div">
								<input type="text" class="form_input_agency" style="width:400px;text-transform:uppercase;" id="agency_name"/>
							</div>
						</div>
						<h4 class="add_agency_txt" style="width:610px;">Tax Details</h4>
						<div class="form_full_div">
							<div class="form_name">Is PAN/TAN Available? <span class="asterix">*</span></div> 
							<div class="input_div" style="margin-top:6px;">
								<input type="radio" name="yes_no" class="pan_tan_radio" id='pan_yes' checked='true'/> Yes
								<input type="radio" name="yes_no" class="pan_tan_radio" id='pan_no'/> No
							</div>
						</div>
						<div class="form_full_div">
							<div class="form_name" id='temp_id_div' style="width:600px;display:none;">Your Temporary ID is <span id='temp_id_no' class="asterix"><?php echo $tmp_id; ?></span></div>
						</div>
						<div class="form_full_div">
							<div class="form_name">PAN/TAN No:<span class="asterix">*</span></div> 
							<div class="input_div">
								<input type="text" class="form_input_agency" style="width:400px;" id="pan_tan"/>
							</div>
						</div>
						<div class="form_full_div">
							<div class="form_name">Confirm TAN/PAN No:<span class="asterix">*</span></div> 
							<div class="input_div">
								<input type="text" class="form_input_agency" style="width:400px;" id="confirm_pan"/>
							</div>
						</div>
						<div class="form_full_div">
							<div class="form_name">Sales Tax No:</div> 
							<div class="input_div">
								<input type="text" class="form_input_agency" style="width:400px;" id="sales_tax"/>
							</div>
						</div>
						<div class="form_full_div">
							<div class="form_name">Labour Reg No:</div> 
							<div class="input_div">
								<input type="text" class="form_input_agency" style="width:400px;" id="labour"/>
							</div>
						</div>
						<h4 class="add_agency_txt" style="width:610px;">Bank Details</h4>
						<div class="form_full_div">
							<div class="form_name">Bank Name:<span class="asterix">*</span></div> 
							<div class="input_div">
								<select class="select_bank" id='bank_select_options'>
									<option value="__select__" id='sample_bank_select'>--SELECT--</option>
								</select>
							</div>
						</div>
						<div class="form_full_div">
							<div class="form_name">Select State:</div> 
							<div class="input_div">
								<select class="select_bank" id='bank_state_options'>
									<option value="__select__" id='sample_bank_state'>--SELECT--</option>
								</select>
							</div>
						</div>
						<div class="form_full_div">
							<div class="form_name">Select Branch:</div> 
							<div class="input_div">
								<select class="select_bank" id='bank_branch_options'>
									<option value="__select__" id='sample_bank_branch'>--SELECT--</option>
								</select>
							</div>
						</div>
						<div class="form_full_div">
							<div class="form_name">IFSC Code:<span class="asterix">*</span></div> 
							<div class="input_div">
								<input type="text" class="form_input_agency" style="width:400px;background:#fcf0c9;" id="ifsc_code" readonly/>
							</div>
						</div>
						<!--<div class="form_full_div">
							<div class="form_name">Nature of A/c:<span class="asterix">*</span></div> 
							<div class="input_div">
								<select class="select_bank">
									<option value="nature">Savings</option>
								</select>
							</div>
						</div-->
						<div class="form_full_div">
							<div class="form_name">Bank A/c No:<span class="asterix">*</span></div> 
							<div class="input_div">
								<input type="password" class="form_input_agency" style="width:400px;" id="acc_no" maxlength="17"/>
							</div>
						</div>
						<div class="form_full_div">
							<div class="form_name">Confirm Bank A/c No:<span class="asterix">*</span></div> 
							<div class="input_div">
								<input type="password" class="form_input_agency" style="width:400px;" id="confirm_acc_no" maxlength="17"/>
							</div>
						</div>
						<h4 class="add_agency_txt" style="width:610px;">Agency Address</h4>
						<div class="form_full_div">
							<div class="form_name">Address<span class="asterix">*</span></div> 
							<div class="input_div" style="height:auto;">
								<Textarea type="text" class="address_txt_area" id="address"></textarea>
							</div>
						</div>
						<div class="form_full_div">
							<div class="form_name">City:</div> 
							<div class="input_div">
								<input type="text" class="form_input_agency" style="width:400px;" id="city"/>
							</div>
						</div>
						<div class="form_full_div">
							<div class="form_name">District:</div> 
							<div class="input_div">
								<input type="text" class="form_input_agency" style="width:400px;" id="district"/>
							</div>
						</div>
						<div class="form_full_div">
							<div class="form_name">Pin Code:</div> 
							<div class="input_div">
								<input type="text" class="form_input_agency" style="width:400px;" id="pin_code"/>
							</div>
						</div>
						<div class="form_full_div">
							<div class="form_name">Phone(off):</div> 
							<div class="input_div">
								<input type="text" class="form_input_agency" style="width:400px;" id="phone_off"/>
							</div>
						</div>
						<div class="form_full_div">
							<div class="form_name">Cell No:<span class="asterix">*</span></div> 
							<div class="input_div">
								<input type="text" class="form_input_agency" style="width:400px;" id="cell_no" maxlength="10"/>
							</div>
						</div>
						<div class="form_full_div">
							<div class="form_name">Email Id:</div> 
							<div class="input_div">
								<input type="text" class="form_input_agency" style="width:400px;" id="email_id"/>
							</div>
						</div>
						<div class="form_full_div" style="padding: 30px 240px;width: 200px;">
							<button type="button" class="save_agency" id="save_agency">Save</button>
						</div>
						<div id='error_div' style="float:left;width:680px;font-family:Arial;font-size:14px;color:#da231b;text-align:center;display:none;">Please enter all the necessary fields</div>

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