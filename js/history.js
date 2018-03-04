$(document).ready(function () {
   	var add_this_script=function(){
		var $historyOutput = $("#historyOutput");
		var $historyRefresh = $("#history_refresh");
		var $historyDeleteAll= $("#history_all_delete");
		var delete_all_hist=function(){
			var parid=$("div.brij").attr('id');
			$.ajax({
				type: 'POST', 
				url: 'candidate_reload_history.py',
				data: 'delete_all_hist='+parid,
				success  : function (data)
				{
					$historyOutput.html(data);
				}
				});
		}
		var retrieveHistory=function() {
			var parid=$("div.brij").attr('id');
			$.ajax({
				type: 'POST', 
				url: 'candidate_reload_history.py',
				data: 'id='+parid,
				success  : function (data)
				{
					$historyOutput.html(data);
				}
				});
		};
		
		$historyDeleteAll.click(function(){
			var r = confirm("Are you sure??");
			if (r == true) {
				delete_all_hist();
			} else {
				
			}
			
		});
		retrieveHistory();
		$historyRefresh.click(function () {
			retrieveHistory();
		});	
	};
	add_this_script();
});