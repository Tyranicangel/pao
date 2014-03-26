$(document).ready(function(){
	var gross_amt=0;
	var billtype="";
	
	$.ajax({
		type:'POST',
		url:'get_bill_pass_list.php',
		dataType:'JSON',
		success:function(result)
		{
			if(result.length>0)
			{
				for(var i=0;i<result.length;i++)
				{
					var $clone=$('<tr></tr>').addClass('main_content_tr_scr');
					$clone.html("<td>"+(i+1)+"</td><td class='tk'>"+result[i]['transid']+"</td><td>"+getdate(result[i]['tokenissuedate'])+"</td><td>"+result[i]['partyname']+"</td><td>"+result[i]['ddodesg']+"</td><td>"+sort_hoa(result[i]['hoa'])+"</td><td>"+result[i]['gross']+"</td><td>"+result[i]['dedn']+"</td><td>"+result[i]['net']+"</td>");
					$clone.appendTo($('#bill_list_tab'));
				}	
			}
			else
			{
				alert("You have no new bills");
				$('#start_scrutiny').hide();
			}
		}
	});
	
	
	$(document).on('click','.main_content_tr_scr',function(){
		$('#start_scrutiny').hide();
		$('#bill_list_tab').hide();
		$(".lightbox_panel").css("top",(($(window).height()-$(".lightbox_panel").height())/2));
		$(".lightbox_panel").css("left",(($(window).width()-$(".lightbox_panel").width())/2));
		$('.lightbox').show();
		$('.lightbox_panel').show();
		var ids=$(this).find('.tk').html();
		$.ajax({
			type:'POST',
			url:'get_first_bill_pass_details.php',
			data:{tkno:ids},
			dataType:"JSON",
			success:function(result)
			{
				$('.lightbox').hide();
				$('.lightbox_panel').hide();
				$('#tknno').html(result['transid']);
				var tdate=result['tokenissuedate'].split('-');
				$('#submitdate').html(tdate[2]+'-'+tdate[1]+'-'+tdate[0]);
				$('#formno').html(result['formno']);
				$('#formtype').html(result['frules'][0]['category']);
				$('#hoa').html(sort_hoa(result['hoa']));
				//update_bill_type(result['gross']);
				$('#ddodesg').html(result['ddodesg']);
				$('#gross_amt').html(result['gross']);
				gross_amt=parseInt(result['gross']);
				$('#it_amt').html(result['itdedn']);
				$('#pt_amt').html(result['ptdedn']);
				$('#vat_amt').html(result['vatdedn']);
				$('#tot_amt').html(result['dedn']);
				$('#net_amt').html(result['net']);
				$('#partyname').html(result['partydets']['partyname']);
				$('#bname').html(result['partydets']['bankname']);
				$('#bbranch').html(result['partydets']['branch']);
				$('#bacno').html(result['bankcode']);
				$('#bifsc').html(result['partydets']['ifsccode']);
				$('.bill_det_wrap').show();
				bal_amt=parseInt(result['auth'])-parseInt(result['exp']);
				if(gross_amt>bal_amt)
				{
					$('.pass_rej').attr('id','bill_reject');
				}
				//$('#aud_rems').html(result['form_aud_chk']['remarks']);
				//$('#sup_rems').html(result['form_sup_chk']['remarks']);
			}
		});
	});
		
	/*$('#update_head_no').change(function(){
		if($(this).attr('checked'))
		{
			$('#hoa_change').show();
		}
	});
	
	$('#update_head_yes').change(function(){
		if($(this).attr('checked'))
		{
			$('#hoa_change').hide();
		}
	});
	
	$('#update_head_option').change(function(){
		if($(this).val()=='__select__')
		{
			$('#update_head_div').hide();
		}
		else
		{
			$('#update_head_div').show();
		}
	});
	
	$('#update_head').click(function(){
		if($('#update_head_option').val()=='__select__')
		{
			alert('Please select head of account');
		}
		else
		{
			$(".lightbox_panel").css("top",(($(window).height()-$(".lightbox_panel").height())/2));
			$(".lightbox_panel").css("left",(($(window).width()-$(".lightbox_panel").width())/2));
			$('.lightbox').show();
			$('.lightbox_panel').show();
			$.ajax({
				type:'POST',
				url:'update_head.php',
				data:{tkno:$('#tknno').html(),hoaname:$('#update_head_option').val()},
				success:function(result)
				{
					$('.lightbox').hide();
					$('.lightbox_panel').hide();
					$('#update_head_yes').attr('checked',true);
					$('#update_head_no').attr('checked',false);
					$('#hoa_change').hide();
					$('#hoa').html(sort_hoa($('#update_head_option').val()));
					$('#update_head_option').val('__select__');
					$('#update_head_div').hide();
				}
			});
		}
	});
	
	$('#update_amt_no').change(function(){
		if($(this).attr('checked'))
		{
			$('#amt_change').show();
			$('#update_amount_div').show();
			$('.amt_dets_main').hide();
			$('#gross_amount').val($('#gross_amt').html());
			$('#pt_deduction').val($('#pt_amt').html());
			$('#vat_deduction').val($('#vat_amt').html());
			$('#it_deduction').val($('#it_amt').html());
			$('#net_amount').val($('#net_amt').html());
		}
	});
	
	$('#update_amt_yes').change(function(){
		if($(this).attr('checked'))
		{
			$('#amt_change').hide();
			$('#update_amount_div').hide();
			$('.amt_dets_main').show();
		}
	});
	
	function update_net()
	{
		var bgross=parseInt($('#gross_amount').val());
		var bptded=parseInt($('#pt_deduction').val());
		var bitded=parseInt($('#it_deduction').val());
		var bvatded=parseInt($('#vat_deduction').val());
		var bnet=bgross-(bptded+bitded+bvatded);
		if(bnet<0)
		{
			alert("Please enter the amount properly");
			$('#net_amount').val('');
		}
		else if(bgross>gross_amt)
		{
			alert("You cannot increase the gross amount");
			$('#gross_amount').val(gross_amt);
		}
		else
		{
			$('#net_amount').val(bnet);
		}
	}

	$('#vat_deduction').change(function(){
		update_net();
	});

	$('#pt_deduction').change(function(){
		update_net();
	});

	$('#it_deduction').change(function(){
		update_net();
	});

	$('#gross_amount').change(function(){
		update_net();
	});
	
	$('#update_amount').click(function(){
		if($('#gross_amount').val()=='')
		{
			alert('Please enter all the necessary fields');
		}
		else if($('#it_deduction').val()=='')
		{
			alert('Please enter gross amount');
		}
		else if($('#pt_deduction').val()=='')
		{
			alert('Please enter Pt deduction');
		}
		else if($('#vat_deduction').val()=='')
		{
			alert('Please enter all the necessary fields');
		}
		else if(validator($('#it_deduction').val(),"n"))
		{
			alert('IT deduction has invalid characters');
		}
		else if(validator($('#gross_amount').val(),"n"))
		{
			alert('Gross amount has invalid characters');
		}
		else if(validator($('#pt_deduction').val(),"n"))
		{
			alert('PT deduction has invalid characters');
		}
		else if(validator($('#vat_deduction').val(),"n"))
		{
			alert('VAT deduction has invalid characters');
		}
		else if(parseInt($('#net_amount').val())<0)
		{
			alert('Agency amount is invalid');
		}
		else if($('#net_amount').val()=="")
		{
			alert('Agency amount is less than zero');
		}
		else
		{
			$.ajax({
				type:'POST',
				url:'update_amount.php',
				data:{
					bgross:$('#gross_amount').val(),
					bptded:$('#pt_deduction').val(),
					bitded:$('#it_deduction').val(),
					bvatded:$('#vat_deduction').val(),
					tkno:$('#tknno').html()
				},
				success:function(result)
				{
					$('#amt_change').hide();
					$('#update_amount_div').hide();
					$('.amt_dets_main').show();
					$('#gross_amt').html($('#gross_amount').val());
					$('#pt_amt').html($('#pt_deduction').val());
					$('#vat_amt').html($('#vat_deduction').val());
					$('#it_amt').html($('#it_deduction').val());
					$('#net_amt').html($('#net_amount').val());
					var bptded=parseInt($('#pt_deduction').val());
					var bitded=parseInt($('#it_deduction').val());
					var bvatded=parseInt($('#vat_deduction').val());
					var bnet=bptded+bitded+bvatded;
					$('#tot_amt').html(bnet);
					$('#update_amt_yes').attr('checked',true);
					$('#update_amt_no').attr('checked',false);
				}
			});
		}
	});
	
	$(document).on('click','#forward_to_supt',function(){
		var formdat="";
		var formflag=1;
		$('.tempfrmrules').each(function(){
			
			if($(this).find('.aud_chk_yes').attr('checked'))
			{
				formdat=formdat+$(this).attr('id')+":y|";
			}
			else if($(this).find('.aud_chk_no').attr('checked'))
			{
				formdat=formdat+$(this).attr('id')+":n|";	
			}
			else if($(this).find('.aud_chk_na').attr('checked'))
			{ 
				formdat=formdat+$(this).attr('id')+":a|";
			}
			else
			{
				formflag=0;
			}
		});
		if(formflag==0)
		{
			alert('Please select all fields in the scrutiny list');
		}
		else
		{
			$.ajax({
				type:'POST',
				url:'aud_submit.php',
				data:{tkno:$('#tknno').html(),formdata:formdat,rems:$('#remarks_area').val()},
				success:function(result)
				{
					alert(result);
					location.reload();
				}
			});
		}
		
	});
	
	$(document).on('click','.aud_chk_yes',function(){
		update_button();
	});
	
	$(document).on('click','.aud_chk_no',function(){
		update_button();
	});
	
	$(document).on('click','.aud_chk_na',function(){
		update_button();
	});
	
	$('#rmk_no').click(function(){
		if($(this).attr('checked'))
		{
			$('#rmk_di_wrap').hide();
		}
		update_button();
	});
	
	$('#rmk_yes').click(function(){
		if($(this).attr('checked'))
		{
			$('#rmk_di_wrap').show();
		}
		update_button();
	});
	
	
	function update_button()
	{
		var frmflag=1;
		$('.tempfrmrules').each(function(){
			if($(this).find('.aud_chk_no').attr('checked'))
			{
				frmflag=0;
			}
		});
		
		if($('#rmk_yes').attr('checked')) 
		{
			frmflag=0;
		}
		
		if(billtype=='passing')
		{
			if(frmflag==0)
			{
				$('.pass_rej').html('Reject Bill').attr('id','bill_reject');
			}
			else
			{
				$('.pass_rej').html('Pass Bill').attr('id','bill_pass');
			}
		}
		else if(billtype=='frwd')
		{
			if(frmflag==0)
			{
				$('.pass_rej').html('Reject Bill').attr('id','bill_reject');
			}
			else
			{
				$('.pass_rej').html('Forward to PAO').attr('id','forward_to_supt');
			}
		}
	}
	
	function update_bill_type(gross)
	{
		if(parseInt(gross)>=500000)
		{
			billtype='frwd';
		}
		else
		{
			billtype='passing';
		}
	}*/
	
	$(document).on('click','#bill_pass',function(){
		/*var formdat="";
		var formflag=1;
		$('.tempfrmrules').each(function(){
			
			if($(this).find('.aud_chk_yes').attr('checked'))
			{
				formdat=formdat+$(this).attr('id')+":y|";
			}
			else if($(this).find('.aud_chk_no').attr('checked'))
			{
				formdat=formdat+$(this).attr('id')+":n|";	
			}
			else if($(this).find('.aud_chk_na').attr('checked'))
			{ 
				formdat=formdat+$(this).attr('id')+":a|";
			}
			else
			{
				formflag=0;
			}
		});*/
		$.ajax({
			type:'POST',
			url:'aud_bill_pass.php',
			data:{tkno:$('#tknno').html()},
			success:function(result)
			{
				alert(result);
				location.reload();
			}
		});		
	});
	
	$(document).on('click','#bill_reject',function(){
		alert("Insufficient budget");
		
	});
});