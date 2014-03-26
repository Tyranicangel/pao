$(document).ready(function(){
	var transid='';
	$('#submit_transaction_id').click(function(){
		if($('#sec_no_token').val()=='')
		{
			alert('Please enter transaction id');
		}
		else
		{
			transid=$('#sec_no_token').val();

			$(".lightbox_panel").css("top",(($(window).height()-$(".lightbox_panel").height())/2));
			$(".lightbox_panel").css("left",(($(window).width()-$(".lightbox_panel").width())/2));
			$('.lightbox').show();
			$('.lightbox_panel').show();
			$.ajax({
				type:'POST',
				url:'get_trans_details.php',
				dataType:'JSON',
				data:{tid:$('#sec_no_token').val()},
				success:function(result)
				{
					//console.log(result);
					$('.lightbox').hide();
					$('.lightbox_panel').hide();
					if(result==false)
					{
						alert('This transaction id does not exist');
					}
					else
					{
						if(result[0]['billstatus']=='1')
						{
							alert("Token has been generated already");
						}
						else
						{
							$('#transid').html(result[0]['transid']);
							$('#submit_date').html(result[0]['tokenissuedate']);
							$('#form_no').html(result[0]['formno']);
							$('#form_type').html(result[0]['ftype']);
							$('#gross_amt').html(result[0]['gross']);
							$('#ptded_amt').html(result[0]['ptdedn']);
							$('#itded_amt').html(result[0]['itdedn']);
							$('#vatded_amt').html(result[0]['vatdedn']);
							$('#net_amt').html(result[0]['net']);
							$('#hoa_info').html(sort_hoa(result[0]['hoa']));
							$('#agency_name').html(result[0]['partyname']);
							$('#acno').html(result[0]['bankacno']);
							$('#bankname').html(result[0]['bname']);
							$('#bankbranch').html(result[0]['bbranch']);
							$('#ifsccode').html(result[0]['bankcode']);
							$('.token_generate_div').show();
							$('#transid_div').hide();
							$('#trans_submit_div').hide();
							$('#ddo_info').html(result[0]['ddodesg']);
						}
					}
				}
			});
		}
	});

	function sort_hoa(hoa_name)
	{
		var x=hoa_name.substr(0,4)+"-"+hoa_name.substr(4,2)+"-"+hoa_name.substr(6,3)+"-"+hoa_name.substr(9,2)+"-"+hoa_name.substr(11,2)+"-"+hoa_name.substr(13,3)+"-"+hoa_name.substr(16,3)+"-"+hoa_name.substr(19);
		return x;
		
	}

	$('#generate_token').click(function(){
		if(transid=='')
	 	{
			alert('Error try again later');
		}
		else
		{
			$(".lightbox_panel").css("top",(($(window).height()-$(".lightbox_panel").height())/2));
			$(".lightbox_panel").css("left",(($(window).width()-$(".lightbox_panel").width())/2));
			$('.lightbox').show();
			$('.lightbox_panel').show();
			$.ajax({
				type:'POST',
				url:'get_token.php',
				dataType:'JSON',
				data:{tid:transid},
				success:function(result)
				{
					$('.lightbox').hide();
					$('.lightbox_panel').hide();
					$('#token_no_main').html("Token No: "+result[0]).show();
					$('#aud_no_main').html("Auditor: "+result[1]+"  Section: "+result[2]).show();					
					$('#generate_token').hide();
					//console.log(result);
				}
			});
		}
	});
});