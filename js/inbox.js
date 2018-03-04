$(document).ready(function () {
   	var add_this_script=function(){
		var $chatOutput = $("#chatOutput");
		var $chatRefresh = $("#chat_refresh");
		var $mesDeleteAll= $("#message_all_delete");
		var delete_all_mes=function(){
			var parid=$("div.brij").attr('id');
			$.ajax({
				type: 'POST', 
				url: 'candidate_reload_mess.py',
				data: 'delete_all_mess='+parid,
				success  : function (data)
				{
					$chatOutput.html(data);
				}
				});
		}
		var retrieveMessages=function() {
			var parid=$("div.brij").attr('id');
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
		$mesDeleteAll.click(function(){
			var r = confirm("Are you sure??");
			if (r == true) {
				delete_all_mes();
			} else {
				
			}
			
		});
	};
	add_this_script();
});