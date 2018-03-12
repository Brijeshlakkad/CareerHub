<?php
include_once('functions.php');
include_once("config.php");
include_once('index_header.php');
check_session();
if(isset($_POST['test_id']))
{
	$testid=$_POST['test_id'];
	$sql="Select * from Tests where ID='$testid'";
	$result=mysqli_query($con,$sql);
	if($result)
	{
		$row=mysqli_fetch_array($result);
		$title=$row['Title'];
		$course=$row['Course'];
		$subjects=$row['Subjects'];
		$time=$row['Time'];
			?>
<div class="container well" id="show_here">
<div class="row login_block" id="test_panel">
<div class="col-lg-2">
	<button class="btn btn-primary" onclick="javascript:history.back()"><span class="glyphicon glyphicon-arrow-left"></span> Back</button>
</div>
<div class="col-lg-8" ng-app="myapp" ng-controller="BrijController">
	<label><h3>Edit Test</h3></label>
	<form name="TestForm" method="post" class="brij" novalidate>
	<table class="myTable">
	<div class="form-group">
		<tr>
			<td><label for="t_title">Enter Title</label></td>
			<td><input type="text" class="form-control" ng-model="t_title" name="t_title" id="t_title" ng-style="onlyChar" ng-change="analyze1(t_title)" required title-dir/></td>
			<td>
				<span style="color:red" id="s_t_title" ng-show="TestForm.t_title.$dirty && TestForm.t_title.$invalid">
				<span ng-show="TestForm.t_title.$error.required">Title is required.</span>
				<span ng-show="!TestForm.t_title.$error.required && TestForm.t_title.$error.titlelengthvalid">Enter minimum 4 characters.</span>
				<span ng-show="!TestForm.t_title.$error.required && TestForm.t_title.$error.onlycharvalid">Only alphabets and numbers are allowed.</span>
				</span>
			</td>
		</tr>
	</div>
	<div class="form-group">
		<tr>
			<td><label for="t_course">Enter Course</label></td>
			<td><select class="form-control" name="t_course" id="t_course" ng-model="t_course" required>
				<option
				ng-repeat="x in t_courseOptions" 
				ng-value="x.val">{{x.name_c}}</option>
				</select>
			</td>
			<td>
				<span style="color:red" id="s_t_course" ng-show="TestForm.t_course.$dirty && TestForm.t_course.$invalid">
				<span ng-show="TestForm.t_course.$error.required">Course is required</span>
				</span>
			</td>
		</tr>
	</div>
	<div class="form-group">
		<tr>
			<td><label for="t_subjects">Enter Subjects</label></td>
			<td><input type="text" class="form-control" ng-model="t_subjects" name="t_subjects" id="t_subjects" ng-style="subjectStyle" ng-change="analyze2(t_subjects)" required/></td>
			<td>
				<a class="badge my_badge" data-toggle="tooltip" data-placement="top" title="Enter subject names seperated by | character">?</a>
				<span style="color:red" id="s_t_subjects" ng-show="TestForm.t_subjects.$dirty && TestForm.t_subjects.$invalid">
				<span ng-show="TestForm.t_subjects.$error.required">At least one subject is required</span>
				</span>
			</td>
		</tr>
	</div>
		<tr>
			<td><input type="submit" ng-click="update_test()" id="upd_test" value="Submit" class="btn btn-primary" ng-disabled="TestForm.t_title.$invalid ||  TestForm.t_course.$invalid ||  TestForm.t_subjects.$invalid" /></td>
			<td id="status_test"</td>
			<td></td>
		</tr>
	</table>
	</form>
</div>
<div class="col-lg-2">
<form method="post" action="edit_question.php">
<input type="hidden" name="test_id" value="<?php echo $testid; ?>" />
<button class="btn btn-primary" type="submit" ><span class="glyphicon glyphicon-plus"></span> Add Questions</button>
</form>
</div>
</div>
</div>
<script>
var myApp = angular.module("myapp",[]);
	myApp.controller("BrijController",function($scope,$http){
		$scope.t_courseOptions=[
		{val : "Information Technology",name_c:"Information Technology"},
		{val : "Computer Science", name_c : "Computer Science"},
		{val : "Mechanical Engineering", name_c : "Mechanical Engineering"},
		{val : "Civil Engineering", name_c : "Civil Engineering"}
		];
		$scope.t_title="<?php echo $title; ?>";
		$scope.t_course="<?php echo $course; ?>";
		$scope.t_subjects="<?php echo $subjects?>";
		var patt;
		$scope.onlyChar = {
			"border-width":"1.45px"
		};
		$scope.analyze1 = function(value) {
			if(/^[0-9a-zA-Z ]+$/.test(value) && value.length>3) {
				$scope.onlyChar["border-color"] = "green";
			}else {
				$scope.onlyChar["border-color"] = "red";
			}
		};
		$scope.update_test=function(){
			var title=$("#t_title").val();
			var course=$scope.t_course;
			var subjects=$("#t_subjects").val();
			var testid="<?php echo $testid; ?>";
			$.ajax({
				type: 'POST', 
				url: 'submit_test_and_questions.py',
				data: 'test_id='+testid+'&update_test='+title+'&course='+course+'&subjects='+subjects,
				success  : function (data)
				{
					if(data==1)
						{
							$("#status_test").html("<span style='color:green;'>Test updated...</span>");
						}
					else
						$("#status_test").html("<span style='color:red;'>Error! Try agian..</span>");
				}
			});
		
		};
	});
myApp.directive("titleDir",function(){
	return {
		require: 'ngModel',
		link: function(scope, element, attr, mCtrl) {
			function myValidation(value) 
			{
				var patt = new RegExp("^[0-9a-zA-Z ]+$");
				if(patt.test(value)) {
					mCtrl.$setValidity('onlycharvalid', true);
				}
				else {
					mCtrl.$setValidity('onlycharvalid', false);
				}
				if(value.length>3) {
					mCtrl.$setValidity('titlelengthvalid', true);
				}
				else {
					mCtrl.$setValidity('titlelengthvalid', false);
				}
				return value;
			}
			mCtrl.$parsers.push(myValidation);
		}
	};
});
</script>
<?php
	}
}
?>
</body>
</html>