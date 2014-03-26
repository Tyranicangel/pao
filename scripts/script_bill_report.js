$(document).ready(function(){
	$('#delete_from').datepicker({dateFormat: 'dd-mm-yy'});
	$('#show_bill').click(function(){
		if($('#delete_from').val()=='')
		{
			alert("Please enter from date");
		}
		else
		{
			var delf=$('#delete_from').val().split("-");
			var del_from=delf['2']+'-'+delf['1']+'-'+delf['0'];
			var src='report_1.php?date='+del_from;
			window.open(src,'_blank');
		}
	});
	
	$('#show_rep').click(function(){
		if($('#delete_from').val()=='')
		{
			alert("Please enter from date");
		}
		else
		{
			var delf=$('#delete_from').val().split("-");
			var del_from=delf['2']+'-'+delf['1']+'-'+delf['0'];
			var src='report_2.php?date='+del_from;
			window.open(src,'_blank');
		}
	});
});
