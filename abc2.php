<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Login to CareerHub</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
	<link href="css/brij.css" rel="stylesheet">
	<script src="js/jquery.min.js"></script>
	<script src="js/angular.js"></script>
	<script src="js/bootstrap.min.js"></script>
	
</head>
<body>
<div class="container well login_block" align="center">
	<div class="row center-block ">
		<div><caption><img src="Images/career-hub-logo.png" class="img-responsive" style="margin-top:10px;width:250px;height:60px;float:center;filter:drop-shadow(0px 0px 3px #ffffff);"/></caption></div>
	</div>
	<div class="row">
		<form ng-app="myapp" ng-controller="BrijController" name="myForm" action="candidate_signup_data.py" novalidate>
			<table class="myTable">
			<div class="form-group">
			<tr>
			<td><label for="s_user">Username:</label><br></td>
			<td><input type="text" class="form-control" name="s_user" placeholder="Enter Username" ng-model="s_user"  ng-style="userStyle" ng-change="analyze4(s_user)" required  user-dir></td>
			<td>
			<span style="color:red" id="s_user" ng-show="myForm.s_user.$dirty && myForm.s_user.$invalid">
			<span ng-show="myForm.s_user.$error.required">Username is required</span>
			<span ng-show="!myForm.s_user.$error.required && myForm.s_user.$error.uservalid">Enter more than 3 characters</span>
			</span>
			</td>
			</tr>
			</div>
			<div class="form-group">
			<tr>
			<td><label for="s_email">Email:</label><br></td>
			<td><input type="email" class="form-control" name="s_email" placeholder="Enter Email" ng-model="s_email" ng-style="emailStyle" ng-change="analyze5(s_email)" required email-dir></td>
			<td>
			<span style="color:red" id="s_email" ng-show="myForm.s_email.$dirty && myForm.s_email.$invalid">
			<span ng-show="myForm.s_email.$error.required">Email is required</span>
			<span ng-show="myForm.s_email.$error.email">Invalid email address</span>
			<span ng-show="!myForm.s_email.$error.required && !myForm.s_email.$error.email && myForm.s_email.$error.emailexists">Email already exists</span>
			</span>
			</td>
			</tr>
			</div>
			<div class="form-group">
			<tr>
			<td><label for="s_password">Password:</label><br></td>
			<td><input  type="password" class="form-control" name="s_password" placeholder="Enter Password"  ng-model="s_password" ng-style="passwordStrength" ng-change="analyze(s_password)" required pass-dir></td>
			<td><a class="badge my_badge" data-toggle="tooltip" data-placement="top" title="Password should contain at least one number, at least one small character and at least one capital character">?</a>
			<span style="color:red" id="s_password" ng-show="myForm.s_password.$dirty && myForm.s_password.$invalid">
			<span ng-show="myForm.s_password.$error.required">Password is required</span>
			<span ng-show="!myForm.s_password.$error.required && myForm.s_password.$error.passvalid">Invalid Password</span>
			</span>
			</td>
			</tr>
			</div>
			<div class="form-group">
			<tr>
			<td><label for="s_cpassword">Confirm Password:</label><br></td>
			<td><input ng-disabled="!myForm.s_password.$valid" type="password" class="form-control" name="s_cpassword" placeholder="Enter Confirm Password"  ng-model="s_cpassword" ng-style="cpassStyle" ng-change="analyze2(s_cpassword,s_password)" onkeyup="check_pass(this.value)" required cpass-dir></td>
			<td>
			<span style="color:red" id="s_cpassword" ng-show="myForm.s_cpassword.$dirty">
			<span ng-show="myForm.s_cpassword.$error.required && myForm.s_cpassword.$invalid">Password is required.</span>
			</span>
			</td>
			</tr>
			</div>
			<div class="form-group">
			<tr>
			<td><label for="s_mobile">Phone number:</label><br></td>
			<td><input  type="text" class="form-control" name="s_mobile" placeholder="Enter Phone number" ng-style="mobStyle" ng-model="s_mobile" ng-change="analyze3(s_mobile)" required mobile-dir></td>
			<td>
			<span style="color:red" id="s_mobile" ng-show="myForm.s_mobile.$dirty && myForm.s_mobile.$invalid">
			<span ng-show="myForm.s_mobile.$error.required">Phone number is required.</span>
			<span ng-show="!myForm.s_mobile.$error.required && myForm.s_mobile.$error.mobvalid">Invalid</span>
			</span>
			</td>
			</tr>
			</div>
			<tr>
			<p>
			<td><input type="submit" onClick="check_details()" class="btn btn-primary" ng-disabled="myForm.s_user.$invalid ||  myForm.s_email.$invalid ||  myForm.s_password.$invalid ||  myForm.s_cpassword.$invalid ||   myForm.s_mobile.$invalid"></td>
			<td id="status"></td>
			<td></td>
			</p>
			</tr>
			<tr>
				<td>
					<a class="alert-link" href="candidate.php" >have a account?</a>
				</td>
				<td><input type="button" onClick="check_details()" value="check"/></td>
				<td></td>
			</tr>
			</table>
			</form>
	</div>
