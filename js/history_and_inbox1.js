$(document).ready(function () {
   	var add_inbox_script=function(){
		var $chatOutput = $("#chatOutput");
		var $chatRefresh = $("#chat_refresh");
		var $mesDeleteAll= $("#message_all_delete");
		var str="all";
		
		var delete_all_mes=function(){
			var parid=$("div.brij").attr('id');
			$.ajax({
				type: 'POST', 
				url: 'candidate_interface.py',
				data: 'delete_all_mess='+parid,
				success  : function (data)
				{
					$(document).ajaxStop(function(){
						if(data==1)
						{
							$("#mess_success").html('All data is cleared.').removeClass("hide").show().fadeOut("slow");
							data=0;
						}
						});
				}
				});
		};
		var retrieveMessages=function(str) {
			var parid=$("div.brij").attr('id');
			$.ajax({
				type: 'POST', 
				url: 'candidate_interface.py',
				data: 'load_inbox='+str+'&mess_reload='+parid,
				success  : function (data)
				{
					$chatOutput.html(data);
				}
				});
		};
		
		var mess_total_part =function(str,div_id){
			var parid=$("div.brij").attr('id');
			$.ajax({
				type: 'POST', 
				url: 'candidate_interface.py',
				data: 'load_inbox='+str+'&mess_total='+parid,
				success  : function (data)
				{
					$("#"+div_id+"").html(data);
				}
				});
		};
		var load_all_count=function(){
			mess_total_part("all","mess_show_total");
			mess_total_part("all","all_in");
			mess_total_part("offer","offer_in");
			mess_total_part("request","request_in");
		};
		$("#inbox_filter").change(function(){
			str=$(this).val();
			retrieveMessages(str);
			load_all_count();
		});
		
		load_all_count();
		retrieveMessages(str);
		$chatRefresh.click(function () {
			retrieveMessages(str);
			load_all_count();
		});	
		$mesDeleteAll.click(function(){
			var r = confirm("Are you sure?");
			if (r == true) {
				delete_all_mes(str);
				load_all_count();
				r=false;
			} else {
				
			}
			
		});
	};
	var add_hist_script=function(){
		var $historyOutput = $("#historyOutput");
		var $historyRefresh = $("#history_refresh");
		var $historyDeleteAll= $("#history_all_delete");
		var $histTotalShow=$("#hist_show_total");
		var delete_all_hist=function(){
			var parid=$("div.brij").attr('id');
			$.ajax({
				type: 'POST', 
				url: 'candidate_interface.py',
				data: 'delete_all_hist='+parid,
				success  : function (data)
				{
					$(document).ajaxStop(function(){
						if(data==1)
						{
						$("#hist_success").html('All data is cleared.').removeClass("hide").show().fadeOut(1000);
							data=0;
						}
						});	
				}
				});
		};
		var retrieveHistory=function() {
			var parid=$("div.brij").attr('id');
			$.ajax({
				type: 'POST', 
				url: 'candidate_interface.py',
				data: 'hist_reload='+parid,
				success  : function (data)
				{
					$historyOutput.html(data);
					hist_total_cal();
				}
				});
		};
		var hist_total_cal =function(){
			var parid=$("div.brij").attr('id');
			$.ajax({
				type: 'POST', 
				url: 'candidate_interface.py',
				data: 'hist_total='+parid,
				success  : function (data)
				{
					$histTotalShow.html(data);
				}
				});
		};
		hist_total_cal();
		$historyDeleteAll.click(function(){
			var r = confirm("Are you sure?");
			if (r == true) {
				delete_all_hist();
				hist_total_cal();
				r=false;
			} else {
				
			}
			
		});
		retrieveHistory();
		$historyRefresh.click(function () {
			retrieveHistory();
		});
	};
	add_inbox_script();
	add_hist_script();
	$("#show_institute").click(function(){
	var inst_id=$(this).children().find("div.inst_id").attr("id");
	var job_id=$(this).children().find("div.job_id").attr("id");
	$(this).append("<form method='post' id='myForm' action='show_institute.php'><input type='hidden' name='inst_id' value='"+inst_id+"' /><input type='hidden' name='job_id' value='"+job_id+"' /></form>");
	$("#myForm").submit();
	});
});