$(document).ready(function(){
	$("#refresh").click(function(){
		location.reload();
	});
	$("#admin_all_cand").click(function(){
			$.post("admin_show_cand.php",
			{
				flag:"all"
			},
			function(data, status){
				$("#show_here").html(data);
			});
		});
	$("#admin_wait_cand").click(function(){
			$.post("admin_show_cand.php",
			{
				flag:"wait"
			},
			function(data, status){
				$("#show_here").html(data);
			});
		});
	$("#admin_appr_cand").click(function(){
			$.post("admin_show_cand.php",
			{
				flag:"appr"
			},
			function(data, status){
				$("#show_here").html(data);
			});
		});
	$("#admin_decl_cand").click(function(){
			$.post("admin_show_cand.php",
			{
				flag:"decl"
			},
			function(data, status){
				$("#show_here").html(data);
			});
		});
	$("#approve_cand").click(function(){
		var parid=$(this).closest('div').attr('id');
		var appr = prompt("Please enter 'Approve' to approve Candidate : "+parid );
		if (appr.toLowerCase() == "approve") {
			$.post("admin_handle_cand.php",
			{
				id: ""+parid,
				flag:"1"
			},
			function(data, status){
				if(data==01)
					alert("Already approved.");
				else if(data==11)
					alert("Candidate "+parid+" is approved Successfully.");
				else if(data==00 || data==01)
					alert("Please, try again! later");
			});
		} else {
			
		}
		});
	$("#decline_cand").click(function(){
		var parid=$(this).closest('div').attr('id');
		var appr = prompt("Please enter 'Decline' to decline Candidate : "+parid );
		if (appr.toLowerCase() == "decline") {
			$.post("admin_handle_cand.php",
			{
				id: ""+parid,
				flag:"0"
			},
			function(data, status){
				if(data==01)
					alert("Already declined.");
				else if(data==11)
					alert("Candidate "+parid+" is declined Successfully.");
				else if(data==00 || data==01)
					alert("Please, try again! later");
			});
		} else {
			
		}
		});
		
});