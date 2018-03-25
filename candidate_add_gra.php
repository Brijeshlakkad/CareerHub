<?php
include_once('functions.php');
include_once('index_header.php');
include_once('candidate_details.php');
check_session();

get_details_from_candidate();

?>
<style>
input.ng-touched.ng-invalid {
	border-width: 1.45px;
    border-color: red;
}
input.ng-touched.ng-valid {
    border-width: 1.45px;
    border-color: green;
}
</
</style>
<div class="container well">
 
   <form name="myForm" id="myForm"  ng-app="myapp" ng-controller="BrijController" method="post" novalidate>
    <div class="row">
        <div align="center">
         <h3 class="heading">Graduation Details</h3>
			<table class="myTable">
			<div class="form-group">
			<tr>
				<td><label for="degree">Degree</label></td>
				<td><select class="form-control" name="degree" id="degree" ng-model="degree" >
       <option ng-selected="x.val=='-1'" 
        ng-repeat="x in degreeOptions" 
        ng-value="x.val">{{x.name_c}}</option>
					</select></td>
				<td>
					<span style="color:red" id="s_degree" ng-show="myForm.degree.$dirty && myForm.degree.$invalid">
					<span ng-show="myForm.degree.$error.required">Degree is required</span>
					</span>
				</td>
			</tr>
			<tr>
				<td><label for="course">Course</label></td>
				<td><select class="form-control" name="course" id="course" ng-model="course" >
       <option ng-selected="x.val=='-1'" 
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
				<td><label for="col_pin">College Pincode</label></td>
				<td><input class="form-control" type="text" name="col_pin" id="col_pin" ng-model="col_pin" ng-style="pinStyle"  ng-change="analyze3(col_pin)" required pin-dir/></td>
				<td>
					<span style="color:red" id="s_col_pin" ng-show="myForm.col_pin.$dirty && myForm.col_pin.$invalid">
					<span ng-show="myForm.col_pin.$error.required">Pincode is required</span>
					<span ng-show="!myForm.col_pin.$error.required && myForm.col_pin.$error.pinvalid">Invalid pincode</span>
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

<div class="modal"></div>
<script>
$body = $("body");

$(document).on({
    ajaxStart: function() { $body.addClass("loading");    },
     ajaxStop: function() { $body.removeClass("loading"); }    
});
	
	<?php get_details_from_candidate(); ?>
	var check='<?php echo $course; ?>';
	var myApp = angular.module("myapp", []);
	myApp.controller("BrijController", function($scope,$http) {
		$scope.degreeOptions = [
				{val : "M.Tech/M.E.", name_c : "M.Tech/M.E."},
				{val : "B.Tech/B.E", name_c : "B.Tech/B.E"},
				{val : "MBA", name_c : "MBA"},
				{val : "BCA", name_c : "BCA"}
			];
		$scope.courseOptions = [
				{val : "Information Technology", name_c : "Information Technology"},
				{val : "Computer Science", name_c : "Computer Science"},
				{val : "Mechanical Engineering", name_c : "Mechanical Engineering"},
				{val : "Civil Engineering", name_c : "Civil Engineering"}
			];
		$scope.internOptions = [
				{val : "yes", name_c : "Yes"},
				{val : "no", name_c : "No"}
			];
		if(check!='-99')
			{
				$scope.degree="<?php echo $degree; ?>";
				$scope.course="<?php echo $course; ?>";
				$scope.college="<?php echo $college; ?>";
				$scope.col_pin="<?php echo $col_pin; ?>";
				$scope.intern="<?php echo $intern; ?>";
			}
				var patt3 = new RegExp("^[0-9]{6}$");
				$scope.pinStyle = {
					"border-width":"1.45px"
                };
                $scope.analyze3 = function(value) {
                    if(patt3.test(value)) {
                        $scope.pinStyle["border-color"] = "green";
                    }else {
                        $scope.pinStyle["border-color"] = "red";
                    }
                };
			$scope.submit_form = function() {
							var c0=$scope.degree;
							var c1=$scope.course;
							var c2=$scope.college;
							var c3=$scope.year;
							var c4=$scope.intern;
							var c5=$scope.col_pin;
							$http({
								method : "POST",
								url : "candidate_submit_gra.php",
								data: "degree="+c0+"&course="+c1+"&college="+c2+"&year="+c3+"&intern="+c4+"&col_pin="+c5,
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
	myApp.directive('pinDir', function() {
				return {
					require: 'ngModel',
					link: function(scope, element, attr, mCtrl) {
						function myValidation(value) {
							var patt = new RegExp("^[0-9]{6}$");
							if (patt.test(value)) {
								mCtrl.$setValidity('pinvalid', true);
							} else {
								mCtrl.$setValidity('pinvalid', false);
							}
							return value;
						}
						mCtrl.$parsers.push(myValidation);
					}
				};
});
</script>
	</body>
</html>