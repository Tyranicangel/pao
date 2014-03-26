$(document).ready(function(){
	$.ajax({
		type:'GET',
		url:'get_bank_list.php',
		dataType:'JSON',
		success:function(result)
		{
			for(var i=0;i<result.length;i++)
			{
				var $clone=$('#sample_bank_select').clone().removeAttr('id');
				$clone.attr('value',result[i]['bankname']).html(result[i]['bankname']);
				$clone.appendTo('#bank_select_options');
			}
		}
	});

	$('#pan_yes').change(function() {
		if($(this).attr('checked'))
		{
			$('#temp_id_div').hide();
			$('#pan_tan').val('').attr('readonly',false).css({'background':'#ffffff'});
			$('#confirm_pan').val('').attr('readonly',false).css({'background':'#ffffff'});
		}
	});

	$('#pan_no').change(function(){
		if($(this).attr('checked'))
		{
			$('#temp_id_div').show();
			$('#pan_tan').val('').attr('readonly',true).css({'background':'#fcf0c9'});
			$('#confirm_pan').val('').attr('readonly',true).css({'background':'#fcf0c9'});
		}
	});


	$('#bank_select_options').change(function(){
		$('.temp_select').remove();
		$('#ifsc_code').val('');
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
				url:'get_bank_state.php',
				data:{bname:$(this).val()},
				dataType:'JSON',
				success:function(result)
				{
					$('.lightbox').hide();
					$('.lightbox_panel').hide();
					for(var i=0;i<result.length;i++)
					{
						var $clone=$('#sample_bank_state').clone().removeAttr('id').addClass('temp_select');
						$clone.attr('value',result[i]['state']).html(result[i]['state']);
						$clone.appendTo('#bank_state_options');
					}
				}
			});
		}
	});

	$('#bank_state_options').change(function(){
		$('.temp_branch').remove();
		$('#ifsc_code').val('');
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
				url:'get_bank_branch.php',
				data:{bname:$('#bank_select_options').val(),bstate:$(this).val()},
				dataType:'JSON',
				success:function(result)
				{
					$('.lightbox').hide();
					$('.lightbox_panel').hide();
					for(var i=0;i<result.length;i++)
					{
						var $clone=$('#sample_bank_state').clone().removeAttr('id').addClass('temp_select').addClass('temp_branch');
						$clone.attr('value',result[i]['branch']).html(result[i]['branch']);
						$clone.appendTo('#bank_branch_options');
					}
				}
			});	
		}
	});

	$('#bank_branch_options').change(function(){
		$('#ifsc_code').val('');
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
				url:'get_bank_code.php',
				data:{bname:$('#bank_select_options').val(),bstate:$('#bank_state_options').val(),bbranch:$(this).val()},
				dataType:'JSON',
				success:function(result)
				{
					$('.lightbox').hide();
					$('.lightbox_panel').hide();
					$('#ifsc_code').val(result['ifsccode']);
				}
			});	
		}
	});

	$('#save_agency').click(function(){
		if($('#pan_yes').attr('checked'))
		{
			var apstat=1;
			var apno=$('#pan_tan').val();
		}
		else
		{
			var apstat=3;
			var apno=$('#temp_id_no').html();
		}
		if($('#agency_name').val()=="")
		{
			alert('Please Agency Name');
		}
		else if(apno=='')
		{
			alert('Please Pan/Tan/Temp No');
		}
		else if($('#bank_select_options').val()=='__select__')
		{
			alert('Please select Bank Name');
		}
		else if($('#ifsc_code').val()=='')
		{
			alert('Please select Bank details');
		}
		else if($('#acc_no').val()=='')
		{
			alert('Please enter account no');
		}
		else if($('#confirm_acc_no').val()=='')
		{
			alert('Please confirm account no');
		}
		else if($('#address').val()=='')
		{
			alert('Please enter address');
		}
		else if($('#cell_no').val()=='')
		{
			alert('Please enter all cell no');
		}
		else if($('#confirm_pan').val()!=$('#pan_tan').val())
		{
			alert('The pan numbers do not match');
		}
		else if($('#acc_no').val()!=$('#confirm_acc_no').val())
		{
			alert('The account numbers do not match');
		}
		else if($('#acc_no').val().length>17)
		{
			alert('The account number is too long');
		}
		else if(validator($('#agency_name').val(),"cns"))
		{
			alert('Agency name has invalid characters');
		}
		else if(validator($('#pan_tan').val().toUpperCase(),"cn"))
		{
			alert('Pan number has invalid characters');
		}
		else if(validator($('#labour').val(),"cn"))
		{
			alert('Labor Registration has invalid characters');
		}
		else if(validator($('#sales_tax').val(),"cn"))
		{
			alert('Sales tax has invalid characters');
		}
		else if(validator($('#acc_no').val(),"n"))
		{
			alert('Account number has invalid characters');
		}
		else if(validator($('#cell_no').val(),"n"))
		{
			alert('Cell number has invalid characters');
		}
		else if(validator($('#pin_code').val(),"n"))
		{
			alert('Pin code has invalid characters');
		}
		else
		{
			$(".lightbox_panel").css("top",(($(window).height()-$(".lightbox_panel").height())/2));
			$(".lightbox_panel").css("left",(($(window).width()-$(".lightbox_panel").width())/2));
			$('.lightbox').show();
			$('.lightbox_panel').show();
			$.ajax({
				type:'POST',
				url:'agency_add.php',
				data:{
						acode:$('#agency_code').val(),
						aname:$('#agency_name').val().toUpperCase(),
						apanstat:apstat,
						apanno:apno.toUpperCase(),
						asalestax:$('#sales_tax').val().toUpperCase(),
						alaborno:$('#labour').val().toUpperCase(),
						abank:$('#bank_select_options').val(),
						aifsc:$('#ifsc_code').val(),
						aaccno:$('#acc_no').val().toUpperCase(),
						aaddress:$('#address').val(),
						acity:$('#city').val(),
						adistrict:$('#district').val(),
						apin:$('#pin_code').val(),
						aphone:$('#phone_off').val(),
						acell:$('#cell_no').val(),
						aemail:$('#email_id').val()
					},
				success:function(result)
				{
					//console.log(result);
					$('.lightbox').hide();
					$('.lightbox_panel').hide();
					$('input').val('');
					$('.temp_select').remove();
					$('#address').val('');
					$('#bank_select_options').val('__select__');
					if(result=='success')
					{
						alert('Agency details added successfully');
					}
					else
					{
						alert(result);
					}
					setTimeout(function(){location.reload();},2000);
				}
			});
		}
	});


});