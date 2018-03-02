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
</style>
<div class="container well">
 
   <form name="myForm" id="myForm"  ng-app="myapp" ng-controller="BrijController" method="post" novalidate>
    <div class="row">
        <div align="center">
         <h3 class="heading">Add Description</h3>
         <span class="small">(Add details which describes your skills at different level.)</span>
			<table class="myTable">
			<div class="form-group">
			
			<tr>
				<td><label for="desc">Description</label></td>
				<td><textarea class="form-control" name="desc" id="desc" ng-model="desc" ng-style="descStyle"  ng-change="analyze(desc)" cols="40" rows="15" required desc-dir></textarea></td>
				<td><a class="badge my_badge" data-toggle="tooltip" data-placement="top" title="Description can contain 40-400 characters and can only use special characters like ,  /  .  and carrige return character only. ">?</a>
					<span style="color:red" id="s_desc" ng-show="myForm.desc.$dirty && myForm.desc.$invalid">
					<span ng-show="myForm.desc.$error.required">Description is required</span>
					<span ng-show="!myForm.desc.$error.required && myForm.desc.$error.descvalid">Do not use unused character.</span>
					</span>
				</td>
			</tr>
			<tr>
			<td id="status"></td>
			<td><input type="button" class="btn btn-success" ng-click="submit_form()" ng-disabled="myForm.desc.$invalid" value="Submit"/></td>
			<td></td>
			</tr>
			</table>
		</div>
	</div>
	</form>
</div>


<script>
$(document).ready(function(){
	$('[data-toggle="tooltip"]').tooltip(); 
});
	
	<?php get_details_from_candidate(); ?>
	var myApp = angular.module("myapp", []);
	myApp.controller("BrijController", function($scope,$http) {
		
		
				var patt1 = new RegExp("^[0-9a-zA-Z\n,/. ]+$");
				$scope.descStyle = {
					"border-width":"1.45px"
                };
                $scope.analyze = function(value) {
                    if(patt1.test(value) && value.length > 40 && value.length < 400) {
                        $scope.descStyle["border-color"] = "green";
                    }else {
                        $scope.descStyle["border-color"] = "red";
                    }
                };
				
			$scope.submit_form = function() {
							var c1=$scope.desc;
							$http({
								method : "POST",
								url : "candidate_submit_desc.php",
								data: "desc="+c1,
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
	
	myApp.directive('descDir', function() {
				return {
					require: 'ngModel',
					link: function(scope, element, attr, mCtrl) {
						function myValidation(value) {
							var patt = new RegExp("^[0-9a-zA-Z\n,/. ]+$");
							if (patt.test(value)) {
								mCtrl.$setValidity('descvalid', true);
							} else {
								mCtrl.$setValidity('descvalid', false);
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