<?php
	/*session_start();
	if(isset($_SESSION['pao_error']))
	{
		$error=$_SESSION['pao_error'];
	}
	else
	{
		$error=""
	}
	session_write_close();*/
?>

<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Directorate of Pay and Accounts</title>
	<link rel="stylesheet" type="text/css" href="styles/style_index.css"/>
	<script type='text/javascript'src='scripts/jquery.js'></script>
	<script>
		function validateForm()
		{
			var user_id=document.forms['login_form']['user_id'].value;
			var user_pass=document.forms['login_form']['pass'].value;
			if(user_id==null||user_id=='')
			{
				alert("Please enter user id");
				return false;
			}
			else if(user_pass==null||user_pass=='')
			{
				alert("Please enter password");
				return false
			}
		}
	</script>
</head>
<body>
	<div class="main">
		<div class="main_box">
			<div class="header">
				<div class="logo">
					<img src="images/govt_logo.gif" alt="" style='width:100px;height:100px;'>
				</div>
				<div class="heading">
					<h1>Pay and Accounts Office (PAO)</h1>
				</div>
			</div>
			<div class="content">
				<div class="tab_list">
					<ul class="tabs">
						<li class="tabs_options"><a href="bill_status.php">Bill Status</a></li>
						<li class="tabs_options"><a href="bills_authorized.php">Bills Authorised</a></li>
						<li class="tabs_options"><a href="bills_paid.php">Bills Paid</a></li>
						<li class="tabs_options"><a href="payment_details.php">Payment Details</a></li>
						<li class="tabs_options"><a href="scrutiny_items.php">Scrutiny Items</a></li>
						<li class="tabs_options"><a href="pao_manual.php">PAO Manual</a></li>
					</ul>
				</div>
				<div class="content_main">
					<div class="content_heading"><h2>Bills Monitoring System</h2></div>
					<p><h2 style="color:#0066CC;">Welcome</h2></p>
					<p>The On-line Bill Monitoring System is used by the Directorate of Works and Accounts to scrutinize and make the payments in a transparent way for the Bills pertaining to Works and Projects taken up by various Engineering Departments of Govt. of Andhra Pradesh.</p>
					<p>This System monitors the Bills from the submission of Bill by Drawing and Disbursing Officer (DDO) concerned to Pay and Accounts Office, scrutiny of the bill in PAO office, Payment authorisation by the Government and release of payment to Agencies concerned. At all these stages the information and status of the Bill is made available to Public in a transparent manner through Internet. The deficiencies related to Bills can be viewed on-line by the DDO concerned immediately after the scrutiny by PAO office and the requirements can be fulfilled by him.</p>
					<p>The Government will have accurate figures of pending bills dynamically through this on-line system and can take timely decision for authorisation of Bills which are ready for payment. The PAO offices can save considerable time which they used to spend for preparing the reports on requirement of fund.</p>
					<p>After the release of payments the vouchers are entered into the system and various types of reports can be generated for submission to Accountant General, as well as to DDOs.</p>
				</div>
				<div class="login">
					<form action="php_pages/login.php" onsubmit="return validateForm()" method='post' name='login_form' class="login_style">
						<input type="text" placeholder="Login ID" class="login_field" name='user_id'></br>
						<input type="password" placeholder="Password" class="login_field" name='pass'></br></br>
						<input type="submit" value="Sign In" class="button" name='login_button'>
					</form>
				</div>
				<div class="info">
					<a href=""><div class="official">Official Information</div></a>
					<a href=""><div class="official" style="font-size:12px;">Mail to: dwa.bms@gmail.com</div></a>					
				</div>
			</div>
			<div class="footer">
				&copy; Copyright Directorate of Works Accounts 
			</div>
		</div>
	</div>
</body>
</html>