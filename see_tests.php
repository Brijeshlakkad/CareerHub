<?php
include_once('functions.php');
include_once("config.php");
include_once('index_header.php');
check_session();
?>
<style>
.style_prevu_kit
{
    border:0;
    position: relative;
    -webkit-transition: all 100ms ease-in;
    -webkit-transform: scale(1); 
    -ms-transition: all 100ms ease-in;
    -ms-transform: scale(1); 
    -moz-transition: all 100ms ease-in;
    -moz-transform: scale(1);
    transition: all 100ms ease-in;
    transform: scale(1);   

}
.style_prevu_kit:hover
{
    box-shadow: 0px 0px 100px #000000;
    z-index: 2;
    -webkit-transition: all 100ms ease-in;
    -webkit-transform: scale(1.3);
    -ms-transition: all 100ms ease-in;
    -ms-transform: scale(1.3);   
    -moz-transition: all 100ms ease-in;
    -moz-transform: scale(1.3);
    transition: all 100ms ease-in;
    transform: scale(1.3);
}
</style>
<div class="container-fluid well" id="show_here">
<div class="row">
	<div class="col-lg-offset-2 col-lg-8">
		<div id="test_success" class="alert hide"></div>
		<div class="test_header">
            <h2><span id="header_name">Tests</span> <span id="total_num" class="badge"></span></h2>
        </div>
        <div id="testOutput" style="margin-top:35px;"></div>
	</div>
	<div class="col-lg-2"><button class="btn btn-primary"  id="test_refresh"><span id="refresh_name" >Tests</span> <span class="glyphicon glyphicon-refresh"></span></button></div>
</div>
</div>
<script>
var ttid="-99";
	var testRefresh = $("#test_refresh");
	testRefresh.click(function () {
			var cont=$("#refresh_name").html();
			if(cont=="Questions" && ttid!="-99")
				{
					show_questions(ttid);
				}
	});
function show_questions(showid)
{
	ttid=showid;
	var testOutput = $("#testOutput");
	$.ajax({
		type: 'POST', 
		url: 'submit_test_and_questions.py',
		data: 'questions_reload='+showid,
		success  : function (data)
		{
			total_num_questions(showid);
			testOutput.html(data);
		}
	});
}
function total_num_questions(testid)
	{
		$.ajax({
		type: 'POST', 
		url: 'submit_test_and_questions.py',
		data: 'total_que_num='+testid,
		success  : function (data)
		{
			if(data!=-1)
				{
					$("#header_name").html("Questions");
					$("#refresh_name").html("Questions");
					$("#total_num").html(data);
				}
		}
		});
	}
function remove_test(testid)
{
	$.ajax({
		type: 'POST', 
		url: 'submit_test_and_questions.py',
		data: 'remove_test='+testid,
		success  : function (data)
		{
			if(data==1)
				{
					$("#test_success").addClass("alert-success").html('Test deleted successfully.').removeClass("hide").show("slow").fadeOut("slow");
					location.reload();
				}
			else
				{
					$("#test_success").addClass("alert-danger").html('Please try again later!').removeClass("hide").show("slow").fadeOut("slow");
				}
		}
	});
}
function remove_que(queid,testid)
{
	$.ajax({
		type: 'POST', 
		url: 'submit_test_and_questions.py',
		data: 'remove_que='+queid+"&test_id="+testid,
		success  : function (data)
		{
			if(data==1)
				{
					$("#test_success").addClass("alert-success").html('Question is deleted successfully.').removeClass("hide").show("slow").fadeOut("slow");
				}
			else
				{
					$("#test_success").addClass("alert-danger").html('Please try again later!').removeClass("hide").show("slow").fadeOut("slow");
				}
		}
	});
}
</script>
</body>
</html>