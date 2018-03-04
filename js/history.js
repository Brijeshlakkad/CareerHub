$(document).ready(function () {
   	var add_this_script=function(){
		var $historyOutput = $("#historyOutput");
		var $historyRefresh = $("#history_refresh");
		var $historyDeleteAll= $("#history_all_delete");
		var $histTotalShow=$("#hist_show_total");
		var delete_all_hist=function(){
			var parid=$("a.brij").attr('id');
			$.ajax({
				type: 'POST', 
				url: 'history_and_inbox.py',
				data: 'delete_all_hist='+parid,
				success  : function (data)
				{
					$historyOutput.html(data);
				}
				});
		};
		var retrieveHistory=function() {
			var parid=$("a.brij").attr('id');
			$.ajax({
				type: 'POST', 
				url: 'history_and_inbox.py',
				data: 'hist_reload='+parid,
				success  : function (data)
				{
					$historyOutput.html(data);
				}
				});
		};
		var hist_total_cal =function(){
			var parid=$("a.brij").attr('id');
			$.ajax({
				type: 'POST', 
				url: 'history_and_inbox.py',
				data: 'hist_total='+parid,
				success  : function (data)
				{
					$histTotalShow.html(data);
				}
				});
		};
		hist_total_cal();
		$historyDeleteAll.click(function(){
			var r = confirm("Are you sure??");
			if (r == true) {
				delete_all_hist();
			} else {
				
			}
			
		});
		retrieveHistory();
		var requestInterval=500;
		setInterval(function () {
			hist_total_cal();
    	}, requestInterval);
		$historyRefresh.click(function () {
			retrieveHistory();
		});
	};
	add_this_script();
});