$(document).ready(function () {
   	var add_certificate_script=function(){
		var $certificateOutput = $("#certificate_output");
		var $certificateRefresh = $("#certificate_refresh");
		var $certificateTotalShow=$("#certificate_show_total");
		
		var retrieveCertificate=function() {
			var parid=$("div.certficate_header").attr('id');
			$.ajax({
				type: 'POST', 
				url: 'candidate_interface.py',
				data: 'certificate_reload='+parid,
				success  : function (data)
				{
					$certificateOutput.html(data);
					certificate_total_cal();
				}
				});
		};
		var certificate_total_cal =function(){
			var parid=$("div.certficate_header").attr('id');
			$.ajax({
				type: 'POST', 
				url: 'candidate_interface.py',
				data: 'certificate_total='+parid,
				success  : function (data)
				{
					$certificateTotalShow.html(data);
				}
				});
		};
		retrieveCertificate();
		$certificateRefresh.click(function () {
			retrieveCertificate();
		});	
		
	};
	
	add_certificate_script();
});