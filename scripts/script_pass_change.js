$(document).ready(function(){
	$('#change_password').click(function(){
		if($('#old_password').val()=='')
		{
			alert('Please enter your old password');
		}
		else if($('#new_password').val()=='')
		{
			alert('Please enter new password');
		}
		else if($('#confirm_new_password').val()=='')
		{
			alert('Please confirm the password');
		}
		else if($('#new_password').val()!=$('#confirm_new_password').val())
		{
			alert('The passwords you entered do not match');
		}
		else
		{
			$(".lightbox_panel").css("top",(($(window).height()-$(".lightbox_panel").height())/2));
			$(".lightbox_panel").css("left",(($(window).width()-$(".lightbox_panel").width())/2));
			$('.lightbox').show();
			$('.lightbox_panel').show();
			$.ajax({
				type:'POST',
				url:'pass_change.php',
				data:{oldpass:$('#old_password').val(),newpass:$('#new_password').val()},
				success:function(result)
				{
					$('.lightbox').hide();
					$('.lightbox_panel').hide();
					if(result=='success')
					{
						alert("Password Changed");
						location.reload();
					}
					else
					{
						alert("Please enter correct password");						
					}
				}
			});
		}
	});
});