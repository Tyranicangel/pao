$(document).ready(function(){
	var result;
	$.ajax({
		type:'POST',
		url:'get_to_approve_bills_list_govt.php',
		dataType:'JSON',
		success:function(bill_list)
		{
			result=bill_list;
			show_bills('all');
		}
	});
	
	function show_bills(data)
	{
		$('.temps').remove();
		if(data=='all')
		{
			var gross_amt_arr = [];
			var net_amt_arr = [];
			var total_grs = 0;
			var total_net = 0;
	
			if(result.length>0)
			{
				for(var i=0;i<result.length;i++)
				{
					var $clone=$('<tr></tr>').addClass('main_content_tr_scr').addClass('temps');
					$clone.html("<td>"+(i+1)+"</td><td id='tok_no_id'>"+result[i]['transid']+"</td><td>"+getdate(result[i]['tokenissuedate'])+"</td><td>"+result[i]['partyname']+"</td><td>"+result[i]['ddodesg']+"</td><td>"+sort_hoa(result[i]['hoa'])+"</td><td>"+result[i]['gross']+"</td><td>"+result[i]['net']+"</td><td style='text-align:center;'>"+"<input type='checkbox' class='select_bil_approve'"+"</td>");
					$clone.appendTo($('#bill_list_tab'));
					gross_amt_arr.push(result[i]['gross']);
					net_amt_arr.push(result[i]['net']);
	
				}	
			}
			else
			{
				alert("You have no pending bills to be approved");
				
			}
			for (var i = 0; i < gross_amt_arr.length; i++) {
				total_grs = parseInt(total_grs) + parseInt(gross_amt_arr[i]);
			};
			for (var i = 0; i < net_amt_arr.length; i++) {
				total_net = parseInt(total_net) + parseInt(net_amt_arr[i]);
			};
			var $clone1 = $('<tr></tr>').addClass('total_cls').addClass('temps');
			$clone1.html("<td></td><td></td><td></td><td></td><td></td><td></td><td>"+total_grs+"</td><td>"+total_net+"</td><td></td>");
			$clone1.appendTo($('#bill_list_tab'));
	
			$('#app_bt_out_div').show();
		}
		else if(data=='capital')
		{
			console.log(2);
			var gross_amt_arr = [];
			var net_amt_arr = [];
			var total_grs = 0;
			var total_net = 0;
	
			if(result.length>0)
			{
				for(var i=0;i<result.length;i++)
				{
					if(result[i]['hoa'][0]=='2' || result[i]['hoa'][0]=='3')
					{
						var $clone=$('<tr></tr>').addClass('main_content_tr_scr').addClass('temps');
						$clone.html("<td>"+(i+1)+"</td><td id='tok_no_id'>"+result[i]['transid']+"</td><td>"+getdate(result[i]['tokenissuedate'])+"</td><td>"+result[i]['partyname']+"</td><td>"+result[i]['ddodesg']+"</td><td>"+sort_hoa(result[i]['hoa'])+"</td><td>"+result[i]['gross']+"</td><td>"+result[i]['net']+"</td><td style='text-align:center;'>"+"<input type='checkbox' class='select_bil_approve'"+"</td>");
						$clone.appendTo($('#bill_list_tab'));
						gross_amt_arr.push(result[i]['gross']);
						net_amt_arr.push(result[i]['net']);
					}
				}	
			}
			else
			{
				alert("You have no pending capital bills to be approved");
				
			}
			for (var i = 0; i < gross_amt_arr.length; i++) {
				total_grs = parseInt(total_grs) + parseInt(gross_amt_arr[i]);
			};
			for (var i = 0; i < net_amt_arr.length; i++) {
				total_net = parseInt(total_net) + parseInt(net_amt_arr[i]);
			};
			var $clone1 = $('<tr></tr>').addClass('total_cls').addClass('temps');
			$clone1.html("<td></td><td></td><td></td><td></td><td></td><td></td><td>"+total_grs+"</td><td>"+total_net+"</td><td></td>");
			$clone1.appendTo($('#bill_list_tab'));
	
			$('#app_bt_out_div').show();
		}
		else if(data=='revenue')
		{
			console.log(1);
			var gross_amt_arr = [];
			var net_amt_arr = [];
			var total_grs = 0;
			var total_net = 0;
	
			if(result.length>0)
			{
				for(var i=0;i<result.length;i++)
				{
					if(result[i]['hoa'][0]=='2' || result[i]['hoa'][0]=='3')
					{
					}
					else
					{
						var $clone=$('<tr></tr>').addClass('main_content_tr_scr').addClass('temps');
						$clone.html("<td>"+(i+1)+"</td><td id='tok_no_id'>"+result[i]['transid']+"</td><td>"+getdate(result[i]['tokenissuedate'])+"</td><td>"+result[i]['partyname']+"</td><td>"+result[i]['ddodesg']+"</td><td>"+sort_hoa(result[i]['hoa'])+"</td><td>"+result[i]['gross']+"</td><td>"+result[i]['net']+"</td><td style='text-align:center;'>"+"<input type='checkbox' class='select_bil_approve'"+"</td>");
						$clone.appendTo($('#bill_list_tab'));
						gross_amt_arr.push(result[i]['gross']);
						net_amt_arr.push(result[i]['net']);
					}
				}	
			}
			else
			{
				alert("You have no pending revenue bills to be approved");
				
			}
			for (var i = 0; i < gross_amt_arr.length; i++) {
				total_grs = parseInt(total_grs) + parseInt(gross_amt_arr[i]);
			};
			for (var i = 0; i < net_amt_arr.length; i++) {
				total_net = parseInt(total_net) + parseInt(net_amt_arr[i]);
			};
			var $clone1 = $('<tr></tr>').addClass('total_cls').addClass('temps');
			$clone1.html("<td></td><td></td><td></td><td></td><td></td><td></td><td>"+total_grs+"</td><td>"+total_net+"</td><td></td>");
			$clone1.appendTo($('#bill_list_tab'));
	
			$('#app_bt_out_div').show();
		}
	}

	$('#select_all_bills').click(function(){
		if($(this).attr('checked') == 'checked')
		{
			$('.select_bil_approve').attr('checked','checked');
		}else
		{
			$('.select_bil_approve').removeAttr('checked');
		}
		
	});

	$(document).on('click','#approve_sel_bills',function(){
		var tok_no;
		var tokarr = [];

		$('.select_bil_approve').each(function(){
			if($(this).attr('checked') == 'checked')
			{
				$(this).parents().map(function(){
					if($(this).hasClass('main_content_tr_scr'))
					{
						
						tok_no = $(this).find('#tok_no_id').html();
						tokarr.push(tok_no);
					}
				});
			}
		});

		if(tokarr == '')
		{
			alert('Please select bills to approve!');
		}else{
			$.ajax({
				url:'approve_bills_govt_to_pao.php',
				type:'POST',
				async:true,
				//dataType:'JSON',
				data:{tokarr:tokarr},
				success:function(data)
				{
					//alert(data);
					location.reload();
				}
			});
		}

		
	});
	
	$('.select_bank').change(function(){
		show_bills($(this).val());
	});
		
});