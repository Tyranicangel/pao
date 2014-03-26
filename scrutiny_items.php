<?php
	/*$dbc=pg_connect("host=localhost dbname=postgres user=postgres password=noobtard123") or die('Could not connect:'.pg_last_error());
	$q=pg_query("SET search_path TO finance");
	var_dump($q);
	$query=pg_query("SELECT * FROM dtos_trans ORDER BY transid DESC LIMIT 5");
	while($result=pg_fetch_array($query,null,PGSQL_ASSOC))
	{
		var_dump($result);
	}
	$query=pg_query("SELECT * FROM acdcbill ORDER BY actransid DESC LIMIT 5");
	while($result=pg_fetch_array($query,null,PGSQL_ASSOC))
	{
		var_dump($result);
	}*/
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Bill Monitoring System</title>
	<link rel="stylesheet" type="text/css" href="styles/main_style.css"/>
	<script type='text/javascript'src='scripts/jquery.js'></script>
	<script>
		$(document).ready(function(){
		});
	</script>
</head>
<body>
	<div class="main_div">
		<div class="main_div_sub">
			<div class="header">
				<div class="header_logo">
					<img src="images/govt_logo.gif" class="logo">
				</div>
				<div class="header_heading">
					<h1>Pay and Accounts Office(PAO)</h1>
					<div class="govt_text">GOVT. OF ANDHRA PRADESH</div>
				</div>
			</div>
			<div class="date_time_tab">
				<div class="welcome_tct">
					BILLS PAID
				</div>
			</div>
			<div class="content_div">
				<div class="content_inner">
					<div class="contents_indi">
						<a href="www.google.com" class="pdf_links">Form-47</a>
					</div>
					<div class="contents_indi">
						<a href="www.google.com" class="pdf_links">Form-58</a>
					</div>
					<div class="contents_indi">
						<a href="www.google.com" class="pdf_links">Form-102</a>
					</div>
					<div class="contents_indi">
						<a href="www.google.com" class="pdf_links">Form-62</a>
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