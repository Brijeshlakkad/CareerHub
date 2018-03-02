<html><head></head>
<script language="JavaScript">
	var i=0;
	function help(){
			if(i==0)
				  {
			  var head= document.getElementsByTagName('head')[0];
			  var script= document.createElement('script');
			  script.type= 'text/javascript';
			  script.src= 'js/admin_cand.js';
					  console.log("added");
			  head.appendChild(script);
					  i++;
				  }

		  }
	help();
  </script>
  <body></body></html>