$(document).ready(function(){
	$(".icon_menu_mobile").click(function(e) {
		$val=$(".icon_menu_mobile").attr("val");
		if($val==0){
			$(".menu_mobile").attr("style","visibility: visible;");
			$(this).attr("val",1);
			$('body').attr("class","ad_body");
		}
		$('html, body').animate({scrollTop: 0}, 500);
	});
	$(".close_menu_mobile").click(function() {
		$(".menu_mobile").removeAttr("style");
		$(".icon_menu_mobile").attr("val",0);
		$('body').removeAttr("class");		
	});


	$(".mobile_dmql").click(function() {
		$(".ql_left").toggle();
	});

});