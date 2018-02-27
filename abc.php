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
			<span ng-show="myForm.s_user.$invalid">Invalid</span>
			</span>
			</td>
			</tr>
			</div>
			<div class="form-group">
			<tr>
			<td><label for="s_email">Email:</label><br></td>
			<td><input type="email" class="form-control" name="s_email" placeholder="Enter Email" ng-model="s_email" required></td>
			<td>
			<span style="color:red" id="s_email" ng-show="myForm.s_email.$dirty && myForm.s_email.$invalid">
			<span ng-show="myForm.s_email.$error.required">Email is required.</span>
			<span ng-show="myForm.s_email.$error.email">Invalid email address.</span>
			</span>
			</td>
			</tr>
			</div>
			<div class="form-group">
			<tr>
			<td><label for="s_password">Password:</label><br></td>
			<td><input  type="password" class="form-control" name="s_password" placeholder="Enter Password"  ng-model="s_password" ng-style="passwordStrength" ng-change="analyze(s_password)" required></td>
			<td></td>
			</tr>
			</div>
			<div class="form-group">
			<tr>
			<td><label for="s_cpassword">Confirm Password:</label><br></td>
			<td><input type="password" class="form-control" name="s_cpassword" placeholder="Enter Confirm Password"  ng-model="s_cpassword" ng-style="cpassStyle" ng-change="analyze2(s_cpassword,s_password)" required></td>
			<td><span style="color:red" id="s_cpassword" ng-show="myForm.s_cpassword.$invalid">
				<span ng-bind="s_cpassvalid"></span>
			</span>
			</td>
			</tr>
			</div>
			<div class="form-group">
			<tr>
			<td><label for="s_mobile">Phone number:</label><br></td>
			<td><input  type="text" class="form-control" name="s_mobile" placeholder="Enter Phone number" ng-style="mobStyle" ng-model="s_mobile" ng-change="analyze3(s_mobile)" required mobile-dir></td>
			<td>
			<span style="color:red" id="s_user" ng-show="myForm.s_mobile.$dirty && myForm.s_mobile.$invalid">
			<span ng-show="myForm.s_mobile.$invalid">Invalid</span>
			</span>
			</td>
			</tr>
			</div>
			<tr>
			<p>
			<td><input type="submit" onClick="check_details()" class="btn btn-primary" ng-disabled="myForm.s_user.$dirty && myForm.s_user.$invalid ||  myForm.s_email.$dirty && myForm.s_email.$invalid ||  myForm.s_password.$dirty && myForm.s_password.$invalid ||  myForm.s_cpassword.$dirty && myForm.s_cpassword.$invalid ||  myForm.s_mobile.$dirty && myForm.s_mobile.$invalid"></td>
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
                    if(value1 == value2 && value1!="") {
                        $scope.cpassStyle["border-color"] = "green";
                    }else if(value1==""){
						$scope.s_cpassvalid="Enter Password";
					}
					else {
                        $scope.cpassStyle["border-color"] = "red";
						$scope.s_cpassvalid="Passwords do not match";
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
				

});
myApp.directive('userDir', function() {
				return {
					require: 'ngModel',
					link: function(scope, element, attr, mCtrl) {
						function myValidation(value) {
							if (value.length>3) {
								mCtrl.$setValidity('charE', true);
							} else {
								mCtrl.$setValidity('charE', false);
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
								mCtrl.$setValidity('charE', true);
							} else {
								mCtrl.$setValidity('charE', false);
							}
							return value;
						}
						mCtrl.$parsers.push(myValidation);
					}
				};
});
function signup(val,field)
	{
		
		if(field=="s_cpassword")
			{
				var pass=myForm.s_password.value;
				if(val != pass)
					document.getElementById(field).innerHTML="Passwords do not match";
				else
					document.getElementById(field).innerHTML="";
			}
		else
		{
		var x=new XMLHttpRequest();
		x.onreadystatechange=function(){
			if(this.readyState==4 && this.status==200)
				{
					document.getElementById(field).innerHTML=this.responseText;
				}
		};
		x.open("GET","ajax_signup_validation.php?q="+val+"&f="+field);
		x.send();
		}
	}
	function check_details()
	{
		var password=myForm.s_password.value;
		var mobile=myForm.s_mobile.value;
		var user=myForm.s_user.value;
		var email=myForm.s_email.value;
		signup(user,"s_user");
		signup(email,"s_email");
		signup(password,"s_password");
		signup(mobile,"s_mobile");
	}
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();   
});
</script>
</body>
</html>