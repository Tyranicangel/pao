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
	<link rel="stylesheet" type="text/css" href="styles/calender.css"/>
	<script type='text/javascript'src='scripts/jquery.js'></script>
	<script type='text/javascript'src='scripts/jquery_ui.js'></script>
	<script>
		$(document).ready(function(){
			$('#date_from').datepicker();
			$('#date_to').datepicker();
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
					BILLS AUTHORIZED
				</div>
			</div>
			<div class="content_div">
				<div class="content_inner">
					<div class="contents_indi">
						<div class="content_indi_text">From Date:</div>
						<div class="content_indi_area">
							<input type="text" class="select_inputs" id='date_from'>
						</div>
					</div>
					<div class="contents_indi">
						<div class="content_indi_text">To Date:</div>
						<div class="content_indi_area">
							<input type="text" class="select_inputs" id='date_to'>
						</div>
					</div>
					<div class="contents_indi">
						<div class="content_indi_text">PAO:</div>
						<div class="content_indi_area">
							<select name="" id="" class='select_inputs'>
								<option value="_select_">--SELECT--</option>
								<option value="main">MAIN</option>
								<option value="brkr">BRKR</option>
								<option value="kblock">K-BLOCK</option>
								<option value="ocb">OCB</option>
							</select>
						</div>
					</div>
					<div class="contents_indi">
						<div class="content_indi_text">Department:</div>
						<div class="content_indi_area">
							<select name="select_type" id="" class='select_inputs'>
								<option value="_select_">--SELECT--</option>
							</select>
						</div>
					</div>
					<div class="contents_indi">
						<div class="content_indi_text">Category:</div>
						<div class="content_indi_area">
							<select name="select_type" id="" class='select_inputs'>
								<option value="_select_">--SELECT--</option>
								<option value="1994_1995">Div Bill No</option>
								<option value="1995_1996">Token No</option>
								<option value="1996_1997">Agency</option>
							</select>
						</div>
					</div>
					<div class="contents_indi" id='submit_div'>
						<div class="submit_buttons">Submit</div>
						<a href='index.php'><div class="submit_buttons">Back</div></a>
					</div>
					<div class="contents_indi">
						<div class="note_text">NOTE:"From Date" and "To Date" refer to Authorisation Date.</div>
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