$(".btn-open-main-menu").on("click", function(){
    var windowWidth = $(window).width();
    if(windowWidth <= 740) {
    $(".for-flex").slideUp(300,function(){
			$(this).removeClass("for-flex-active");
		});
    }
   
	var menu = $(".main-menu");
	if(!menu.hasClass("main-menu-active"))
    	$(".main-menu").slideDown(300,function(){
			$(this).toggleClass("main-menu-active");
		});
	else
		$(".main-menu").slideUp(300,function(){
			$(this).removeClass("main-menu-active");
		});
});
jQuery(document).ready(function() {
    function setColForPreview () {
        var windowWidth = $(window).width();
        if (windowWidth < 500) {
            $(".block-preview-article .col-sm-5").removeClass("col-xs-5");
            $(".block-preview-article .col-sm-5").addClass("col-xs-0");
            $(".block-preview-article .col-sm-7").removeClass("col-xs-7");
            $(".block-preview-article .col-sm-7").addClass("col-xs-12");
        }
        else {
            $(".block-preview-article .col-sm-5").removeClass("col-xs-0");
            $(".block-preview-article .col-sm-5").addClass("col-xs-5");
            $(".block-preview-article .col-sm-7").removeClass("col-xs-12");
            $(".block-preview-article .col-sm-7").addClass("col-xs-7");
        }
    };
    setColForPreview ();
    jQuery(window).resize(function(){
        setColForPreview ();
    });
});
