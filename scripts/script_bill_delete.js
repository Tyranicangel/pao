$(document).ready(function(){
	$('#delete_from').datepicker({dateFormat: 'dd-mm-yy'});
	$('#delete_to').datepicker({dateFormat: 'dd-mm-yy'});

	$('#show_bill').click(function(){
		if($('#delete_from').val()=='')
		{
			alert("Please enter from date");
		}
		else if($('#delete_to').val()=="")
		{
			alert("Please enter to date");
		}
		else
		{
			var delf=$('#delete_from').val().split("-");
			var del_from=delf['2']+'-'+delf['1']+'-'+delf['0'];
			var delt=$('#delete_to').val().split("-");
			var del_to=delt['2']+'-'+delt['1']+'-'+delt['0'];
			$(".lightbox_panel").css("top",(($(window).height()-$(".lightbox_panel").height())/2));
			$(".lightbox_panel").css("left",(($(window).width()-$(".lightbox_panel").width())/2));
			$('.lightbox').show();
			$('.lightbox_panel').show();
			$('.temp_del_table').remove();
			$.ajax({
				type:'POST',
				url:'get_delete_list.php',
				dataType:'JSON',
				data:{
						dfrom:del_from,
						dto:del_to
					},
				success:function(result)
				{
					$('.lightbox').hide();
					$('.lightbox_panel').hide();
					if(result)
					{
					}
					else
					{
						alert("There are no pending bills during this period");
					}
					for(var i=0;i<result.length;i++)
					{
						var $clone=$('<tr></tr>').addClass('temp_del_table');
						var td=result[i]['tokenissuedate'].split("-");
						var tdates=td[2]+'-'+td[1]+'-'+td[0];
						$clone.attr('id',result[i]['transid']);
						$clone.html("<td class='table_chkbox'><input type='checkbox' class='del_chk'/></td><td class='main_sno'>"+(i+1)+"</td><td class='transaction_id'>"+result[i]['transid']+"</td><td class='head_of_accnt_main'>"+sort_hoa(result[i]['hoa'])+"</td><td class='gross_amnt_main'>"+result[i]['gross']+"</td><td class='net_amnt_main'>"+result[i]['net']+"</td><td class='subm_date_td'>"+tdates+"</td>");
						$clone.appendTo($('#delete_bill_table'));
						$('.delete_bill_table').show();
						$('#delete_bill').show();
					}
				}
			});
		}
	});

	$('#delete_bill').click(function(){
		var del_array=[];
		$('.del_chk').each(function(){
			if($(this).attr('checked'))
			{
				del_array.push($(this).parent().parent().attr('id'));
				//console.log($(this).parent().parent().attr('id'));
				$(this).parent().parent().remove();
			}
		});
		if(del_array.length==0)
		{
			alert("Please select bills to be deleted");
		}
		else
		{
			$(".lightbox_panel").css("top",(($(window).height()-$(".lightbox_panel").height())/2));
			$(".lightbox_panel").css("left",(($(window).width()-$(".lightbox_panel").width())/2));
			$('.lightbox').show();
			$('.lightbox_panel').show();
			$.ajax({
				type:'POST',
				url:'delete_bill_entry.php',
				data:{dele:del_array},
				success:function(result)
				{
					$('.lightbox').hide();
					$('.lightbox_panel').hide();
					alert("Bill deleted");
					//console.log(result);
				}
			});
		}
	});
});