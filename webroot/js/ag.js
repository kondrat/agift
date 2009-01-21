//------------------------------------------------------------------------------------
$(document).ready(function(){
	$("td.small_img a").click(function(){
		
		$("#large_img  img").hide().attr( {"src": $(this).attr("href")} );
		//$("#large").html($("> img", this).attr("title"));
		return false;
	});
	$("#large_img>img").load(function(){$("#large_img>img:hidden").fadeIn("slow")});
});

//-----------------------------------------------------------------------------------