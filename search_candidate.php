<?php
require_once('functions.php');
require_once('institute_header.php');
require_once('institute_functions.php');
check_session(); 
get_details_from_institute();
get_job_details();
$sql="Select * from jobs where institute_id='$institute_id'";
$job_result=mysqli_query($con,$sql);

?>
<div class="container-fluid well" >
<div class="row" ng-app="myapp" ng-controller="BrijController">
	<div class="col-md-2">
		<span>Select Job/Training :</span>
		<select class="form-control" name="job" id="job" ng-model="job" >
    	<?php
     	while($row_of_job=mysqli_fetch_array($job_result))
		{?>
      	<option value="<?php echo $row_of_job['job_id']; ?>"><?php echo ucwords($row_of_job['job_title']); ?></option>
      	<?php }?>
		</select>
	</div>
	<div class="col-md-2">
		<span>Degree </span>
      	<input type="checkbox" name="best_match" ng-change="changed('best_match')" id="best_match" ng-model="best_match" />
	</div>
</div>
<div class="row" id="search_result_cand">
	
</div>
</div>
<script>
var myApp=angular.module("myapp",[]);
myApp.controller("BrijController", function($scope,$http) {
	$scope.changed=function(state){
		var flag;
		if(state=="best_match")
			{
				flag="best_match";
				var jobid=$scope.job;
				$.ajax({
				type: 'POST', 
				url: 'get_candidates_filtered.php',
				data: 'flag='+flag+"&job_id="+jobid,
				success  : function (data)
				{
					$("#search_result_cand").html(data);
				}
				});
			}
	};
});
</script>
<?php require_once('institute_footer.php');?>