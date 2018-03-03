<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Welcome to CareerHub</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
	<link href="css/customcss.css" rel="stylesheet">
	<link href="css/search.css" rel="stylesheet">
	<script src="js/jquery.min.js"></script>
	<script src="js/angular.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script type="text/javascript" src="js/admin_cand.js"></script>
	<script type="text/javascript" src="js/bootstrap-show-password.min.js"></script>
</head>
<div class="row" align="center" id="55">
		<form>
			<input type="hidden" name="flag" />
			<button type="button" class="btn btn-success" id="approve_cand" >Approve <span class="glyphicon glyphicon-ok"></span></button>
			<button type="button" class="btn btn-danger" id="decline_cand" >Decline <span class="glyphicon glyphicon-remove"></span></button>
		</form>
	</div>
<script>
	$("#approve_cand").click(function(){
		var parid=$(this).closest('div').attr('id');
		var appr = prompt("Please enter 'Approve' to approve Candidate : "+parid );
		if (appr.toLowerCase() == "approve") {
			$.post("admin_varify_cand.py",
			{
				id: ""+parid,
				flag: "1"
			},
			function(data){
				alert(data);
			});
		} else {
			
		}
		});
	$("#decline_cand").click(function(){
		var parid=$(this).closest('div').attr('id');
		var appr = prompt("Please enter 'Decline' to approve Candidate : "+parid );
		if (appr.toLowerCase() == "approve") {
			$.post("admin_varify_cand.py",
			{
				id: ""+parid,
				flag: "0"
			},
			function(data){
				alert(data);
			});
		} else {
			
		}
		});
  </script>
  <body></body></html>