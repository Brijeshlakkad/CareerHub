$(document).ready(function () {
   	var add_this_script=function(){
		var $chatOutput = $("#chatOutput");
		var $chatRefresh = $("#chat_refresh");
		var $mesDeleteAll= $("#message_all_delete");
		var $messTotalShow=$("#mess_show_total");
		var delete_all_mes=function(){
			var parid=$("a.brij").attr('id');
			$.ajax({
				type: 'POST', 
				url: 'history_and_inbox.py',
				data: 'delete_all_mess='+parid,
				success  : function (data)
				{
					$chatOutput.html(data);
				}
				});
		};
		var retrieveMessages=function() {
			var parid=$("a.brij").attr('id');
			$.ajax({
				type: 'POST', 
				url: 'history_and_inbox.py',
				data: 'mess_reload='+parid,
				success  : function (data)
				{
					$chatOutput.html(data);
				}
				});
		};
		var mess_total_cal =function(){
			var parid=$("a.brij").attr('id');
			$.ajax({
				type: 'POST', 
				url: 'history_and_inbox.py',
				data: 'mess_total='+parid,
				success  : function (data)
				{
					$messTotalShow.html(data);
				}
				});
		};
		mess_total_cal();
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
		var requestInterval=500;
		setInterval(function () {
			mess_total_cal();
    	}, requestInterval);
	};
	add_this_script();
});