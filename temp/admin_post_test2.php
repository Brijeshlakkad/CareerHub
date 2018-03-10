<?php
include_once('functions.php');
include_once("config.php");
include_once('index_header.php');
check_session();
?>
<div class="container-fluid well" id="show_here">
<div ng-app="myapp" ng-controller="BrijController">
<div class="row" align="center" id="entry_panel">
	<label><h3>Add a Test</h3></label>
	<form name="TestForm" method="post" novalidate>
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
			<td><input type="submit" ng-click="submit_part1()" id="submit_btn" value="Submit" class="btn btn-primary" ng-disabled="TestForm.t_title.$invalid ||  TestForm.t_course.$invalid ||  TestForm.t_subjects.$invalid" /></td>
			<td id="status"</td>
			<td></td>
		</tr>

	</table>
	</form>
</div>
<div class="row" id="questions_panel">
<div class="col-lg-offset-4 col-lg-4 col-lg-offset-4">
	<form name="QueForm" method="post" novalidate>
	<table class="myTable">
			<div class="form-group">
			<tr>
				<td><label for="question">Question?</label></td>
				<td>
				<textarea class="form-control" ng-model="que" name="que" id="que" ng-style="queStyle" ng-change="que_analyze(que)" cols="300" rows="2" required placeholder="Enter a question" ></textarea></td>
				<td>
					<span style="color:red" id="s_que" ng-show="QueForm.que.$dirty && QueForm.que.$invalid">
					<span ng-show="QueForm.que.$error.required">Question is required</span>
					</span>
				</td>
			</tr>
			</div>
			<div class="form-group">
			<tr>
				<td><label for="mcq1">MCQ 1</label></td>
				<td>
				<input class="form-control" ng-model="mcq1" name="mcq1" id="mcq1" ng-style="mcq1Style" ng-change="mcq1_analyze(mcq1)" required placeholder="Enter mcq1" /></td>
				<td>
					<span style="color:red" id="s_mcq1" ng-show="QueForm.mcq1.$dirty && QueForm.mcq1.$invalid">
					<span ng-show="QueForm.mcq1.$error.required">mcq1 is required</span>
					</span>
				</td>
			</tr>
			</div>
			<div class="form-group">
			<tr>
				<td><label for="mcq2">MCQ 2</label></td>
				<td>
				<input class="form-control" ng-model="mcq2" name="mcq2" id="mcq2" ng-style="mcq2Style" ng-change="mcq2_analyze(mcq2)" required placeholder="Enter mcq2" /></td>
				<td>
					<span style="color:red" id="s_mcq2" ng-show="QueForm.mcq2.$dirty && QueForm.mcq2.$invalid">
					<span ng-show="QueForm.mcq2.$error.required">mcq2 is required</span>
					</span>
				</td>
			</tr>
			</div>
			<div class="form-group">
			<tr>
				<td><label for="mcq3">MCQ 3</label></td>
				<td>
				<input class="form-control" ng-model="mcq3" name="mcq3" id="mcq3" ng-style="mcq3Style" ng-change="mcq3_analyze(mcq3)" required placeholder="Enter mcq3" /></td>
				<td>
					<span style="color:red" id="s_mcq3" ng-show="QueForm.mcq3.$dirty && QueForm.mcq3.$invalid">
					<span ng-show="QueForm.mcq3.$error.required">mcq3 is required</span>
					</span>
				</td>
			</tr>
			</div>
			<div class="form-group">
			<tr>
				<td><label for="mcq4">MCQ 4</label></td>
				<td>
				<input class="form-control" ng-model="mcq4" name="mcq4" id="mcq4" ng-style="mcq4Style" ng-change="mcq4_analyze(mcq4)" required placeholder="Enter mcq4" /></td>
				<td>
					<span style="color:red" id="s_mcq4" ng-show="QueForm.mcq4.$dirty && QueForm.mcq4.$invalid">
					<span ng-show="QueForm.mcq4.$error.required">mcq2 is required</span>
					</span>
				</td>
			</tr>
			</div>
			<div class="form-group">
			<tr>
				<td><label for="ans">Answer</label></td>
				<td>
				<select class="form-control" ng-model="ans" name="ans" id="ans" required>
				<option
				ng-repeat="x in ansOptions" 
				ng-value="x.val">{{x.name_c}}</option>
				</select></td>
				<td>
					<span style="color:red" id="s_ans" ng-show="QueForm.ans.$dirty && QueForm.ans.$invalid">
					<span ng-show="QueForm.ans.$error.required">answer is required</span>
					</span>
				</td>
			</tr>
			</div>
			<tr>
			</div>
			<td id="status"></td>
			<td><input type="button" class="btn btn-success" id="submit"  value="Add Question"/></td>
			<td></td>
			</tr>
	</table>
	</form>
