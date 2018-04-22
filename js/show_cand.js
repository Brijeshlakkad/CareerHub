$(".show_candidate").click(function(){
	var cand_id=$(this).children(".cand_id").attr("id");
	var job_id=$(this).parent(".job_id").attr("id");
	$(this).append("<form method='post' id='myForm_cand' action='institute_get_cand.php'><input type='hidden' name='cand_id' value='"+cand_id+"' /><input type='hidden' name='job_id' value='"+job_id+"' /></form>");
	$("#myForm_cand").submit();
});