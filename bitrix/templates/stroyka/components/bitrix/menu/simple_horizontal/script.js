

$(document).ready(function(){
    var windowWidth = $(window).width();
    if(windowWidth <= 740) {
        $(".main-menu").removeClass("main-menu-active");
        $("#sticker").sticky({topSpacing:0});
        
        $(".horizontal-open-menu-btn").on("click", function(){
    $(".main-menu").slideUp(300,function(){
			$(this).removeClass("main-menu-active");
		});
	var menu = $(".for-flex");
	if(!menu.hasClass("for-flex-active"))
    	$(".for-flex").slideDown(300,function(){
			$(this).toggleClass("for-flex-active");
		});
	else
		$(".for-flex").slideUp(300,function(){
			$(this).removeClass("for-flex-active");
		});
});
    }
  });