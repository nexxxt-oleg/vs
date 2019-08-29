$(function() {
    windowWidth = $(window).width();
    function drowSubmenu() {
        if(windowWidth>992){
            var containerWidth = $(".header-sub-menu .container").width();
            $(".header-sub-menu-current-category").width(containerWidth-284);
        }
    }
    drowSubmenu();


    function drowMobMenu() {
       var windowHeight = $(window).height();
       var headerHeight = $("header").height();
       $(".header-mob-menu").height(windowHeight-headerHeight);
    }
    drowMobMenu();


    $(".header-open-main-menu").on("click", function () {
        $(".header-sub-menu-category").removeClass("active");
        $(".header-mob-menu").toggleClass("active");
        console.log("fd");
        if($(".header-mob-menu").hasClass("active")){
            $("main").addClass("overflow");
        }
        else {
            $("main").removeClass("overflow");
        }

    });



    $(".header-sub-menu-category li").mouseover(function (){
        if(windowWidth>992){
            $(this).children(".header-sub-menu-current-category").css( "display", "flex" );
        }
        else {
            $(this).children(".header-sub-menu-current-category").css( "display", "none" );
        }
    }
   );
    $(".header-sub-menu-category>li").mouseout(function () {
        $(this).children(".header-sub-menu-current-category").css( "display", "none" );
    });
    $(".header-main-menu-dropdown").on("click", function () {
        $(".header-sub-menu-category").toggleClass("active");
        if(windowWidth<992){
            if($(".header-sub-menu-category").hasClass("active")){
                $("main").addClass("overflow");
            }
            else {
                $("main").removeClass("overflow");
            }
            var windowHeight = $(window).height();
            var headerHeight = $("header").height();
            $(".header-sub-menu-category").height(windowHeight-headerHeight);
        }
        $(".header-mob-menu").removeClass("active");

    });


    $(".main-slider-wrapper").slick({
        dots: true,
        prevArrow: $('.main-slider-control-btn-left'),
        nextArrow: $('.main-slider-control-btn-right'),
        appendDots : $('.main-slider-control-dots .col-md-12'),

    });


    function startSaleSlider() {
        var windowWidth = $(window).width();
        var countOfSlides;
        if(windowWidth < 769 && windowWidth > 767) {
            countOfSlides = 3
        }
        else if (windowWidth < 767) {
            countOfSlides = 2
        }
        else {
            countOfSlides = 4;
        }
        $(".sale-slider .row").slick({
            dots: false,
            slidesToShow: countOfSlides,
            slidesToScroll: 1,
            prevArrow: $('.sale-slider-left'),
            nextArrow: $('.sale-slider-right'),
        });
    }
    startSaleSlider();

    $(".bottom-nav-slider .row").slick({
        dots: false,
        slidesToShow: 4,
        slidesToScroll: 1,
        prevArrow: $('.section-title .fa-angle-left'),
        nextArrow: $('.section-title .fa-angle-right'),
    });

    $(".partners-slider-wrapper").slick({
        dots: false,
        slidesToShow: 5,
        slidesToScroll: 1,
        prevArrow: $('.partners-slider .row .fa-angle-left'),
        nextArrow: $('.partners-slider .row .fa-angle-right'),
    });

    if(windowWidth<767){
        $('.header-main-menu').affix({
            offset: {
                /* Affix the navbar after scroll below header */
                top: $(".header-mid-block").outerHeight(true)}
        });
        $('.header-mob-menu').affix({
            offset: {
                /* Affix the navbar after scroll below header */
                top: $(".header-mid-block").outerHeight(true)}
        });
        $('.header-sub-menu').affix({
            offset: {
                /* Affix the navbar after scroll below header */
                top: $(".header-mid-block").outerHeight(true)}
        });
    }

    $( window ).resize(function () {
        drowSubmenu();
        $('.sale-slider .row').slick('unslick');
        startSaleSlider();
        drowMobMenu();
    });
});
