$(document).ready(function(){
	$("#refresh").click(function(){
		location.reload();
	});
	$("#admin_updated_inst").click(function(){
			$.ajax({
     		type: 'POST', 
			url: 'admin_show_inst.php',
           	data: 'flag=updated',
         	success  : function (data)
         	{
				$("#show_here").empty();
				$("#show_here").html(data);
         	}
			});
		});
	$("#admin_all_inst").click(function(){
			$.ajax({
     		type: 'POST', 
			url: 'admin_show_inst.php',
           	data: 'flag=all',
         	success  : function (data)
         	{
				$("#show_here").empty();
				$("#show_here").html(data);
         	}
			});
		});
	$("#admin_wait_inst").click(function(){
			$.ajax({
     		type: 'POST', 
			url: 'admin_show_inst.php',
           	data: 'flag=wait',
         	success  : function (data)
         	{
				$("#show_here").empty();
				$("#show_here").html(data);
         	}
			});
		});
	$("#admin_appr_inst").click(function(){
			$.ajax({
     		type: 'POST', 
			url: 'admin_show_inst.php',
           	data: 'flag=appr',
         	success  : function (data)
         	{
				$("#show_here").empty();
				$("#show_here").html(data);
         	}
			});
		});
	$("#admin_decl_inst").click(function(){
			$.ajax({
     		type: 'POST', 
			url: 'admin_show_inst.php',
           	data: 'flag=decl',
         	success  : function (data)
         	{
				$("#show_here").empty();
				$("#show_here").html(data);
         	}
		});
		});
	
	$("#approve_inst").click(function(){
		var parid=$(this).closest('div').attr('id');
		var appr = prompt("Please enter 'Approve' to approve Candidate : "+parid );
		if (appr.toLowerCase() == "approve") {
			$.post("admin_inst.py",
			{
				id: ""+parid,
				flag: "1"
			},
			function(data){
				if(data==01)
				{
					alert("Decision is already taken.");
				}
				else if(data==11)
				{
					alert("Candidate "+parid+" is approved Successfully.");
				}
				else if(data==00 || data==10)
				{
					alert("Please, try again! later");
				}
				else
					alert("hii");
			});
		} else {
			
		}
		});
	$("#decline_inst").click(function(){
		var parid=$(this).closest('div').attr('id');
		var appr = prompt("Please enter 'Decline' to decline institute : "+parid );
		if (appr.toLowerCase() == "decline") {
			$.post("admin_inst.py",
			{
				id: ""+parid,
				flag:"0"
			},
			function(data, status){
				if(data==01)
				{
					alert("Decision is already taken.");
				}
				else if(data==11)
				{
					alert("Institute "+parid+" is declined Successfully.");
				}
				else if(data==00 || data==10)
				{
					alert("Please, try again! later");
				}
			});
		} else {
			
		}
		});
		
});
function get_institute(query,fid)
	{
				var x=new XMLHttpRequest();
				x.onreadystatechange=function()
				{
					if(x.readyState==4 && x.status==200)
						{
							var data=this.responseText;
							$("#show_here").empty();
							$("#show_here").html(data);
						}
				};
				x.open("POST","admin_institute_details.php",true);
				x.setRequestHeader("Content-type","application/x-www-form-urlencoded");
				x.send("query="+query);
	}