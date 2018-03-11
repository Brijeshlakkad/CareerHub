$(document).ready(function () {
   	var show_tests=function(){
		var testOutput = $("#testOutput");
		var testRefresh = $("#test_refresh");
		
		var retrieveTests=function() {
			var parid=$("div.brij").attr('id');
			$.ajax({
				type: 'POST', 
				url: 'submit_test_and_questions.py',
				data: 'tests_reload='+parid,
				success  : function (data)
				{
					testOutput.html(data);
				}
				});
		};
		retrieveTests();
		testRefresh.click(function () {
			retrieveTests();
		});	
	};
	
	show_tests();
});