</div>

<script>
	
	var myApp = angular.module("myapp", []);
	myApp.controller("BrijController", function($scope) {
                var strongRegex = new RegExp("^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{8,})");
                var mediumRegex = new RegExp("^(((?=.*[a-z])(?=.*[A-Z]))|((?=.*[a-z])(?=.*[0-9]))|((?=.*[A-Z])(?=.*[0-9])))(?=.{6,})");
                $scope.passwordStrength = {
					"border-width":"1.45px"
                };
                $scope.analyze = function(value) {
                    if(strongRegex.test(value)) {
                        $scope.passwordStrength["border-color"] = "green";
                    } else if(mediumRegex.test(value)) {
                        $scope.passwordStrength["border-color"] = "orange";
                    } else {
                        $scope.passwordStrength["border-color"] = "red";
                    }
                };
		
				var patt = new RegExp("^[0-9]{10}$");
				$scope.mobStyle = {
					"border-width":"1.45px"
                };
                $scope.analyze3 = function(value) {
                    if(patt.test(value)) {
                        $scope.mobStyle["border-color"] = "green";
                    }else {
                        $scope.mobStyle["border-color"] = "red";
                    }
                };
		
				$scope.cpassStyle = {
					"border-width":"1.45px"
                };
                $scope.analyze2 = function(value1,value2) {
                    if(value1 == value2 && value2.length!=0) {
                        $scope.cpassStyle["border-color"] = "green";
                    }
					else {
                        $scope.cpassStyle["border-color"] = "red";
                    }
                };
		
				$scope.userStyle = {
					"border-width":"1.45px"
                };
                $scope.analyze4 = function(value) {
                    if(value.length>3) {
                        $scope.userStyle["border-color"] = "green";
						
                    } 
					else {
                        $scope.userStyle["border-color"] = "red";
                    }
                };
				
				$scope.emailStyle = {
					"border-width":"1.45px"
                };
                $scope.analyze5 = function(value) {
					var patt2=new RegExp("^[a-z0-9._]+@[a-z]+\.[a-z.]{2,5}$");
                    if(patt2.test(value)) {
						$scope.emailStyle["border-color"] = "green";
                    } 
					else {
                        $scope.emailStyle["border-color"] = "red";
                    }
                };

});
	
myApp.directive('emailDir', function($http) {
				return {
					require: 'ngModel',
					link: function(scope, element, attr, mCtrl) {
						function myValidation(value) {
							var flag;
							$http({
								method : "GET",
								url : "check_exists.php?email="+value
							}).then(function mySuccess(response) {
								flag = response.data;
							}, function myError(response) {
								flag=1;
							});
							if(flag==0)
								mCtrl.$setValidity('emailexists', true);
							else
								mCtrl.$setValidity("emailexists", false);
							return value;
						}
						mCtrl.$parsers.push(myValidation);
					}
				};
});
myApp.directive('userDir', function() {
				return {
					require: 'ngModel',
					link: function(scope, element, attr, mCtrl) {
						function myValidation(value) {
							if (value.length>3) {
								mCtrl.$setValidity('uservalid', true);
							} else {
								mCtrl.$setValidity('uservalid', false);
							}
							return value;
						}
						mCtrl.$parsers.push(myValidation);
					}
				};
});
myApp.directive('mobileDir', function() {
				return {
					require: 'ngModel',
					link: function(scope, element, attr, mCtrl) {
						function myValidation(value) {
							var patt = new RegExp("^[0-9]{10}$");
							if (patt.test(value)) {
								mCtrl.$setValidity('mobvalid', true);
							} else {
								mCtrl.$setValidity('mobvalid', false);
							}
							return value;
						}
						mCtrl.$parsers.push(myValidation);
					}
				};
});
myApp.directive('passDir', function() {
				return {
					require: 'ngModel',
					link: function(scope, element, attr, mCtrl) {
						function myValidation(value) {
							var patt=new RegExp("^(((?=.*[a-z])(?=.*[A-Z]))|((?=.*[a-z])(?=.*[0-9]))|((?=.*[A-Z])(?=.*[0-9])))(?=.{6,})");
							if (patt.test(value)) {
								mCtrl.$setValidity('passvalid', true);
							} else {
								mCtrl.$setValidity('passvalid', false);
							}
							return value;
						}
						mCtrl.$parsers.push(myValidation);
					}
				};
});
function check_pass(cpass)
	{
		var pass=myForm.s_password.value;
		
		if(pass!=cpass && cpass!="")
			$("#s_cpassword").html("Passwords do not match");
		else if(cpass=="")
			$("#s_cpassword").html("Password is required");
		else
			$("#s_cpassword").html("");
	}
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();   
});
</script>
</body>
</html>