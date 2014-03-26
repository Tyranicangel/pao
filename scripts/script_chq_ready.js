$(document).ready(function(){
	var gross_amt=0;
	/*$.ajax({
		type:'POST',
		url:'get_bill_list.php',
		dataType:'JSON',
		success:function(result)
		{
			if(result.length>0)
			{
				for(var i=0;i<result.length;i++)
				{
					var $clone=$('<tr></tr>').addClass('main_content_tr_scr');
					$clone.html("<td>"+(i+1)+"</td><td>"+result[i]['transid']+"</td><td>"+getdate(result[i]['tokenissuedate'])+"</td><td>"+result[i]['partyname']+"</td><td>"+result[i]['ddocode']+"</td><td>"+sort_hoa(result[i]['hoa'])+"</td><td>"+result[i]['gross']+"</td><td>"+result[i]['dedn']+"</td><td>"+result[i]['net']+"</td>");
					$clone.appendTo($('#bill_list_tab'));
				}	
			}
			else
			{
				alert("You have no new bills");
				$('#start_scrutiny').hide();
			}
		}
	});*/
	
	$('#start_scrutiny').click(function(){
		if($('#sec_no_token').val()=='')
		{
			alert("Please enter token number");
		}
		else
		{
			$('#start_scrutiny').hide();
			$('#bill_list_tab').hide();
			$(".lightbox_panel").css("top",(($(window).height()-$(".lightbox_panel").height())/2));
			$(".lightbox_panel").css("left",(($(window).width()-$(".lightbox_panel").width())/2));
			$('.lightbox').show();
			$('.lightbox_panel').show();
			$.ajax({
				type:'POST',
				url:'get_first_bill_details.php',
				data:{tkno:$('#sec_no_token').val()},
				dataType:"JSON",
				success:function(result)
				{
					$('.lightbox').hide();
					$('.lightbox_panel').hide();
					$('#transid_div').hide();
					$('#tknno').html(result['transid']);
					var tdate=result['tokenissuedate'].split('-');
					$('#submitdate').html(tdate[2]+'-'+tdate[1]+'-'+tdate[0]);
					$('#formno').html(result['formno']);
					$('#formtype').html(result['frules'][0]['category']);
					$('#hoa').html(sort_hoa(result['hoa']));
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
				},
				error:function(result)
				{
					$('.lightbox').hide();
					$('.lightbox_panel').hide();
					alert('This token is not available');
					$('#start_scrutiny').show();
				}
			});
		}
	});
		
	$('#forward_to_supt').click(function(){
		$.ajax({
			type:'POST',
			url:'aud_submit.php',
			data:{tkno:$('#tknno').html()},
			success:function(result)
			{
				//console.log(result);
				//location.reload();
				$('#forward_to_supt').hide();
				$('#token_no_main').html('Vocher no: '+result).show();
			}
		});		
	});
		
});