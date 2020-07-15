var swiper = new Swiper('.ibenzz_slider', {
    pagination: {
        el: '.swiper-pagination',
    },
    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
    },
});

(function ($) {
    $('.testimonail-slider').each(function() {

        // Configuration
        var item = $(this).data('items');
        var conf 	= {};
        conf.slidesPerView = item;
        conf.autoplay = { delay : 5000 , disableOnInteraction : false};
        //Initialize
        var myye = new Swiper( this , conf);

    });
})(jQuery);

(function ($) {
    $('.product-slider').each(function() {

        // Configuration
        var row_count = $(this).data('row');
        var row_countMobile = $(this).data('rowmobile');
        var column_count = $(this).data('column');
        var column_countMobile = $(this).data('columnmobile');
        var slider_autoplay = $(this).data('autoplay');
        var brkpnt = {640 : {slidesPerView: column_countMobile, spaceBetween: 20, slidesPerColumn : row_countMobile}};

        var conf_slider 	= {};
        conf_slider.slidesPerView = column_count;
        conf_slider.slidesPerColumn = row_count;
        conf_slider.spaceBetween = 30;
        conf_slider.pagination = {el: '.swiper-pagination',clickable: true,};
        conf_slider.navigation = {nextEl: '.swiper-button-next', prevEl: '.swiper-button-prev',};
        conf_slider.breakpoints = brkpnt;
        console.log(conf_slider);
        if(slider_autoplay)
           conf_slider.autoplay = { delay : 5000 , disableOnInteraction : false};
         //Initialize
        var slider = new Swiper( this , conf_slider);
    });
})(jQuery);

