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
         <h3 class="heading">Personal Details</h3>
			<table class="myTable">
			<div class="form-group">
			
			<tr>
				<td><label for="postal_add">Postal Address</label></td>
				<td><input class="form-control" type="text" name="postal_add" id="postal_add" ng-model="postal_add" ng-style="postaladdStyle"  ng-change="analyze1(postal_add)" required add-dir /></td>
				<td>
					<span style="color:red" id="s_postal_add" ng-show="myForm.postal_add.$dirty && myForm.postal_add.$invalid">
					<span ng-show="myForm.postal_add.$error.required">Postal Address is required</span>
					<span ng-show="!myForm.postal_add.$error.required && myForm.postal_add.$error.addvalid">Do not use unused character.</span>
					</span>
				</td>
			</tr>
			<tr>
				<td><label for="perm_add">Permanent Address</label></td>
				<td><input class="form-control" type="text"  name="perm_add" id="perm_add" ng-model="perm_add" ng-style="permaddStyle"  ng-change="analyze2(perm_add)" required add-dir /></td>
				<td><input type="checkbox" name="same_as" id="same_as" ng-model="same_as" ng-change="address_fun()" /> Same as above
					<span style="color:red" id="s_perm_add" ng-show="myForm.perm_add.$dirty && myForm.perm_add.$invalid">
					<span ng-show="myForm.perm_add.$error.required">Permanent Address is required</span>
					<span ng-show="!myForm.perm_add.$error.required && myForm.perm_add.$error.addvalid">Do not use unused character.</span>
					</span>
				</td>
			</tr>
			<tr>
				<td><label for="country">Country</label></td>
				<td><input class="form-control" type="text" name="country" id="country" ng-model="country" ng-style="countryStyle"  ng-change="analyze5(country)" required country-dir/></td>
				<td>
					<span style="color:red" id="s_country" ng-show="myForm.country.$dirty && myForm.country.$invalid">
					<span ng-show="myForm.country.$error.required">Country is required</span>
					<span ng-show="!myForm.country.$error.required && myForm.country.$error.countryvalid">Enter proper input</span>
					</span>
				</td>
			</tr>
			<tr>
				<td><label for="state">State</label></td>
				<td><input class="form-control" type="text" name="state" id="state" ng-model="state" ng-style="stateStyle"  ng-change="analyze6(state)" required country-dir/></td>
				<td>
					<span style="color:red" id="s_state" ng-show="myForm.state.$dirty && myForm.state.$invalid">
					<span ng-show="myForm.state.$error.required">State is required</span>
					<span ng-show="!myForm.state.$error.required && myForm.state.$error.countryvalid">Enter proper input</span>
					</span>
				</td>
			</tr>
			<tr>
				<td><label for="city">City</label></td>
				<td><input class="form-control" type="text" name="city" id="city" ng-model="city" ng-style="cityStyle"  ng-change="analyze7(city)" required country-dir/></td>
				<td>
					<span style="color:red" id="s_city" ng-show="myForm.city.$dirty && myForm.city.$invalid">
					<span ng-show="myForm.city.$error.required">City is required</span>
					<span ng-show="!myForm.city.$error.required && myForm.city.$error.countryvalid">Enter proper input</span>
					</span>
				</td>
			</tr>
			<tr>
				<td><label for="per_pin">Pincode</label></td>
				<td><input class="form-control" type="text" name="per_pin" id="per_pin" ng-model="per_pin" ng-style="pinStyle"  ng-change="analyze3(per_pin)" required pin-dir/></td>
				<td>
					<span style="color:red" id="s_per_pin" ng-show="myForm.per_pin.$dirty && myForm.per_pin.$invalid">
					<span ng-show="myForm.per_pin.$error.required">Pincode is required</span>
					<span ng-show="!myForm.per_pin.$error.required && myForm.per_pin.$error.pinvalid">Invalid pincode</span>
					</span>
				</td>
			</tr>
			<tr>
				<td><label for="gender">Gender</label></td>
				<td><select class="form-control" name="gender" ng-dropdown id="gender" ng-model="gender" ng-style="genderStyle"  ng-change="analyze4(gender)" required>
			 	<option
					ng-repeat="x in genderOptions" 
					ng-value="x">{{x}}</option>
				</select></td>
				<td>
					<span style="color:red" id="s_gender" ng-show="myForm.gender.$dirty && myForm.gender.$invalid">
					<span ng-show="myForm.gender.$error.required">required</span>
					</span>
				</td>
			</tr>
			<tr>
				<td><label for="dob">DOB</label></td>
				<td><input class="form-control" type="date" name="dob" id="dob" ng-model="dob" max="{{maxd}}" required /></td>
				<td>
					<span style="color:red" id="s_dob" ng-show="myForm.dob.$dirty && myForm.dob.$invalid">
					<span ng-show="myForm.dob.$error.required">DOB is required</span>
					</span>
				</td>
			</tr>
			<tr>
			<td id="status"></td>
			<td><input type="button" class="btn btn-success" ng-click="submit_form()" ng-disabled="myForm.postal_add.$invalid ||  myForm.perm_add.$invalid ||  myForm.country.$invalid ||  myForm.state.$invalid ||  myForm.city.$invalid ||  myForm.per_pin.$invalid ||  myForm.gender.$invalid ||  myForm.dob.$invalid " value="Submit"/></td>
			<td></td>
			</tr>
			</table>
		</div>
	</div>
	</form>
