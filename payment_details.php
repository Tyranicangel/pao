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
					PAYMENT DETAILS
				</div>
			</div>
			<div class="content_div">
				<div class="content_inner">
					<div class="contents_indi">
						<div class="content_indi_text">Financial Year:</div>
						<div class="content_indi_area">
							<select name="select_year" id="" class='select_inputs'>
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
					<div class="contents_indi">
						<div class="content_indi_text">Pan/Tan No:</div>
						<div class="content_indi_area">
							<input type="text" class="select_inputs">
						</div>
					</div>
					<div class="contents_indi" id='submit_div'>
						<div class="submit_buttons">Submit</div>
						<a href='index.php'><div class="submit_buttons">Back</div></a>
					</div>
					<div class="contents_indi">
						<div class="error_text"></div>
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