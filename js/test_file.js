$(document).ready(function () {
   	var show_tests=function(){
		var testOutput = $("#testOutput");
		var totaltestnum = $("#total_num");
		var testRefresh = $("#test_refresh");
		var retrieveTests=function() {
			var parid=$("div.brij").attr('id');
			$.ajax({
				type: 'POST', 
				url: 'submit_test_and_questions.py',
				data: 'tests_reload='+parid,
				success  : function (data)
				{
					total_test_num();
					testOutput.html(data);
				}
				});
		};
		
		var total_test_num=function()
		{
			var parid=$("div.brij").attr('id');
			$.ajax({
				type: 'POST', 
				url: 'submit_test_and_questions.py',
				data: 'total_test_num='+parid,
				success  : function (data)
				{
					if(data!=-1)
						{
						totaltestnum.html(data);
						}
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