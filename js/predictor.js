$(document).ready(function(){
	$("#use_predictor").click(function(){
		var job_id=$(this).parent(".job_id").attr("id");
		var cand_id=$("div.brij").attr("id");
		$(this).removeClass("btn-primary").addClass("btn-default");
		alert("Ss");
		start_cal(cand_id,job_id);
	});
	var start_cal=function(cand_id,job_id){
		var $result=$("#use_predictor");
		$.ajax({
			type:"POST",
			url:"candidate_interface.py",
			data:"predictor_id="+cand_id+"&job_id="+job_id,
			success:function(data){
				$result.html(data);
			}
		});
	};
});