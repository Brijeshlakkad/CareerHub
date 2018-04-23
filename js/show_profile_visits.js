$(document).ready(function () {
   	var add_visits_script=function(){
		var $visitsOutput = $("#visitsOutput");
		var $visitsRefresh = $("#visits_refresh");
		var $visitsDeleteAll= $("#visits_all_delete");
		var str="all";
		
		var delete_all_visits=function(){
			var parid=$("div.brij").attr('id');
			$.ajax({
				type: 'POST', 
				url: 'institute_interface.py',
				data: 'delete_all_visits='+parid,
				success  : function (data)
				{
					$(document).ajaxStop(function(){
						if(data==1)
						{
							$("#visits_success").html('All data is cleared.').removeClass("hide").show().fadeOut("slow");
							data=0;
							$("#visits_refresh").click();
						}
						});
				}
				});
		};
		var retrieveVisits=function() {
			var parid=$("div.brij").attr('id');
			$.ajax({
				type: 'POST', 
				url: 'institute_interface.py',
				data: 'visits_reload='+parid,
				success  : function (data)
				{
					$visitsOutput.html(data);
				}
				});
		};
		
		var visits_total_count =function(){
			var parid=$("div.brij").attr('id');
			$.ajax({
				type: 'POST', 
				url: 'institute_interface.py',
				data: 'visits_total='+parid,
				success  : function (data)
				{
					$("#visitsTotalCount").html(data);
				}
				});
		};
		var impressions_total_count =function(){
			var parid=$("div.brij").attr('id');
			$.ajax({
				type: 'POST', 
				url: 'institute_interface.py',
				data: 'total_impressions='+parid,
				success  : function (data)
				{
					$("#total_impressions").html(data);
				}
				});
		};
		visits_total_count();
		retrieveVisits();
		impressions_total_count();
		$visitsRefresh.click(function () {
			retrieveVisits();
			visits_total_count();
			impressions_total_count();
		});	
		$visitsDeleteAll.click(function(){
			var r = confirm("Are you sure?");
			if (r == true) {
				delete_all_visits();
				r=false;
			} else {
				
			}
			
		});
	};
	add_visits_script();
});