</div>	
</div>
</div>
</div>
<div class="modal"></div>
<script>
$body = $("body");
$(document).on({
    ajaxStart: function() { $body.addClass("loading");    },
     ajaxStop: function() { $body.removeClass("loading"); }    
});
$(document).ready(function(){
	$('[data-toggle="tooltip"]').tooltip(); 
	$("#entry_panel").hide();
	$("#questions_panel").show();
	
});
	
	
	var myApp = angular.module("myapp",[]);
	myApp.controller("BrijController",function($scope,$http){
		$scope.t_courseOptions=[
		{val : "Information Technology",name_c:"Information Technology"},
		{val : "Computer Science", name_c : "Computer Science"},
		{val : "Mechanical Engineering", name_c : "Mechanical Engineering"},
		{val : "Civil Engineering", name_c : "Civil Engineering"}
		];
		$scope.ansOptions=[
		{val : "1",name_c:"MCQ1"},
		{val : "2", name_c : "MCQ2"},
		{val : "3", name_c : "MCQ3"},
		{val : "4", name_c : "MCQ4"}
		];
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
		$scope.subjectStyle = {
			"border-width":"1.45px"
		};
		$scope.analyze2 = function(value) {
			if(value.length>0) {
				$scope.subjectStyle["border-color"] = "green";
			}else {
				$scope.subjectStyle["border-color"] = "red";
			}
		};
		
		$scope.queStyle = {
			"border-width":"1.45px"
		};
		$scope.que_analyze = function(value) {
			if(value.length===0 || typeof $scope.que === 'undefined') {
				$scope.queStyle["border-color"] = "red";
			}else {
				$scope.queStyle["border-color"] = "green";
			}
		};
		
		$scope.mcq1Style = {
			"border-width":"1.45px"
		};
		$scope.mcq1_analyze = function(value) {
			if(value.length===0 || typeof(value) === 'undefined') {
				$scope.mcq1Style["border-color"] = "red";
			}else {
				$scope.mcq1Style["border-color"] = "green";
			}
		};
		$scope.mcq2Style = {
			"border-width":"1.45px"
		};
		$scope.mcq2_analyze = function(value) {
			if(value.length===0 || typeof(value) === 'undefined') {
				$scope.mcq2Style["border-color"] = "red";
			}else {
				$scope.mcq2Style["border-color"] = "green";
			}
		};
		$scope.mcq3Style = {
			"border-width":"1.45px"
		};
		$scope.mcq3_3analyze = function(value) {
			if(value.length===0 || typeof(value) === 'undefined') {
				$scope.mcq3Style["border-color"] = "red";
			}else {
				$scope.mcq3Style["border-color"] = "green";
			}
		};
		$scope.mcq4Style = {
			"border-width":"1.45px"
		};
		$scope.mcq4_analyze = function(value) {
			if(value.length===0 || typeof(value) === 'undefined') {
				$scope.mcq4Style["border-color"] = "red";
			}else {
				$scope.mcq4Style["border-color"] = "green";
			}
		};
		
		$scope.submit_part1=function()
		{
		var parid=$("div.brij").attr("id");
		var title=$("#t_title").val();
		var course=$scope.t_course;
		var subjects=$("#t_subjects").val();
		var x=new XMLHttpRequest();
		x.onreadystatechange=function(){
			
			if(x.readyState==4 && x.status==200)
			{
				var data=this.responseText;
				if(data!="-1")
				{
					$("#status").empty();
					$("#entry_panel").hide(1000);
					$("#questions_panel").show(1000);
				}
				else
					$("#status").html("<span style='color:red;'>Error! Try agian..</span>");
							
			}
		};
		x.open("POST","post_test_part1.php",true);
		x.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		x.send("title="+title+"&parid="+parid+"&course="+course+"&subjects="+subjects);
		}
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
</body>
</html>