<?php
include_once('functions.php');
include_once('institute_header.php');
include_once('institute_functions.php');
check_session(); 
get_details_from_institute();
?>
<div class="w3-container">
<div class="container-fluid well" id="profile_visits_show">
<div class="row" align="center">
	<div class="col-sm-3">
	</div>
	<div class="col-sm-6">
		<div id="visits_success" class="alert alert-success hide"></div>
			<div class="header">
				<h2>Profile Visits <span id="visitsTotalCount" class="badge"></span></h2><button class="btn btn-primary"  id="visits_refresh"><span class="glyphicon glyphicon-refresh"></span></button>
			</div>
	</div>
	<div class="col-sm-3">
		<div class="row pull-right" style="margin-right: 5px;">
		<button class="btn btn-primary"  id="visits_all_delete">Clear all <span class="glyphicon glyphicon-trash"></span></button>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-sm-1"></div>
	<div class="col-sm-10">
		<div class="row" style="margin: 10px;font-size: 20px;"><img src="Images/insight.png" width="50" alt="Insights" />
		<span style="color:#848080">Impressions</span> <strong><span id="total_impressions"></span></strong></div>
		<div class="row"><div id="visitsOutput"></div></div>
	</div>
	<div class="col-sm-1">
		
	</div>
</div>
</div>
</div>
<div class="please_wait_modal"></div>
<script>
$body = $("body");
$(document).on({
    ajaxStart: function() { $body.addClass("loading");    },
     ajaxStop: function() { $body.removeClass("loading"); }    
});
var delete_visit=function(visitid)
	{
			$.ajax({
				type: 'POST', 
				url: 'institute_interface.py',
				data: 'visit_delete='+visitid,
				success  : function (data)
				{
					$(document).ajaxStop(function(){
						if(data==1)
						{
							$("#visits_success").html('Visit(s) deleted.').removeClass("hide").show().fadeOut(1000);
							data=0;
							$("#visits_refresh").click();
						}
					});
				}
			});
	};
</script>
<?php require_once('institute_footer.php');?>