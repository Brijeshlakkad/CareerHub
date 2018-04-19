<?php
include_once('functions.php');
include_once("config.php");
include_once('candidate_details.php');
include_once('index_header.php');
check_session();
get_details_from_candidate();
?>

<div class="container-fluid well" id="inbox_show">
<div class="row">
	<div class="col-sm-3">
	<br/>
		<select id="inbox_filter" name="inbox_filter" class="form-control">
			<option value="all">All</option>
			<option value="offer">Offers</option>
			<option value="request">Requests</option>
		</select>
	</div>
	<div class="col-sm-6">
		<div id="mess_success" class="alert alert-success hide"></div>
			<div class="header" align="center">
				<h1>Inbox</h1><button class="btn btn-primary"  id="chat_refresh"><span class="glyphicon glyphicon-refresh"></span></button>
			</div>
	</div>
	<div class="col-sm-3">
		<div class="row pull-right" style="margin-right: 5px;">
		<button class="btn btn-primary"  id="message_all_delete">Clear all <span class="glyphicon glyphicon-trash"></span></button>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-sm-1"></div>
	<div class="col-sm-10">
		<div id="chatOutput"></div>
	</div>
	<div class="col-sm-1">
		
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
	
var delete_mes=function(pid)
	{
			$.ajax({
				type: 'POST', 
				url: 'candidate_interface.py',
				data: 'mess_delete='+pid,
				success  : function (data)
				{
					$(document).ajaxStop(function(){
						if(data==1)
						{
							$("#mess_success").html('Message deleted.').removeClass("hide").show().fadeOut(1000);
							data=0;
						}
					});
				}
			});
	};
</script>
</body>
</html>