</div>

<script>
	
	<?php get_details_from_candidate(); ?>
	var check='<?php echo $gender; ?>';
	var myApp = angular.module("myapp", []);
	myApp.controller("BrijController", function($scope,$http) {
		$scope.genderOptions = [
				"Male","Female","Other"
			];
		$scope.maxd = new Date() ;
		if(check!='-99')
			{
				$scope.postal_add="<?php echo $postal_add; ?>";
				$scope.perm_add="<?php echo $perm_add; ?>";
				$scope.per_pin="<?php echo $per_pin; ?>";
				$scope.gender="<?php echo $gender; ?>";
				$scope.dob="<?php echo $dob; ?>";
				$scope.country="<?php echo $country; ?>";
				$scope.state="<?php echo $state; ?>";
				$scope.city="<?php echo $city; ?>";
			}
		$scope.gender="Male";
		$scope.address_fun = function() {
			if($scope.same_as)
				$scope.perm_add=$scope.postal_add;
			else
				$scope.perm_add="";
		};
		
				var patt1 = new RegExp("^[0-9a-zA-Z,/. ]+$");
				$scope.postaladdStyle = {
					"border-width":"1.45px"
                };
                $scope.analyze1 = function(value) {
                    if(patt1.test(value) && value.length > 10) {
                        $scope.postaladdStyle["border-color"] = "green";
                    }else {
                        $scope.postaladdStyle["border-color"] = "red";
                    }
                };
				var patt2 = new RegExp("^[0-9a-zA-Z,/. ]+$");
				$scope.permaddStyle = {
					"border-width":"1.45px"
                };
                $scope.analyze2 = function(value) {
                    if(patt2.test(value) && value.length > 10) {
                        $scope.permaddStyle["border-color"] = "green";
                    }else {
                        $scope.permaddStyle["border-color"] = "red";
                    }
                };
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
				$scope.genderStyle = {
					"border-width":"1.45px"
                };
                $scope.analyze4 = function(value) {
                    if(value!="")
					{
                        $scope.genderStyle["border-color"] = "green";
                    }else {
                        $scope.genderStyle["border-color"] = "red";
                    }
                };
				$scope.countryStyle = {
					"border-width":"1.45px"
                };
                $scope.analyze5 = function(value) {
                    if(/^[a-zA-Z]+$/.test(value))
					{
                        $scope.countryStyle["border-color"] = "green";
                    }else {
                        $scope.countryStyle["border-color"] = "red";
                    }
                };
		$scope.stateStyle = {
					"border-width":"1.45px"
                };
                $scope.analyze6 = function(value) {
                    if(/^[a-zA-Z]+$/.test(value))
					{
                        $scope.stateStyle["border-color"] = "green";
                    }else {
                        $scope.stateStyle["border-color"] = "red";
                    }
                };
		$scope.cityStyle = {
					"border-width":"1.45px"
                };
                $scope.analyze7 = function(value) {
                    if(/^[a-zA-Z]+$/.test(value))
					{
                        $scope.cityStyle["border-color"] = "green";
                    }else {
                        $scope.cityStyle["border-color"] = "red";
                    }
                };
			$scope.submit_form = function() {
							var c1=$scope.postal_add;
							var c2=$scope.perm_add;
							var c3=$scope.per_pin;
							var c4=$scope.gender;
							var c5=$scope.dob;
							var c6=$scope.country;
							var c7=$scope.state;
							var c8=$scope.city;
				
							c5=formatDate(c5);
							$http({
								method : "POST",
								url : "candidate_submit_per.php",
								data: "postal_add="+c1+"&perm_add="+c2+"&per_pin="+c3+"&gender="+c4+"&dob="+c5+"&country="+c6+"&state="+c7+"&city="+c8,
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
	
	function formatDate(date) {
    var d = new Date(date),
        month = '' + (d.getMonth() + 1),
        day = '' + d.getDate(),
        year = d.getFullYear();

    if (month.length < 2) month = '0' + month;
    if (day.length < 2) day = '0' + day;

    return [year, month, day].join('-');
	}
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
	myApp.directive('addDir', function() {
				return {
					require: 'ngModel',
					link: function(scope, element, attr, mCtrl) {
						function myValidation(value) {
							var patt = new RegExp("^[0-9a-zA-Z,/. ]+$");
							if (patt.test(value)) {
								mCtrl.$setValidity('addvalid', true);
							} else {
								mCtrl.$setValidity('addvalid', false);
							}
							return value;
						}
						mCtrl.$parsers.push(myValidation);
					}
				};
});
	myApp.directive('countryDir', function() {
				return {
					require: 'ngModel',
					link: function(scope, element, attr, mCtrl) {
						function myValidation(value) {
							var patt = new RegExp("^[a-zA-Z]+$");
							if (patt.test(value)) {
								mCtrl.$setValidity('countryvalid', true);
							} else {
								mCtrl.$setValidity('countryvalid', false);
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