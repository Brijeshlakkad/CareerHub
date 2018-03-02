<?php include("links.php"); ?>
<body>
<div class="container well login_block" align="center">
	<div class="row center-block ">
		<div><caption><a href="index.php"><img src="Images/career-hub-logo.png" class="img-responsive" style="margin-top:10px;width:250px;height:60px;float:center;filter:drop-shadow(0px 0px 3px #ffffff);"/></a></caption></div>
	</div>
	<div class="row">
		<form ng-app="myapp" ng-controller="BrijController" name="myForm"  novalidate>
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
			<td><input type="email" class="form-control" name="s_email" placeholder="Enter Email" ng-model="s_email" ng-style="emailStyle" ng-change="analyze5(s_email)" onKeyUp="check_exists(this.value)" onBlur="check_exists(this.value)" required></td>
			<td>
			<span style="color:red" id="s_email" ng-show="myForm.s_email.$dirty">
			</span>
			</td>
			</tr>
			</div>
			<div class="form-group">
			<tr>
			<td><label for="s_password">Password:</label><br></td>
			<td><input  type="password" class="form-control" name="s_password" placeholder="Enter Password"  ng-model="s_password" ng-style="passwordStrength" ng-change="analyze(s_password)" required pass-dir></td>
			<td><a class="badge my_badge" data-toggle="tooltip" data-placement="top" title="Password should contain at least one number and at least one character">?</a>
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
			<td><label for="s_mobile">Contact number:</label><br></td>
			<td><input  type="text" class="form-control" name="s_mobile" placeholder="Enter Phone number" ng-style="mobStyle" ng-model="s_mobile" ng-change="analyze3(s_mobile)" required mobile-dir></td>
			<td>
			<span style="color:red" id="s_mobile" ng-show="myForm.s_mobile.$dirty && myForm.s_mobile.$invalid">
			<span ng-show="myForm.s_mobile.$error.required">Contact number is required.</span>
			<span ng-show="!myForm.s_mobile.$error.required && myForm.s_mobile.$error.mobvalid">Invalid contact number</span>
			</span>
			</td>
			</tr>
			</div>
			<tr>
			<p>
			<td><input type="submit" onClick="check_details()" id="submit_btn" value="Submit" class="btn btn-primary" ng-disabled="myForm.s_user.$invalid ||  myForm.s_email.$invalid ||  myForm.s_password.$invalid ||  myForm.s_cpassword.$invalid ||   myForm.s_mobile.$invalid" /></td>
			<td id="status"><img src="images/loading_spinner.gif" id="spinner" style="height:30px;width:30px;" alt="Loading" /></td>
			<td></td>
			</p>
			</tr>
			<tr>
				<td>
					<a class="alert-link" href="candidate.php" >have a account?</a>
				</td>
				<td></td>
				<td></td>
			</tr>
			</table>
			</form>
	</div>
</div>

<script>
	
	var myApp = angular.module("myapp", []);
	myApp.controller("BrijController", function($scope,$http) {
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
                        
						var flag=1;
							$http({
								method : "POST",
								url : "check_exists.php",
								data: "f=s_email&q="+value,
								headers: {'Content-Type': 'application/x-www-form-urlencoded'}
							}).then(function mySuccess(response) {
								flag = response.data;
								// we should be using flag in only this block so logic in following
								if(flag==0)
									$scope.emailStyle["border-color"] = "green";
								else
									$scope.emailStyle["border-color"] = "red";
							}, function myError(response) {
								
							});
						
                    } 
					else {
                        $scope.emailStyle["border-color"] = "red";
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
function check_exists(email)
	{
				var x=new XMLHttpRequest();
				x.onreadystatechange=function()
				{
					if(x.readyState==4 && x.status==200)
						{
							var data=this.responseText;
							if(data!=0)
								$("#s_email").html(data);
							else
								$("#s_email").html("");
						}
				};
				x.open("POST","check_exists.php",true);
				x.setRequestHeader("Content-type","application/x-www-form-urlencoded");
				x.send("f=s_email&q="+email);
	}
function check_details()
	{
		var password=myForm.s_password.value;
		var mobile=myForm.s_mobile.value;
		var user=myForm.s_user.value;
		var email=myForm.s_email.value;
		var x=new XMLHttpRequest();
				x.onreadystatechange=function()
				{
					if(x.readyState<4)
						{
							$("#spinner").show();
						}
					if(x.readyState==4 && x.status==200)
						{
							var data=this.responseText;
							if(data==1)
							{
								$("#spinner").hide();
								$("#status").html("<span style='color:green;'>You have registered successfully.</span>");
							}
							
						}
				};
				x.open("POST","candidate_signup_data.py",true);
				x.setRequestHeader("Content-type","application/x-www-form-urlencoded");
				x.send("s_user="+user+"&s_email="+email+"&s_password="+password+"&s_mobile="+mobile);
		
	}
$(document).ready(function(){
	$('[data-toggle="tooltip"]').tooltip(); 
	
	$("#spinner").hide();
});
</script>
</body>
</html>