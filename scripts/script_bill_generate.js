$(document).ready(function(){
	var total=0;
	$.ajax({
		type:'POST',
		url:'get_bill_gen_list.php',
		dataType:"JSON",
		success: function(result)
		{
			for(var i=0;i<result.length;i++)
			{
				var $clone=$('<tr></tr>').addClass('ddo_scrutiny_val');
				$clone.html("<td>"+(i+1)+"</td><td>"+result[i]['transid']+"</td><td>"+result[i]['tokenissuedate']+"</td><td>"+result[i]['hoa']+"</td><td>"+result[i]['bankcode']+"</td><td>"+result[i]['gross']+"</td>");
				$clone.appendTo($('.scrutiny_table'));
				total=total+parseInt(result[i]['gross']);
			}
			$('#tot_amt').html(total);
		}
	});
	
	$('#start_scrutiny').click(function(){
		$(".lightbox_panel").css("top",(($(window).height()-$(".lightbox_panel").height())/2));
		$(".lightbox_panel").css("left",(($(window).width()-$(".lightbox_panel").width())/2));
		$('.lightbox').show();
		$('.lightbox_panel').show();
		if(validator($('#sec_no_chq').val(),"cn"))
		{
			alert("Please enter a valid cheque number");
		}
		else
		{
			$.ajax({
				type:'POST',
				url:'generate_bank_file.php',
				data:{chq:$('#sec_no_chq').val()},
				success:function(result)
				{
					$('.lightbox').hide();
					$('.lightbox_panel').hide();
					$('#start_scrutiny').hide();
					$('#bank_gen').html("<a download href='"+result+"'>File Generated:"+result+"</a>").show();
				}
			});
		}
	});
});