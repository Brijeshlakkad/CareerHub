$(document).ready(function () {
   	var show_questions=function(){
		var queOutput = $("div.questions_of_test");
		var retrieveQuestions=function() {
			var testid=$("div.test_header").attr('id');
			var currentid=$("div.questions_of_test").attr('id');
			$.ajax({
				type: 'POST', 
				url: 'test_running.py',
				data: 'que_reload='+testid+"&current_id="+currentid,
				success  : function (data)
				{
					queOutput.html(data);
				}
				});
		};
		
		retrieveQuestions();
		
	};
	
	show_questions();
});