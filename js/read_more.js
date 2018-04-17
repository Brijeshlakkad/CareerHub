
	var minimized_elements = $(".description_first");
	var minimize_character_count = 200;    

	minimized_elements.each(function(){    
	  var t = $(this).text();        
	  if(t.length < minimize_character_count ) return;

	  $(this).html(
		  t.slice(0,minimize_character_count )+
		  '<span>... </span><a href="#" class="read_more">Read more</a>'+
		  '<span style="display:none;">'+ t.slice(minimize_character_count ,t.length)+
		  '<br/><a href="#" class="read_less">Read less</a></span>'
		);  
	});

	$('a.read_more', minimized_elements).click(function(event){
	  event.preventDefault();
	  $(this).hide().prev().hide();
	  $(this).next().show();        
	});

	$('a.read_less', minimized_elements).click(function(event){
	  event.preventDefault();
	  $(this).parent().hide().prev().show().prev().show();    
	});
