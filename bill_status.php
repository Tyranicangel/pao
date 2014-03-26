<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Bill Monitoring System</title>
	<link rel="stylesheet" type="text/css" href="styles/main_style.css"/>
	<style>
		.other_content
		{
			background:none;
			border:none;
		}
		.ddo_scrutiny_table_tr{
			background:#da231b;
		}
	</style>
	<script type='text/javascript'src='scripts/jquery.js'></script>
	<script type='text/javascript'src='scripts/script_common.js'></script>
	<script>
		$(document).ready(function(){
			$('#show_bill').click(function(){
				$('#bill_list_tab').hide();
				$('#check_list_tab').hide();
				$('#all_rem').hide();
				if($('#transaction_id_print').val()=='')
				{
					alert("Please enter transaction id");
				}
				else
				{
					$(".lightbox_panel").css("top",(($(window).height()-$(".lightbox_panel").height())/2));
					$(".lightbox_panel").css("left",(($(window).width()-$(".lightbox_panel").width())/2));
					$('.lightbox').show();
					$('.lightbox_panel').show();
					$.ajax({
						type:'POST',
						dataType:'JSON',
						async:true,
						url:'php_pages/get_bill_status.php',
						data:{tkno:$.trim($('#transaction_id_print').val())},
						success:function(result)
						{
							$('.lightbox').hide();
							$('.lightbox_panel').hide();
							if(result[0]=='yes')
							{
								show_bill_status(result);
							}
							else
							{
								alert("This token number does not exist");
		
							}
						}
					});
				}
			});
		
		
			function show_bill_status(result)
			{
				
				$('#bill_list_tab').find('.main_content_tr_scr').remove();
				$('#check_list_tab').find('.tempfrmrules').remove();
				$('#remarks_oth').empty();
				var date;
				if(result[1][7] == null)
				{
					date = 'payment yet to be made';
				}
				else
				{
					date = getdate(result[1][7]);
				}
				var $clone=$('<tr></tr>').addClass('main_content_tr_scr');
				$clone.html("<td>"+result[1][0]+"</td><td>"
				+getdate(result[1][1])+
				"</td><td>"+result[1][2]+"</td><td>"
				+result[1][3]+"</td><td>"+sort_hoa(result[1][4])
				+"</td><td>"+result[1][5]+"</td><td>"+result[1][6]
				+"</td><td>"+date+"</td>");
				$clone.appendTo($('#bill_list_tab'));
				$('#bill_list_tab').show();
				if(result[2] == 'yes')
				{
					var ddochk = result[4]['form_data'].split('|');
					var ddochkarr={};
					for(var i=0;i<ddochk.length-1;i++)
					{
						var x=ddochk[i].split(":");
						ddochkarr[x[0]]=x[1];
					}
					for(var i=0;i<result[5].length;i++)
					{
						if(ddochkarr[result[5][i]['formref']] == 'n')
						{
								var $clone=$('<tr></tr>').addClass('tempfrmrules');
								$clone.html("<td>"+(i+1)+"</td><td style='text-align:left;'>"+result[5][i]['formdesc']+
									"</td><td style='text-align:center;'>"+'N'+"</td>");
								$clone.appendTo($('#check_list_tab'));
							
						}
						
					}
					$('#check_list_tab').show();
					if(result[4]['remarks'] == '')
					{
						$remarks = 'none';
					}
					else
					{
						$remarks = result[4]['remarks'];
					}
					$('#remarks_oth').html($remarks);
					$('#all_rem').show();
				}
			}
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
					BILL STATUS
				</div>
			</div>
			<div class="content_div">
				<div class="content_inner">
					<div class="other_content" style="height:auto;padding-bottom:20px;margin-bottom:40px;">
				 	<div class="agency_form">
						<div class="form_full_div">
							<div class="form_name">Token No:</div> 
							<div class="input_div">
								<input type="text" class="form_input_agency" style="width:250px;" id="transaction_id_print"/>
							</div>
						</div>
						<div class="form_full_div" style="padding: 30px 240px;width: 200px;">
							<button type="button" class="submit_buttons" id="show_bill">Show Bill Status</button>
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
	<div class="lightbox"></div>
	<div class="lightbox_panel">
		<img src="images/loader.gif" alt="">
	</div>
</body>
</html>