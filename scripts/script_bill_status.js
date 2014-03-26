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
				url:'../php_pages/get_bill_status.php',
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