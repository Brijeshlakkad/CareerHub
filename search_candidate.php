<?php
require_once('functions.php');
require_once('institute_header.php');
require_once('institute_functions.php');
check_session(); 
get_details_from_institute();
$sql="Select * from jobs where institute_id='$institute_id'";
$job_result=mysqli_query($con,$sql);

?>
<div class="container-fluid well" >
<div class="row" ng-app="myapp" ng-controller="BrijController">
	<div class="col-md-3">
	</div>
	<div class="col-md-3">
		<span>Select Job/Training :</span>
		<select class="form-control" name="job" id="job" ng-model="job" >
    	<?php
     	while($row_of_job=mysqli_fetch_array($job_result))
		{?>
      	<option value="<?php echo $row_of_job['job_id']; ?>"><?php echo ucwords($row_of_job['job_title']); ?></option>
      	<?php }?>
		</select>
	</div>
	<div class="col-md-1">
	</div>
	<div class="col-md-2">
		<span>Match by</span>
     	<select class="form-control" name="matchby" ng-change="changed(matchby)" id="matchby" ng-model="matchby">
     	<option value="quali_match">Required skills</option>
     	<option value="exp_match">Experience year</option>
     	<option value="location_match">Location</option>
      	<option value="best_match">Best match</option>
		</select>
	</div>
	<div class="col-md-3">
	</div>
</div>
<div class="row" id="search_result_cand">
	
</div>
</div>
<script>
var myApp=angular.module("myapp",[]);
myApp.controller("BrijController", function($scope,$http) {
	$scope.changed=function(state){
		var flag="-99";
		var jobid=$scope.job;
		if(state=="best_match")
			{
				flag="best_match";
			}
		else if(state=="quali_match")
			{
				flag="quali_match";
			}
		else if(state=="exp_match")
			{
				flag="exp_match";
			}
		else if(state=="location_match")
			{
				flag="location_match";
			}
		if(flag!="-99")
			{
				get_cand_list(flag,jobid);
			}
	};
});
function get_cand_list(flag,jobid)
	{
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
</script>
<?php require_once('institute_footer.php');?>