$(document).ready(function(){
	$('#show_bill').click(function(){
		if($('#year_select').val()=='__select__')
		{
			alert('Please enter the financial year');
		}
		else if($('#transaction_id_print').val()=="")
		{
			alert('Please enter the transaction id');
		}
		else
		{
			$.ajax({
				type:'POST',
				url:'get_bill_print_conf.php',
				data:{tid:$('#transaction_id_print').val(),byear:$('#year_select').val()},
				dataType:'JSON',
				success:function(result)
				{
					if(result==false)
					{
						alert('There is no bill with this transaction id');
						$('#print_frame').hide();
					}
					else
					{
						$("#print_frame").attr('src','prints.php?tid='+result[0]['transid']).show();
					}
				}
			});
		}
	});
});