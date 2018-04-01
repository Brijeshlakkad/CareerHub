<?php
include_once('functions.php');
include_once('institute_header.php');
include_once('institute_functions.php');
check_session();
get_details_from_institute();
?>
<div class="w3-container">
<div class="container-fluid well" id="inbox_show">
<div class="row" align="center">
	<div class="col-lg-offset-2 col-lg-8">
		<div id="mess_success" class="alert alert-success hide"></div>
			<div class="header">
				<h1>Inbox</h1><button class="btn btn-primary"  id="chat_refresh"><span class="glyphicon glyphicon-refresh"></span></button>
			</div>
			<div id="chatOutput" style="margin:10px;"></div>
	</div>
	<div class="col-lg-2">
		<button class="btn btn-primary"  id="message_all_delete">Clear all <span class="glyphicon glyphicon-trash"></span></button>
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
var delete_mes=function(pid)
	{
			$.ajax({
				type: 'POST', 
				url: 'institute_interface.py',
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
<?php require_once('institute_footer.php');?>