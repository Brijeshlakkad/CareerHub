<?php
include_once('functions.php');
include_once("config.php");
include_once('index_header.php');
check_session();
?>
<style>
.fond{position:absolute}

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
<div class="container-fluid well" id="show_here fond">
<div class="row">
	<div class="col-lg-offset-2 col-lg-8">
		<div class="test_header">
            <h2>Tests <span id="total_num" class="badge"></span></h2>
        </div>
        <div id="testOutput" style="margin-top:35px;"></div>
	</div>
	<div class="col-lg-2"><button class="btn btn-primary"  id="test_refresh">Tests <span class="glyphicon glyphicon-refresh"></span></button></div>
</div>
</div>
<script>
function show_questions(showid)
{
	var testOutput = $("#testOutput");
	$.ajax({
		type: 'POST', 
		url: 'submit_test_and_questions.py',
		data: 'questions_reload='+showid,
		success  : function (data)
		{
			testOutput.html(data);
		}
	});
}
</script>
</body>
</html>