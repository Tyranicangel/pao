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
	$q1=pg_fetch_array(pg_query("SELECT COUNT(*) FROM npayments WHERE passuser='$user_id' AND billstatus='2' AND fyear='$finyear'"),null,PGSQL_ASSOC);
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Check Bill Status</title>
	<link rel="stylesheet" type="text/css" href="../styles/main_style.css"/>
	<link rel="stylesheet" type="text/css" href="../styles/auditor_css.css"/>
	<script type="text/javascript" src='../scripts/jquery.js'></script>
	<script type="text/javascript" src='../scripts/script_common.js'></script>
	<script type="text/javascript" src='../scripts/script_bill_status.js'></script>
</head>
<body>
	<div class="main_div">
		<div class="main_div_sub" style="height:800px;">
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
									<a href="rectify_bills.php"><li>Bills to be rectified</li></a>
								</ul>
							</div>
						</li>
						<a href="check_bill_status_auditor.php">
							<li class="menu_li">
								<span>Check Bill Status</span>
							</li>
						</a>
						<a target="_blank" href="../reports/supt_report.php">
							<li class="menu_li">
								<span>Supt. Report</span>
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
					<h3 class="add_agency_txt" style="background:#474646;">Bill Status</h3>
				 	<div class="agency_form">
						<div class="form_full_div">
							<div class="form_name">Token No:</div> 
							<div class="input_div">
								<input type="text" class="form_input_agency" style="width:250px;" id="transaction_id_print"/>
							</div>
						</div>
						<div class="form_full_div" style="padding: 30px 240px;width: 200px;">
							<button type="button" class="save_agency" id="show_bill">Show Bill Status</button>
						</div>
						<div class="form_full_div">
							<table cellpadding="5" class="scrutiny_table" border="1" style="display:none;"
							 id="bill_list_tab">
								<tr class="ddo_scrutiny_table_tr">
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
										Bill Pos
									</td>
									<td class="td_scrutiny_table">
										Pay Date
									</td>
								</tr>
							</table>
							<table cellpadding="5" class="scrutiny_table" border="1"  style="display:none;margin-top:20px;"
							id="check_list_tab">
								<tr class="ddo_scrutiny_table_tr">
									<td class="td_scrutiny_table">
										Sno
									</td>
									<td class="td_scrutiny_table">
										Description
									</td>
									<td class="td_scrutiny_table">
										Status
									</td>
								</tr>
							</table>
						</div>			
						<div class="form_full_div" 
						style="font-family:arial;display:none;margin-top:30px;" id="all_rem">
							<b>Remarks:</b>
							<p id="remarks_oth"></p>
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
</body>
</html>