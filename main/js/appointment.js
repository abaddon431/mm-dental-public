$(document).ready(function(){
	// script for getting request form from the main website
	// please refer to the SchedOPModel.class file for clarification on the php script
	$("#appointment-form").submit(function(e){
		var first_name=$('#firstname').val();
		var last_name=$('#lastname').val();
		var name=first_name+' '+last_name;
		var email=$('#contactno').val();
		var date=$('#date').val();
		date+=' 00:00:00';
		$.ajax({
			type:'POST',
			url:'includes/request-insert.php',
			data: {fname:first_name,lname:last_name,email:email,date:date},
			success: function(data){
				$(".suggestPage").empty();
				$(".suggestPage").append('<div class="row"><div class="frontPageText"></div></div>');
				$(".frontPageText").append('<h3 class="mb-3">'+data+'</h3>');
				window.setTimeout(function() {
					window.location.href = 'index.php';
				}, 2000);
			}
		});
		e.preventDefault();
	});

	function setDateMin(){
		$.ajax({
			url:'includes/minDate.php',
			type:'GET',
			dataType:'json',
			success: function(data){
				$("#date").attr("min",data);
			}
		});
	}
	setDateMin();
});