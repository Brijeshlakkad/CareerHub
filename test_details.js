$(document).ready(function () {
   	var show_tests=function(){
		var testOutput = $("#testOutput");
		var totaltestnum = $("#total_num_test");
		var testRefresh = $("#test_refresh");
		
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
						testOutput.html(data);
						}
				}
				});
		};
		total_test_num();
		testRefresh.click(function () {
			var cont=$("#refresh_name").text();
				alert(""+cont);
				total_test_num();
		});
		
	};
	
	show_tests();
});