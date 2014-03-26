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
	$ndate='01'.substr($mdate,2);
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Bill Delete : DDO</title>
	<link rel="stylesheet" type="text/css" href="../styles/main_style.css"/>
	<link rel="stylesheet" type="text/css" href="../styles/calender.css"/>
	<script type="text/javascript" src='../scripts/jquery.js'></script>
	<script type='text/javascript'src='../scripts/jquery_ui.js'></script>
	<script type="text/javascript" src='../scripts/script_common.js'></script>
	<script type="text/javascript" src='../scripts/script_bill_delete.js'></script>
	<style>
	.delete_bill_table td{
		text-align:right;
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
					<h3 class="add_agency_txt" style="background:#474646;">Bills Submitted</h3>
				 	<div class="agency_form">
				 		<div class="form_full_div">
							<div class="form_name">From:</div> 
							<div class="input_div">
								<input type="text" class="form_input_agency" style="width:150px;" id="delete_from" value="<?php echo $ndate;?>"/>
							</div>
						</div>
						<div class="form_full_div">
							<div class="form_name">To:</div> 
							<div class="input_div">
								<input type="text" class="form_input_agency" style="width:150px;" id="delete_to" value="<?php echo $mdate;?>"/>
							</div>
						</div>
						<div class="form_full_div" style="padding: 30px 240px;width: 200px;">
							<button type="button" class="save_agency" id="show_bill">Show Bills</button>
						</div>
					 	<table cellpadding="5" border="1" align="right" class="delete_bill_table" id='delete_bill_table' style='display:none;'>
						 		<tr class="table_header">
						 			<td class="check_list"></td>
						 			<td class="sno">SNo:</td>
						 			<td class="trans_id">TRANS ID</td>
						 			<td class="head_acc">Head of Account</td>
						 			<td class="net_amt">Gross Amount</td>
						 			<td class="gross_amt">Net Amount</td>
						 			<td class="sub_date">Submission Date</td>
						 		</tr>
					 	</table>
					 	<div class="form_full_div" style="padding: 30px 240px;width: 200px;">
							<button type="button" class="save_agency" id="delete_bill" style='display:none;'>Delete</button>
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