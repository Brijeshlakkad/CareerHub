<?php
include_once('functions.php');
include_once('index_header.php');
include_once('candidate_details.php');
check_session();
$error="";
get_details_from_candidate();
if(isset($_GET['q']))
{
	$error="<span style='color:red;'>Please Enter Details Again!!</span>";
}
?>
<style>
input.ng-invalid {
	border-width: 1.45px;
    border-color: red;
}
input.ng-valid {
    border-width: 1.45px;
    border-color: green;
}
</style>
<div class="container well">
 
   <form name="myForm" id="myForm"  ng-app="myapp" ng-controller="BrijController" action="candidate_submit_gra.php" method="post" novalidate>
    <div class="row">
        <div align="center">
         <h3 class="heading">Graduation Details</h3>
			<table class="myTable">
			<div class="form-group">
			<tr>
				<td><?php echo $error; ?></td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td><label for="course">Course</label></td>
				<td><select class="form-control" name="course" id="course" ng-model="course" >
       <option ng-selected="x.val_c=='-1'" 
        ng-repeat="x in courseOptions" 
        ng-value="x.val">{{x.name_c}}</option>
					</select></td>
				<td>
					<span style="color:red" id="s_course" ng-show="myForm.course.$dirty && myForm.course.$invalid">
					<span ng-show="myForm.course.$error.required">Course is required</span>
					</span>
				</td>
			</tr>
			<tr>
				<td><label for="college">Your College</label></td>
				<td><input class="form-control" type="text" name="college" id="college" placeholder="Enter college name" ng-model="college" required/></td>
				<td>
					<span style="color:red" id="s_college" ng-show="myForm.college.$dirty && myForm.college.$invalid">
					<span ng-show="myForm.college.$error.required">College is required</span>
					</span>
				</td>
			</tr>
			<tr>
				<td><label for="year">Passing year</label></td>
				<td><input class="form-control" type="number" min="<?php echo date("Y"); ?>" max="<?php $s=date("Y");
						   echo $s+5; ?>"  step="1"  name="year" id="year" ng-model="year" required/></td>
				<td>
					<span style="color:red" id="s_year" ng-show="myForm.year.$dirty && myForm.year.$invalid">
					<span ng-show="myForm.year.$error.required">Passing year is required</span>
					</span>
				</td>
			</tr>
			<tr>
				<td><label for="intern">Internship/Experience</label></td>
				<td><select class="form-control" name="intern" id="intern" ng-model="intern" required>
			 	<option ng-selected="x.val=='-1'" 
					ng-repeat="x in internOptions" 
					ng-value="x.val">{{x.name_c}}</option>
				</select></td>
				<td>
					<span style="color:red" id="s_intern" ng-show="myForm.intern.$dirty && myForm.intern.$invalid">
					<span ng-show="myForm.intern.$error.required">Yes/No is required</span>
					</span>
				</td>
			</tr>
			<tr>
			<td id="status"></td>
			<td><input type="button" class="btn btn-success" ng-click="submit_form()" ng-disabled="myForm.course.$invalid ||  myForm.college.$invalid ||  myForm.year.$invalid ||  myForm.intern.$invalid " value="Submit"/></td>
			<td></td>
			</tr>
			</table>
		</div>
	</div>
	</form>
</div>

<script>
	
	<?php get_details_from_candidate(); ?>
	var check='<?php echo $course; ?>';
	var myApp = angular.module("myapp", []);
	myApp.controller("BrijController", function($scope,$http) {
		$scope.courseOptions = [
				{val : "B.Tech", name_c : "B.TECH"},
				{val : "MCA", name_c : "MCA"},
				{val : "MBA", name_c : "MBA"},
				{val : "BCA", name_c : "BCA"}
			];
		$scope.internOptions = [
				{val : "yes", name_c : "Yes"},
				{val : "no", name_c : "No"}
			];
		if(check!='-99')
			{
				$scope.course="<?php echo $course; ?>";
				$scope.college="<?php echo $college; ?>";
				$scope.intern="<?php echo $intern; ?>";
			}
			$scope.submit_form = function() {
							var c1=$scope.course;
							var c2=$scope.college;
							var c3=$scope.year;
							var c4=$scope.intern;
							$http({
								method : "POST",
								url : "candidate_submit_gra.php",
								data: "course="+c1+"&college="+c2+"&year="+c3+"&intern="+c4,
								headers: {'Content-Type': 'application/x-www-form-urlencoded'}
							}).then(function mySuccess(response) {
								flag = response.data;
								if(flag==1)
									$("#status").html("<span style='color:green;'>Details added</span>");
								else
									$("#status").html("<span style='color:red;'>Please, try again!</span>");
								
							}, function myError(response) {
								$("#status").html("<span style='color:red;'>Please, try again!</span>");
							});
               };
	});
	
</script>
	</body>
</html>