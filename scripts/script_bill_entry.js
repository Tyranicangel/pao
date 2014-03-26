$(document).ready(function(){
	var hoa_list=[];
	$.ajax({
		type:'POST',
		url:'get_form_list.php',
		dataType:'JSON',
		success:function(result)
		{
			for(var i=0;i<result.length;i++)
			{
				if(result[i]['formno']=='C')
				{
				}
				else
				{
					var $clone=$('#sample_form_option').clone().removeAttr('id').addClass('temp_formno');
					$clone.attr('value',result[i]['formno']).html(result[i]['formno']);
					$clone.appendTo('#form_select_option');
				}
			}
		}
	});

	$.ajax({
		type:'POST',
		url:'get_hoa_list.php',
		dataType:'JSON',
		success:function(result)
		{
			for(var i=0;i<result.length;i++)
			{
				hoa_list.push(result[i]['hoa']);
			}
		}
	});

	$('#pan_tan_entry').change(function(){
		$('.temp_acno').remove();
		if($(this).val()=='')
		{

		}
		else if(validator($('#pan_tan_entry').val(),"cn"))
		{
			alert('Pan/Tan/Temp number has invalid characters');
		}
		else
		{
			$(".lightbox_panel").css("top",(($(window).height()-$(".lightbox_panel").height())/2));
			$(".lightbox_panel").css("left",(($(window).width()-$(".lightbox_panel").width())/2));
			$('.lightbox').show();
			$('.lightbox_panel').show();
			$.ajax({
				type:'POST',
				url:'get_account_details.php',
				data:{apno:$(this).val().toUpperCase()},
				dataType:'JSON',
				success:function(result)
				{
					$('.lightbox').hide();
					$('.lightbox_panel').hide();
					if(result==false)
					{
						alert('There is no agency with this number.Add the agency and submit the bill again');
					}
					else
					{
						for(var i=0;i<result.length;i++)
						{
							var $clone=$('#sample_ac_no').clone().removeAttr('id').addClass('temp_acno');
							$clone.attr('value',result[i]['bankacno']).html(result[i]['bankacno']);
							$clone.appendTo('#select_account_options');
						}
					}
				}
			});
		}
	});

	$('#select_account_options').change(function(){
		if($(this).val()=='__select__')
		{

		}
		else
		{
			$(".lightbox_panel").css("top",(($(window).height()-$(".lightbox_panel").height())/2));
			$(".lightbox_panel").css("left",(($(window).width()-$(".lightbox_panel").width())/2));
			$('.lightbox').show();
			$('.lightbox_panel').show();
			$.ajax({
				type:'POST',
				data:{acno:$(this).val().toUpperCase()},
				dataType:'JSON',
				url:'get_agency_details.php',
				success:function(result)
				{
					//console.log(result);
					$('.lightbox').hide();
					$('.lightbox_panel').hide();
					$('#abankname').html(result[0]['bankname']);
					$('#abankbranch').html(result[0]['branch']);
					$('#abankifsc').html(result[0]['bankcode']);
					$('#aname').html(result[0]['partyname']);
					$('#agency_wrap').show();
				}
			});
		}
	});



	$('#form_select_option').change(function(){
		$('.temp_form').remove();
		$('#scrutiny_wrap').hide();
		$('.form_rules_tab').remove();
		$('.temp_hoa').remove();
		if($(this).val()=='__select__')
		{
		}
		else
		{
			$(".lightbox_panel").css("top",(($(window).height()-$(".lightbox_panel").height())/2));
			$(".lightbox_panel").css("left",(($(window).width()-$(".lightbox_panel").width())/2));
			$('.lightbox').show();
			$('.lightbox_panel').show();
			$.ajax({
				type:'POST',
				url:'get_form_type.php',
				data:{formno:$(this).val()},
				dataType:'JSON',
				success:function(result)
				{
					$('.lightbox').hide();
					$('.lightbox_panel').hide();
					for(var i=0;i<result.length;i++)
					{
						var $clone=$('#sample_formt_option').clone().removeAttr('id').addClass('temp_form');
						$clone.attr('value',result[i]['formid']).html(result[i]['category']);
						$clone.appendTo('#form_type_option');
					}
				}
			});
		}
	});

	$('#form_type_option').change(function(){
		$('#scrutiny_wrap').hide();
		$('.form_rules_tab').remove();
		$('.temp_hoa').remove();
		if($(this).val()=='__select__')
		{
		}
		else
		{
			$(".lightbox_panel").css("top",(($(window).height()-$(".lightbox_panel").height())/2));
			$(".lightbox_panel").css("left",(($(window).width()-$(".lightbox_panel").width())/2));
			$('.lightbox').show();
			$('.lightbox_panel').show();
			$.ajax({
				type:'POST',
				url:'get_form_rules.php',
				data:{formno:$(this).val(),formid:$('#form_select_option').val()},
				dataType:'JSON',
				success:function(result)
				{
					$('.lightbox').hide();
					$('.lightbox_panel').hide();
					show_hoa_list(result)
					for(var i=0;i<result.length;i++)
					{
						var $clone=$('<tr></tr>').addClass('main_content_tr_scr').addClass('form_rules_tab');
						$clone.attr('id',result[i]['formref']);
						$clone.html("<td>"+(i+1)+"</td><td>"+result[i]['formdesc']+"</td><td><input type='radio' class='ynna_yes ri' name='ynna"+(i+1)+"'/></td><td><input type='radio' class='ynna_no ri' name='ynna"+(i+1)+"'/></td><td><input type='radio' class='ynna_na ri' name='ynna"+(i+1)+"'/></td>");
						$clone.appendTo($('.scrutiny_table'));
					}
					//$('#scrutiny_wrap').show();

				}
			});
		}
	});

	$('#hoa_select_option').change(function(){
		$(".ri").attr("checked",false);
		$('#scrutiny_wrap').hide();
		if($(this).val()=="__select__")
		{

		}
		else
		{
			$('#scrutiny_wrap').show();
		}
	});


	function show_hoa_list(arr)
	{
		var hoas="";
		var hoas_no=[];
		var subdets='';
		for(var i=0;i<arr.length;i++)
		{
			if(arr[i]['formno']==arr[i]['formid'])
			{
					
			}
			else if(arr[i]['formno']=="C")
			{
			}
			else if(arr[i]['dethead']=="")
			{
				hoas="all";
				break;
			}
			else
			{
				hoas="none";
				var subdet;
				if(arr[i]['subdethead']=="")
				{
					subdets="all";
					break;
				}
				var asdf=arr[i]['dethead']+arr[i]['subdethead'];
				if(hoas_no.indexOf(asdf)<0)
				{
					hoas_no.push(asdf);
				}
			}

		}
		if(hoas=="all")
		{
			$('.temp_hoa').remove();
			for(var i=0;i<hoa_list.length;i++)
			{
				var $clone=$('#sample_hoa_select').clone().removeAttr('id').addClass('temp_hoa');
				$clone.attr('value',hoa_list[i]).html(sort_hoa(hoa_list[i]));
				$clone.appendTo('#hoa_select_option');	
			}
		}
		else
		{
			if(subdets=='all')
			{
				$('.temp_hoa').remove();
				for(var i=0;i<hoa_list.length;i++)
				{
					var qwer=hoa_list[i].substr(13,3);
					if(hoas_no.indexOf(qwer)<0)
					{
	
					}
					else
					{
						var $clone=$('#sample_hoa_select').clone().removeAttr('id').addClass('temp_hoa');
						$clone.attr('value',hoa_list[i]).html(sort_hoa(hoa_list[i]));
						$clone.appendTo('#hoa_select_option');
					}
				}
			}
			else
			{
				$('.temp_hoa').remove();
				for(var i=0;i<hoa_list.length;i++)
				{
					var qwer=hoa_list[i].substr(13,3)+hoa_list[i].substr(16,3);
					if(hoas_no.indexOf(qwer)<0)
					{
	
					}
					else
					{
						var $clone=$('#sample_hoa_select').clone().removeAttr('id').addClass('temp_hoa');
						$clone.attr('value',hoa_list[i]).html(sort_hoa(hoa_list[i]));
						$clone.appendTo('#hoa_select_option');	
					}
				}
			}
		}
	}



	$('#submit_bill').click(function(){
		var formdat="";
		var formflag=1;
		$('.form_rules_tab').each(function(){
			if($(this).find('.ynna_yes').attr('checked'))
			{
				formdat=formdat+$(this).attr('id')+":y|";
			}
			else if($(this).find('.ynna_no').attr('checked'))
			{
				formdat=formdat+$(this).attr('id')+":n|";	
			}
			else if($(this).find('.ynna_na').attr('checked'))
			{
				formdat=formdat+$(this).attr('id')+":a|";
			}
			else
			{
				formflag=0;
			}
		});

		if($('#select_account_options').val()=='__select__')
		{
			alert('Please select account no');
		}
		else if($('#div_bill_no').val()=='')
		{
			alert('Please enter bill no');
		}
		else if($('#form_select_option').val()=='__select__')
		{
			alert('Please select form no');
		}
		else if($('#form_type_option').val()=='__select__')
		{
			alert('Please select form type');
		}
		else if($('#gross_amount').val()=='')
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
		else if($('#hoa_select_option').val()=='__select__')
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
		else if(parseInt($('#net_amt').val())<0)
		{
			alert('Agency amount is invalid');
		}
		else if($('#net_amt').val()=="")
		{
			alert('Agency amount is less than zero');
		}
		else if(formflag==0)
		{
			alert('Please select all fields in the scrutiny list').show();
		}
		else
		{
			$.ajax({
				type:'POST',
				url:'submit_bill.php',
				data:{
					abankno:$('#select_account_options').val().toUpperCase(),
					dbillno:$('#div_bill_no').val(),
					bformno:$('#form_select_option').val(),
					bformtype:$('#form_type_option').val(),
					bgross:$('#gross_amount').val(),
					bptded:$('#pt_deduction').val(),
					bitded:$('#it_deduction').val(),
					bvatded:$('#vat_deduction').val(),
					bhoa:$('#hoa_select_option').val()
				},
				success:function(result)
				{
					//console.log(result);
					if(result=='fail')
					{
						alert('Error Please try again later');
					}
					else
					{
						$('#agency_wrap').hide();
						$('#scrutiny_wrap').hide();
						$('#form_pan').hide();
						$('#form_acno').hide();
						submit_scrutiny(result,formdat);
						$('#print_frame').attr('src','prints.php?tid='+result).show();
						$("#bill_header").hide();
						//console.log(result);
					}
				}
			});
		}
	});

	function submit_scrutiny(tranid,scrlist)
	{
		$.ajax({
			type:'POST',
			url:'submit_scrutiny.php',
			data:{tid:tranid,chklist:scrlist},
			success:function(result)
			{
				console.log(result);
			}
		});
	}

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
			$('#net_amt').val('');
		}
		else
		{
			$('#net_amt').val(bnet);
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

});