$(document).ready(function () {
   	var add_this_script=function(){
		var $chatOutput = $("#chatOutput");
		var $chatRefresh = $("#chat_refresh");
		var retrieveMessages=function() {
		var parid=$("#chat_refresh").closest('div').attr('id');
			$.ajax({
				type: 'POST', 
				url: 'candidate_reload_mess.py',
				data: 'id='+parid,
				success  : function (data)
				{
					$chatOutput.html(data);
				}
				});
		};
		retrieveMessages();
		$chatRefresh.click(function () {
			retrieveMessages();
		});	
	};
	add_this_script();
});