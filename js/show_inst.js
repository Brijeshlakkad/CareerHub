$("#show_institute").click(function(){
	var inst_id=$(this).children().find("div.inst_id").attr("id");
	var job_id=$(this).children().find("div.job_id").attr("id");
	$(this).append("<form method='post' id='myForm' action='show_institute.php'><input type='hidden' name='inst_id' value='"+inst_id+"' /><input type='hidden' name='job_id' value='"+job_id+"' /></form>");
	$("#myForm").submit();
	});