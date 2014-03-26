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
	$q1=pg_fetch_array(pg_query("SELECT COUNT(*) FROM npayments WHERE auduser='$user_id' AND billstatus='1' AND fyear='$finyear'"),null,PGSQL_ASSOC);
	$q2=pg_fetch_array(pg_query("SELECT COUNT(*) FROM npayments WHERE auduser='$user_id' AND billstatus='21' AND fyear='$finyear'"),null,PGSQL_ASSOC);	
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Auditor Login</title>
	<link rel="stylesheet" type="text/css" href="../styles/main_style.css"/>
	<link rel="stylesheet" type="text/css" href="../styles/auditor_css.css"/>
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
						<a target="_blank" href="../reports/audit_report.php">
							<li class="menu_li">
								<span>Auditor Report</span>
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
				<div class="other_content">
					<h2 class="pao_txt">Welcome to the Pay and Accounts Office Web Portal</h2>
					<div class="home_page_icons">
						<div class="image1" style="border-left:0px;">
							<img src="../images/accounts_icon.png" style="width:90px;"/>
						</div>
						<div class="image1">
							<img src="../images/list_icon.png" style="width:90px;"/>
						</div>
						<div class="image1">
							<img src="../images/rupee_icon.png" style="padding-top:10px;"/>
						</div>
					</div>
					<h4 class="add_agency_txt" style="background:#474646;">You have <?php echo $q1['count']; ?> bills to be scrutinized.</h4>
					<h4 class="add_agency_txt" style="background:#474646;">You have <?php echo $q2['count']; ?> bills to be rectified.</h4>
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