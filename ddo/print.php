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
	<title>Bill Print : DDO</title>
	<link rel="stylesheet" type="text/css" href="../styles/main_style.css"/>
	<script type="text/javascript" src='../scripts/jquery.js'></script>
	<script type="text/javascript" src='../scripts/script_bill_print.js'></script>
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
					<h3 class="add_agency_txt" style="background:#474646;">Print Bills</h3>
				 	<div class="agency_form">
				 		<div class="form_full_div">
							<div class="form_name">Financial Year:</div> 
							<div class="input_div">
								<select class="select_bank" style="width:163px;" id='year_select'>
									<option value="_select_">--SELECT--</option>
									<option value="1994_1995">1994-95</option>
									<option value="1995_1996">1995-96</option>
									<option value="1996_1997">1996-97</option>
									<option value="1997_1998">1997-98</option>
									<option value="1998_1999">1998-99</option>
									<option value="1999_2000">1999-00</option>
									<option value="2000_2001">2000-01</option>
									<option value="2001_2002">2001-02</option>
									<option value="2002_2003">2002-03</option>
									<option value="2003_2004">2003-04</option>
									<option value="2004_2005">2004-05</option>
									<option value="2005_2006">2005-06</option>
									<option value="2006_2007">2006-07</option>
									<option value="2007_2008">2007-08</option>
									<option value="2008_2009">2008-09</option>
									<option value="2009_2010">2009-10</option>
									<option value="2010_2011">2010-11</option>
									<option value="2011_2012">2011-12</option>
									<option value="2012_2013">2012-13</option>
									<option value="2013_2014" selected>2013-14</option>
								</select>
							</div>
						</div>
						<div class="form_full_div">
							<div class="form_name">Transaction Id:</div> 
							<div class="input_div">
								<input type="text" class="form_input_agency" style="width:150px;" id="transaction_id_print"/>
							</div>
						</div>
						<div class="form_full_div" style="padding: 30px 240px;width: 200px;">
							<button type="button" class="save_agency" id="show_bill">Show Bill</button>
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
</body>
</html>