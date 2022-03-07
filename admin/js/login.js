$(document).ready(function(){
	$('.login-form').submit(function(e){
		$.ajax({
			type:'POST',
			url:'../includes/login-code.php',
			data:$(this).serialize(),
			dataType:'json',
			success: function(response){
				alert(response);
				location.reload();
			}
		});
		e.preventDefault();
	});
});