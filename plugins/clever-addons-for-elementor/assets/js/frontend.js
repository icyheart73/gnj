/**
 * frontend.js
 *
 * @copyright  2018 CleverSoft. All rights reserved.
 * @license MIT
 */
 (function ($) {
    "use strict";
    var cafe = {
        init: function () {
            var wrap = $('.append-class:not(.slick-slider)');
            cafe.cafe_carousel();
            cafe.productFilter(wrap);
            cafe.cafe_category_accordion();
            cafe.cafe_Tabsfiler_Mobile(992);
            cafe.cafe_pagination_ajax( '.products','.product','a.cafe-pagination-next');
        },
        // Lazy load
        cafe_lazyImg: function (target) {
            if ($(target)[0]) {
                $(target).not('.sec-img, .loaded').parent().addClass('loading');
                if(typeof deferimg !="undefined"){
                    deferimg($(target).selector+':not(.sec-img)', 0, 'loaded',
                        function () {
                        $(target).closest('.loading').removeClass('loading');
                    });
                }
            }
        },
        // Pagination
        cafe_pagination_ajax: function (wrap,item,path){
            $(document).on('click','.view-more-button', function(e){
                e.preventDefault();
            });
            if($('.pagination-ajax')[0]){
                if($(path)[0]){
                    var button = false;
                    var scrollThreshold = true;
                    if($('.view-more-button')[0]){
                        button = '.view-more-button';
                        scrollThreshold = false;
                        $(document).on('click','.view-more-button', function(){
                            $(this).hide();
                        });
                    }
                    var infScroll = new InfiniteScroll( wrap, {
                        path: path,
                        append: item,
                        status: '.scroller-status',
                        hideNav: '.cafe-pagination',
                        button: button,
                        scrollThreshold: scrollThreshold,
                    });
                    
                    $(wrap).on( 'history.infiniteScroll', function( event, response, path ) {
                        $('.view-more-button').show();
                        cafe.cafe_lazyImg('.lazy-img');
                    });
                    $(wrap).on( 'last.infiniteScroll', function( event, response, path ) {
                        $('.view-more-button').remove();
                    });
                }
                else{
                    $('.pagination-ajax,.infinite-scroll-error,.infinite-scroll-request,.view-more-button').remove();
                }
            }
            
        },
        
        //Image Comparison
        cafe_image_comparison: function ($target) {
            let $currentTarget = $target.find('.cafe-wrap-image-comparison');
            let beforelabel=!!$currentTarget.find('.before-img').attr('alt')?$currentTarget.find('.before-img').attr('alt'):'Before';
            let afterlabel=!!$currentTarget.find('.after-img').attr('alt')?$currentTarget.find('.after-img').attr('alt'):'After';
            let _orientation=!!$currentTarget.data('orientation')?$currentTarget.data('orientation'):'horizontal';
            $currentTarget.twentytwenty({
                orientation: _orientation,
                before_label: beforelabel, // Set a custom before label
                after_label: afterlabel, // Set a custom after label
            });
        },
        //Video Light Box
        cafe_video_light_box: function ($target) {
            $target.find('.cafe-video-button').on('click', function (e) {
                e.preventDefault();
                var url = $(this).attr('href');
                var config = $(this).data('cafe-config');
                var height = config.height;
                var width = config.width;
                var html = '<div class="cafe-video-mask"></div><div class="cafe-wrap-video-popup"><iframe src="' + url + '" height="' + height + '" width="' + width + '" ></iframe></div>';
                $('body').append(html);
            });
            $(document).on('click', '.cafe-video-mask', function () {
                $('.cafe-wrap-video-popup, .cafe-video-mask').fadeOut();
                setTimeout(function () {
                    $('.cafe-wrap-video-popup, .cafe-video-mask').remove();
                }, 500)
            });
        },
        //Auto Typing
        cafe_auto_typing: function ($target) {
            let $currentTarget = $target.find('.cafe-auto-typing');
            let data = $currentTarget.data('cafe-config');
            $currentTarget.find(".cafe-content-auto-typing").typed({
                strings: data.text,
                typeSpeed: data.speed,
                startDelay: data.delay,
                showCursor: data.cursor ? true : false,
                loop: data.loop ? true : false,
            });
        },
        // Image 360 view
        cafe_image_360_view: function ($target) {

            let $currentTarget = $target.find(".cafe-image-360-view");

            var config = JSON.parse($currentTarget.attr('data-cafe-config'));
            var frame_width = config['width'];
            var frame_height = config['height'];
            if (parseInt(frame_width) > $currentTarget.find('.cafe-wrap-img-360-view').width()) {
                var res = parseInt(frame_width) / parseInt(frame_height)
                frame_width = $currentTarget.find('.cafe-wrap-img-360-view').width();
                frame_height = parseInt(parseInt(frame_width) / res);
            }

            $currentTarget.find('.cafe-wrap-content-view').spritespin({
                // path to the source images.
                source: config['source'].split(','),
                width: frame_width, // width in pixels of the window/frame
                height: frame_height, // height in pixels of the window/frame
                animate: false
            });

            var api = $currentTarget.find('.cafe-wrap-content-view').spritespin("api");
            // call function next/previous frame when click to button next/previous
            $currentTarget.find('.cafe-control-view:not(.cafe-center)').on('click', function () {
                if ($currentTarget.hasClass('cafe-prev-item')) {
                    api.prevFrame();
                } else {
                    api.nextFrame();
                }
            });
        },

        //For productCarousel
        cafe_carousel: function ($target, wrap_config, wrap_slider) {
            var $currentTarget = !!$target ? $target.find(".cafe-carousel:not(.slick-slider)") : $(".cafe-carousel:not(.slick-slider)");

            $currentTarget.each(function () {
                var data = JSON.parse($(this).attr('data-cafe-config'));
                var slides_to_show = data['slides_to_show'];
                var slides_to_show_tablet = data['slides_to_show_tablet'];
                var slides_to_show_mobile = data['slides_to_show_mobile'];
                var scroll = data['scroll'];
                var autoplay = data['autoplay'];
                var autoplay_tablet = data['autoplay_tablet'];
                var autoplay_mobile = data['autoplay_mobile'];
                var speed = data['speed'];
                var show_pag = data['show_pag'];
                var show_pag_tablet = data['show_pag_tablet'];
                var show_pag_mobile = data['show_pag_mobile'];
                var show_nav = data['show_nav'];
                var show_nav_tablet = data['show_nav_tablet'];
                var show_nav_mobile = data['show_nav_mobile'];
                var wrap = data['wrap'] != undefined ? data['wrap'] : '';
                var arrow_left = data['arrow_left'] != undefined ? data['arrow_left'] : 'cs-font clever-icon-arrow-left-1';
                var arrow_right = data['arrow_right'] != undefined ? data['arrow_right'] : 'cs-font clever-icon-arrow-right-1';
                var center_mode = data['center_mode'] != undefined ? data['center_mode'] : false;
                var infinite = data['infinite'] != undefined ? data['infinite'] : true;
                var wrapcaroul = !!wrap ? $(this).find(wrap) : $(this);

                var row = data['row'] != undefined ? data['row'] : 0;

                if (!wrapcaroul.hasClass('slick-slider')) {
                    if (typeof wrap_config != 'function') {
                        if (!!wrap_config || !!wrap_slider) {
                            if (!!wrap_slider) {
                                wrapcaroul = wrap_slider;
                            } else {
                                wrapcaroul = $(wrap_config).find($(wrap).not('.ajax-loaded'));
                            }
                        }
                        wrapcaroul.slick({
                            infinite: infinite,
                            slidesToShow: slides_to_show,
                            slidesToScroll: scroll > slides_to_show ? slides_to_show : scroll,
                            arrows: show_nav,
                            dots: show_pag,
                            prevArrow: '<span class="cafe-carousel-btn prev-item"><i class="'+arrow_left+'"></i></span>',
                            nextArrow: '<span class="cafe-carousel-btn next-item "><i class="'+arrow_right+'"></i></span>',
                            autoplay: autoplay,
                            autoplaySpeed: speed,
                            rows: row,
                            rtl: $('body.rtl')[0] ? true : false,
                            centerMode:center_mode,
                            centerPadding:'0',
                            responsive: [

                            {
                                breakpoint: 769,
                                settings: {
                                    slidesToShow: slides_to_show_tablet,
                                    slidesToScroll: scroll > slides_to_show_tablet ? slides_to_show_tablet : scroll,
                                    autoplay: autoplay_tablet,
                                    arrows: show_nav_tablet,
                                    dots: show_pag_mobile,
                                }
                            },
                            {
                                breakpoint: 576,
                                settings: {
                                    slidesToShow: slides_to_show_mobile,
                                    slidesToScroll: scroll > slides_to_show_mobile ? slides_to_show_mobile : scroll,
                                    autoplay: autoplay_mobile,
                                    arrows: show_nav_tablet,
                                    dots: show_pag_mobile,
                                }
                            }
                            ]
                        });
                    }
                }
            });

        },
        // Filter Product
        productFilter: function (wrap) {

            wrap.find('.cafe-ajax-load a').on('click', function (e) {
                e.preventDefault();
                var $this = $(this);
                wrap = $this.parents('.append-class');
                if ($this.hasClass('active')) {
                    return;
                }
                $this.parents('.cafe-ajax-load ').find('a').removeClass('active');
                $this.addClass('active');
                if ($this.hasClass('opened')) {
                    let key = $this.data('value');
                    wrap.find('.products').html(wrap.find('.products').data(key));
                    if (wrap.hasClass('cafe-carousel')) {
                        wrap.find('.products').removeClass('slick-initialized slick-slider slick-dotted');
                        cafe.cafe_carousel(null, wrap, null);
                    }
                    return;
                }

                $this.addClass('opened');
                wrap.addClass('loading');
                var data = wrap.data('args');
                data['action'] = 'cafe_ajax_product_filter';
                if ($this.data('type') == 'product_cat') {
                    data['filter_categories'] = $this.data('value');
                }
                if ($this.data('type') == 'asset_type') {
                    data['asset_type'] = $this.data('value');
                }
                wrap.data('args', data);
                $.ajax({
                    url: wrap.data('url'),
                    data: data,
                    type: 'POST',
                }).success(function (response) {
                    wrap.removeClass('loading');
                    let key;
                    if (data['filter_categories']) {
                        key = data['filter_categories'];
                    }else if (data['asset_type']) {
                        key = data['asset_type'];
                    }
                    let content =$(response).html();
                    wrap.find('.products').html(content);
                    wrap.find('.products').data(key,content);
                    if (wrap.hasClass('cafe-carousel')) {
                        wrap.find('.products').removeClass('slick-initialized slick-slider slick-dotted');
                        cafe.cafe_carousel(null, wrap, null);
                    }
                }).error(function (ex) {
                    console.log(ex);
                });
            });
        },
        // Image 360 view
        cafe_category_accordion: function () {
            $(document).on('click', '.cafe-btn-accordion', function () {
                $(this).closest('.cafe-cat-item').toggleClass('activated');
                $(this).next('.cafe-sub-cat').slideToggle();
            });
        },
        // Progress bar
        cafe_progress_bar:function () {
            $(window).load(function () {
                $('.cafe-wrap-progress-bar:not(.loaded)').each(function () {
                    if($(window).scrollTop() + $(window).height() > $(this).offset().top){
                        cafe_progress_bar_animate($(this));
                    }
                });
            });
            $(window).on('scroll',function () {
                $('.cafe-wrap-progress-bar:not(.loaded)').each(function () {
                    if($(window).scrollTop() + $(window).height() > $(this).offset().top){
                        cafe_progress_bar_animate($(this));
                    }
                });
            });
            function cafe_progress_bar_animate($current) {
                $current.addClass('loaded');
                var config=$current.data('cafe-config');
                var percent=config.percent;
                if(!!percent) {
                    var duration=Math.round(config.duration/(percent+10));
                    var width = 0;
                    var id = setInterval(frame, duration);
                    function frame() {
                        if (width >= percent) {
                            clearInterval(id);
                        } else {
                            width++;
                            $current.find('.value').text(width);
                            $current.find('.cafe-progress-bar').css('width', width + '%');
                        }
                    }
                }
            }
        },

        //Tabs filter in mobile
        cafe_Tabsfiler_Mobile: function($poiter) {
            $('.cafe-head-product-filter.has-tabs .cafe-title').css('cursor','pointer');
            $(document).on('click', '.cafe-head-product-filter.has-tabs .cafe-title', function () {
                var w = $(window).width();
                if (w <= $poiter) {
                    $(this).parent().find('.cafe-ajax-load').slideToggle();
                    $(this).toggleClass('active');

                    return false;    
                }
            });
        },
    };
    window.cafe = cafe;
    // DOCUMENT READY
    $(function () {
        cafe.init();
    });
    $(window).on('elementor/frontend/init', function () {
        //Image Comparison
        elementorFrontend.hooks.addAction(
            "frontend/element_ready/clever-image-comparison.default",
            cafe.cafe_image_comparison
            );
        //Testimonial Slider
        elementorFrontend.hooks.addAction(
            "frontend/element_ready/clever-testimonial.default",
            cafe.cafe_carousel
            );
        //Image 360 view
        elementorFrontend.hooks.addAction(
            "frontend/element_ready/clever-image-360-view.default",
            cafe.cafe_image_360_view
            );
        //Auto Typing
        elementorFrontend.hooks.addAction(
            "frontend/element_ready/clever-auto-typing.default",
            cafe.cafe_auto_typing
            );
        //Video Lightbox
        elementorFrontend.hooks.addAction(
            "frontend/element_ready/clever-video-light-box.default",
            cafe.cafe_video_light_box
            );
        //Progress bar
        elementorFrontend.hooks.addAction(
            "frontend/element_ready/clever-progress-bar.default",
            cafe.cafe_progress_bar
            );
    });
})(jQuery);

/*Assign video backgound of slider to YT API*/
function onYouTubeIframeAPIReady() {
    jQuery('.slick-slide:not(.slick-cloned) .cafe-viewer-video.youtube-embed iframe').each(function () {
        if (jQuery(this).attr('id') != '') ;
        {
            let sound = jQuery(this).parent().data('cafe-config').sound;
            let player = new YT.Player(jQuery(this).attr('id'), {
                playerVars: {
                    'autoplay': 0,
                    'controls': 0,
                    'modestbranding': 1,
                    'rel': 0,
                    'showinfo': 0
                },
                events: {
                    onReady: function (e) {
                        if(sound!='yes'){
                            e.target.mute();
                        }
                        jQuery('#progressBar').hide();
                    }
                }
            }
            );
            jQuery(this).parent().data('player', player);
        }
    })

}
/*End Assign video backgound of slider to YT API*/

// webpackModules
(function (modules) {
    // The module cache
    var $ = jQuery,
    installedModules = {};

    // The require function
    function __webpack_require__(moduleId) {

        // Check if module is in cache
        if (installedModules[moduleId]) {
            return installedModules[moduleId].exports;
        }
        // Create a new module (and put it into the cache)
        var module = installedModules[moduleId] = {
            i: moduleId,
            l: false,
            exports: {}
        };

        // Execute the module function
        modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);

        // Flag the module as loaded
        module.l = true;

        // Return the exports of the module
        return module.exports;
    }

    // expose the modules object (__webpack_modules__)
    __webpack_require__.m = modules;

    // expose the module cache
    __webpack_require__.c = installedModules;

    // define getter function for harmony exports
    __webpack_require__.d = function (exports, name, getter) {
        if (!__webpack_require__.o(exports, name)) {
            Object.defineProperty(exports, name, {
                enumerable: true,
                get: getter
            });
        }
    };

    // define __esModule on exports
    __webpack_require__.r = function (exports) {
        if (typeof Symbol !== 'undefined' && Symbol.toStringTag) {
            Object.defineProperty(exports, Symbol.toStringTag, {
                value: 'Module'
            });
        }
        Object.defineProperty(exports, '__esModule', {
            value: true
        });
    };

    // create a fake namespace object
    // mode & 1: value is a module id, require it
    // mode & 2: merge all properties of value into the ns
    // mode & 4: return value when already ns object
    // mode & 8|1: behave like require
    __webpack_require__.t = function (value, mode) {
        if (mode & 1) value = __webpack_require__(value);
        if (mode & 8) return value;
        if ((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
        var ns = Object.create(null);
        __webpack_require__.r(ns);
        Object.defineProperty(ns, 'default', {
            enumerable: true,
            value: value
        });
        if (mode & 2 && typeof value != 'string')
            for (var key in value) __webpack_require__.d(ns, key, function (key) {
                return value[key];
            }.bind(null, key));
                return ns;
            };

    // getDefaultExport function for compatibility with non-harmony modules
    __webpack_require__.n = function (module) {
        var getter = module && module.__esModule ?
        function getDefault() {
            return module['default'];
        } :
        function getModuleExports() {
            return module;
        };
        __webpack_require__.d(getter, 'a', getter);
        return getter;
    };

    // Object.prototype.hasOwnProperty.call
    __webpack_require__.o = function (object, property) {
        return Object.prototype.hasOwnProperty.call(object, property);
    };

    // __webpack_public_path__
    __webpack_require__.p = '';

    // Load entry module and return exports
    return __webpack_require__(__webpack_require__.s = 0);
})
([
    /* 0 */
    (function (module, exports, __webpack_require__) {
        'use strict';

        function CleverAddonsForElementor(elementor) {
            var self = this,
            handlers = {
                slider: __webpack_require__(1)
            };
            this.modules = {};
            self.modules = {};
            jQuery.each(handlers, function (moduleName) {
                self.modules[moduleName] = new this(elementor);
            });

        }
        jQuery(window).on('elementor/frontend/init', function () {
            window.cafeFrontend = new CleverAddonsForElementor(elementorFrontend);
        });
    }),
    /* 1 */
    (function (module, exports, __webpack_require__) {
        'use strict';

        module.exports = function (elementor) {
            elementor.hooks.addAction('frontend/element_ready/clever-slider.default', __webpack_require__(2));
            elementor.hooks.addAction('frontend/element_ready/clever-section-bookmark.default', __webpack_require__(3));
            elementor.hooks.addAction('frontend/element_ready/clever-edd-tabs.default', __webpack_require__(4));
            elementor.hooks.addAction('frontend/element_ready/clever-scroll-to.default', __webpack_require__(7));
        };
    }),
    /* 2 */
    (function (module, exports, __webpack_require__) {
        'use strict';

        var CleverSlider = elementorFrontend.Module.extend({
            getDefaultSettings: function () {
                return {
                    selectors: {
                        slider: '.cafe-slider-slides',
                        slideBackground: '.slick-slide-bg',
                        slideContent: '.cafe-slide-content'
                    },
                    classes: {
                        animated: 'animated'
                    },
                    attributes: {
                        dataSliderOptions: 'slider_options',
                        dataAnimation: 'animation'
                    }
                };
            },
            /*Resize iframe fit to slider size*/
            resizeIframe: function ($slider) {
                let slide_res = $slider.width() / $slider.height();
                $slider.find('.cafe-viewer-video iframe').each(function () {
                    let frame_res = jQuery(this).attr('width') / jQuery(this).attr('height');
                    if (frame_res > slide_res) {
                        jQuery(this).attr('width', frame_res * $slider.height());
                        jQuery(this).width(frame_res * $slider.height());
                        jQuery(this).attr('height', $slider.height());
                    } else {
                        jQuery(this).attr('width', $slider.width());
                        jQuery(this).width($slider.width());
                        jQuery(this).attr('height', $slider.width() / frame_res);
                    }
                })
            },

            getDefaultElements: function () {
                var selectors = this.getSettings('selectors');
                return {
                    $slider: this.$element.find(selectors.slider)
                };
            },

            initSlider: function () {
                var $slider = this.elements.$slider;
                var settings = this.getSettings();
                if (!$slider.length) {
                    return;
                }

                $slider.slick($slider.data(this.getSettings('attributes.dataSliderOptions')));
                $slider.find(settings.selectors.slideBackground).each(function () {
                    if (jQuery(this).data('animation') != 'inherit' && !jQuery(this).parent().hasClass('slick-active')) {
                        jQuery(this).hide();
                    }
                });
                /*JS for slider video*/
                this.resizeIframe($slider);
                $slider.find('.cafe-viewer-video.vimeo-embed').each(function () {
                    var options = {
                        background: true
                    };
                    if (typeof Vimeo != 'undefined') {
                        var player = new Vimeo.Player(jQuery(this).find('iframe'), options);
                        player.setLoop(true);
                        var arg = jQuery(this).data('cafe-config');
                        if (arg.sound != 'yes') {
                            player.setVolume(0);
                        }
                        player.disableTextTrack();
                        jQuery(this).data('player', player);
                    }
                })
                if ($slider.find('.slick-active .cafe-viewer-video.vimeo-embed')[0]) {
                    let player = $slider.find('.slick-active .cafe-viewer-video.vimeo-embed').data('player');
                    player.play();
                }
                if ($slider.find('.slick-active .cafe-viewer-video.youtube-embed')[0]) {
                    let player = $slider.find('.slick-active .cafe-viewer-video.youtube-embed').data('player');
                    player.playVideo();
                }
                /*End JS for slider video*/
            },

            goToActiveSlide: function () {
                this.elements.$slider.slick('slickGoTo', this.getEditSettings('activeItemIndex') - 1);
            },

            onPanelShow: function () {
                var $slider = this.elements.$slider;

                $slider.slick('slickPause');

                // On switch between slides while editing. stop again.
                $slider.on('afterChange', function () {
                    $slider.slick('slickPause');
                });
            },

            bindEvents: function () {
                var $slider = this.elements.$slider,
                settings = this.getSettings(),
                animation = $slider.data(settings.attributes.dataAnimation);

                if (!animation) {
                    return;
                }

                if (elementorFrontend.isEditMode()) {
                    elementor.hooks.addAction('panel/open_editor/widget/clever-slider', this.onPanelShow);
                }

                $slider.on({
                    beforeChange: function (event, slick, currentSlide) {
                        let $sliderContent = $slider.find(settings.selectors.slideContent);
                        let $slideBackground = jQuery(slick.$slides.get(currentSlide)).find(settings.selectors.slideBackground);

                        let selfAnimation = $sliderContent.data('animation');
                        let selfBgAnimation = $slideBackground.data('animation');

                        selfAnimation = selfAnimation == 'inherit' ? animation : selfAnimation;

                        $sliderContent.removeClass(settings.classes.animated + ' ' + selfAnimation).hide();

                        if (selfBgAnimation != 'inherit') {
                            $slideBackground.removeClass(settings.classes.animated + ' ' + selfBgAnimation).hide();
                        }
                    },
                    afterChange: function (event, slick, currentSlide) {
                        let $currentSlide = jQuery(slick.$slides.get(currentSlide)).find(settings.selectors.slideContent);
                        let $currentBgSlide = jQuery(slick.$slides.get(currentSlide)).find(settings.selectors.slideBackground);

                        let selfAnimation = $currentSlide.data('animation');
                        let selfBgAnimation = $currentBgSlide.data('animation');

                        selfAnimation = selfAnimation == 'inherit' ? animation : selfAnimation;

                        $currentSlide.show().addClass(settings.classes.animated + ' ' + selfAnimation);
                        if (selfBgAnimation != 'inherit') {
                            $currentBgSlide.show().addClass(settings.classes.animated + ' ' + selfBgAnimation);
                        }
                        /*Video background control play/pause when change slide*/
                        $slider.find('.cafe-viewer-video.vimeo-embed').each(function () {
                            let player = jQuery(this).data('player');
                            if (jQuery(this).parents('.slick-active')[0]) {
                                player.play();
                            } else {
                                player.pause();
                            }
                        });
                        $slider.find('.cafe-viewer-video.youtube-embed').each(function () {
                            let player = jQuery(this).data('player');
                            if (typeof player != 'undefined') {
                                if (jQuery(this).parents('.slick-active')[0]) {
                                    player.playVideo();
                                } else {
                                    player.pauseVideo();
                                }
                            }
                        });
                        /*End Video background control play/pause when change slide*/
                    }
                });
                var $this = this;
                jQuery(window).on('resize', function () {
                    $this.resizeIframe($slider);
                })
            },

            onInit: function () {
                elementorFrontend.Module.prototype.onInit.apply(this, arguments);

                this.initSlider();

                if (this.isEdit) {
                    this.goToActiveSlide();
                }
            },

            onEditSettingsChange: function (propertyName) {
                if ('activeItemIndex' === propertyName) {
                    this.goToActiveSlide();
                }
            }
        });

module.exports = function ($scope) {
    new CleverSlider({
        $element: $scope
    });
};
}),
/* 3 */
(function (module, exports, __webpack_require__) {
    'use strict';

    var CleverSectionBookmark = elementorFrontend.Module.extend({
        addSection: function () {
            var context = jQuery(this.$element.context),
            section = context.find('.cafe-bookmark-section'),
            sectionId = section.attr('id'),
            sectionIcon = section.data('icon'),
            sectionLabel = section.data('label'),
            sectionModelId = section.data('modelId');

            if (!elementorFrontend.isEditMode() && !context.hasClass('cafe-section-bookmark-container')) {
                context.addClass('cafe-section-bookmark-container');
            }

            if (!context.hasClass('bookmarked')) {
                this.navBar.append('<li><a class="cafe-section-bookmark-link ' + sectionIcon + ' section-link-' + sectionModelId + '" href="#' + sectionId + '"><span class="screen-reader-text">' + sectionLabel + '</span></a></li>');
                context.addClass('bookmarked');
            } else {
                this.navBar.find('a[href="#' + sectionId + '"]').replaceWith('<li><a class="cafe-section-bookmark-link ' + sectionIcon + ' section-link-' + sectionModelId + '" href="#' + sectionId + '"><span class="screen-reader-text">' + sectionLabel + '</span></a></li>');
            }
        },
        setActiveSection: function () {
            navLinks.removeClass('current');
            $('#navigation li a[href="#' + id + '"]').addClass('current');
        },
        goToActiveSection: function () {
            if (target.length) {
                $('html, body').stop().animate({
                    scrollTop: target.offset().top
                }, 1000);
            }
        },
        initNavBar: function () {
            var navBar = jQuery('#cafe-bookmark-bar');
            if (!navBar.length) {
                var $ul = document.createElement('ul');
                $ul.id = 'cafe-bookmark-bar';
                $ul.style = 'list-style:none;margin:0;padding:0;position:fixed;width:20px;height:100px;right:1em;top:calc(50vh - 50px)';
                document.body.appendChild($ul);
                this.navBar = jQuery('#cafe-bookmark-bar');
            } else {
                this.navBar = navBar;
            }
        },
        onInit: function () {
            elementorFrontend.Module.prototype.onInit.apply(this, arguments);

            this.initNavBar();

            this.addSection();

                // draft code
                jQuery('.cafe-section-bookmark-link').on('click', function (e) {
                    var target = jQuery(this.getAttribute('href'));

                    if (target.length) {
                        e.preventDefault();
                        jQuery('html, body').stop().animate({
                            scrollTop: target.offset().top
                        }, 1000);
                    }
                });

                jQuery(window).scroll(function () {
                    var position = window.pageYOffset;
                    jQuery('.cafe-bookmark-section').each(function () {
                        var target = jQuery(this).offset().top;
                        var id = jQuery(this).attr('id');
                        var navLinks = jQuery('#cafe-bookmark-bar li a');
                        if (position >= target) {
                            navLinks.removeClass('current');
                            jQuery('#cafe-bookmark-bar li a[href="#' + id + '"]').addClass('current');
                        }
                    });
                });
            },
            onEditSettingsChange: function (propertyName) {
                console.log(propertyName);
            }
        });

    module.exports = function ($scope) {
        new CleverSectionBookmark({
            $element: $scope
        });
    };
}),
/* 4 */
(function (module, exports, __webpack_require__) {
    'use strict';

    var TabsModule = __webpack_require__(5);

    module.exports = function ($scope) {
        new TabsModule({
            $element: $scope,
            toggleSelf: false
        });
    };
}),
/* 5 */
(function (module, exports, __webpack_require__) {
    "use strict";

    var HandlerModule = __webpack_require__(6);

    module.exports = HandlerModule.extend({
        $activeContent: null,

        getDefaultSettings: function getDefaultSettings() {
            return {
                selectors: {
                    tabTitle: '.elementor-tab-title',
                    tabContent: '.elementor-tab-content'
                },
                classes: {
                    active: 'elementor-active'
                },
                showTabFn: 'show',
                hideTabFn: 'hide',
                toggleSelf: true,
                hidePrevious: true,
                autoExpand: true
            };
        },

        getDefaultElements: function getDefaultElements() {
            var selectors = this.getSettings('selectors');

            return {
                $tabTitles: this.findElement(selectors.tabTitle),
                $tabContents: this.findElement(selectors.tabContent)
            };
        },

        activateDefaultTab: function activateDefaultTab() {
            var settings = this.getSettings();

            if (!settings.autoExpand || 'editor' === settings.autoExpand && !this.isEdit) {
                return;
            }

            var defaultActiveTab = this.getEditSettings('activeItemIndex') || 1,
            originalToggleMethods = {
                showTabFn: settings.showTabFn,
                hideTabFn: settings.hideTabFn
            };

                // Toggle tabs without animation to avoid jumping
                this.setSettings({
                    showTabFn: 'show',
                    hideTabFn: 'hide'
                });

                this.changeActiveTab(defaultActiveTab);

                // Return back original toggle effects
                this.setSettings(originalToggleMethods);
            },

            deactivateActiveTab: function deactivateActiveTab(tabIndex) {
                var settings = this.getSettings(),
                activeClass = settings.classes.active,
                activeFilter = tabIndex ? '[data-tab="' + tabIndex + '"]' : '.' + activeClass,
                $activeTitle = this.elements.$tabTitles.filter(activeFilter),
                $activeContent = this.elements.$tabContents.filter(activeFilter);

                $activeTitle.add($activeContent).removeClass(activeClass);

                $activeContent[settings.hideTabFn]();
            },

            activateTab: function activateTab(tabIndex) {
                var settings = this.getSettings(),
                activeClass = settings.classes.active,
                $requestedTitle = this.elements.$tabTitles.filter('[data-tab="' + tabIndex + '"]'),
                $requestedContent = this.elements.$tabContents.filter('[data-tab="' + tabIndex + '"]');

                $requestedTitle.add($requestedContent).addClass(activeClass);

                $requestedContent[settings.showTabFn]();
            },

            isActiveTab: function isActiveTab(tabIndex) {
                return this.elements.$tabTitles.filter('[data-tab="' + tabIndex + '"]').hasClass(this.getSettings('classes.active'));
            },

            bindEvents: function bindEvents() {
                var _this = this;

                this.elements.$tabTitles.on({
                    keydown: function keydown(event) {
                        if ('Enter' === event.key) {
                            event.preventDefault();

                            _this.changeActiveTab(event.currentTarget.dataset.tab);
                        }
                    },
                    click: function click(event) {
                        event.preventDefault();

                        _this.changeActiveTab(event.currentTarget.dataset.tab);
                    }
                });
            },

            onInit: function onInit() {
                HandlerModule.prototype.onInit.apply(this, arguments);

                this.activateDefaultTab();
            },

            onEditSettingsChange: function onEditSettingsChange(propertyName) {
                if ('activeItemIndex' === propertyName) {
                    this.activateDefaultTab();
                }
            },

            changeActiveTab: function changeActiveTab(tabIndex) {
                var isActiveTab = this.isActiveTab(tabIndex),
                settings = this.getSettings();

                if ((settings.toggleSelf || !isActiveTab) && settings.hidePrevious) {
                    this.deactivateActiveTab();
                }

                if (!settings.hidePrevious && isActiveTab) {
                    this.deactivateActiveTab(tabIndex);
                }

                if (!isActiveTab) {
                    this.activateTab(tabIndex);
                }
            }
        });
}),
/* 6 */
(function (module, exports, __webpack_require__) {

    "use strict";


    module.exports = elementorModules.ViewModule.extend({
        $element: null,

        editorListeners: null,

        onElementChange: null,

        onEditSettingsChange: null,

        onGeneralSettingsChange: null,

        onPageSettingsChange: null,

        isEdit: null,

        __construct: function __construct(settings) {
            this.$element = settings.$element;

            this.isEdit = this.$element.hasClass('elementor-element-edit-mode');

            if (this.isEdit) {
                this.addEditorListeners();
            }
        },

        findElement: function findElement(selector) {
            var $mainElement = this.$element;

            return $mainElement.find(selector).filter(function () {
                return jQuery(this).closest('.elementor-element').is($mainElement);
            });
        },

        getUniqueHandlerID: function getUniqueHandlerID(cid, $element) {
            if (!cid) {
                cid = this.getModelCID();
            }

            if (!$element) {
                $element = this.$element;
            }

            return cid + $element.attr('data-element_type') + this.getConstructorID();
        },

        initEditorListeners: function initEditorListeners() {
            var self = this;

            self.editorListeners = [{
                event: 'element:destroy',
                to: elementor.channels.data,
                callback: function callback(removedModel) {
                    if (removedModel.cid !== self.getModelCID()) {
                        return;
                    }

                    self.onDestroy();
                }
            }];

            if (self.onElementChange) {
                var elementName = self.getElementName(),
                eventName = 'change';

                if ('global' !== elementName) {
                    eventName += ':' + elementName;
                }

                self.editorListeners.push({
                    event: eventName,
                    to: elementor.channels.editor,
                    callback: function callback(controlView, elementView) {
                        var elementViewHandlerID = self.getUniqueHandlerID(elementView.model.cid, elementView.$el);

                        if (elementViewHandlerID !== self.getUniqueHandlerID()) {
                            return;
                        }

                        self.onElementChange(controlView.model.get('name'), controlView, elementView);
                    }
                });
            }

            if (self.onEditSettingsChange) {
                self.editorListeners.push({
                    event: 'change:editSettings',
                    to: elementor.channels.editor,
                    callback: function callback(changedModel, view) {
                        if (view.model.cid !== self.getModelCID()) {
                            return;
                        }

                        self.onEditSettingsChange(Object.keys(changedModel.changed)[0]);
                    }
                });
            }

            ['page', 'general'].forEach(function (settingsType) {
                var listenerMethodName = 'on' + settingsType[0].toUpperCase() + settingsType.slice(1) + 'SettingsChange';

                if (self[listenerMethodName]) {
                    self.editorListeners.push({
                        event: 'change',
                        to: elementor.settings[settingsType].model,
                        callback: function callback(model) {
                            self[listenerMethodName](model.changed);
                        }
                    });
                }
            });
        },

        getEditorListeners: function getEditorListeners() {
            if (!this.editorListeners) {
                this.initEditorListeners();
            }

            return this.editorListeners;
        },

        addEditorListeners: function addEditorListeners() {
            var uniqueHandlerID = this.getUniqueHandlerID();

            this.getEditorListeners().forEach(function (listener) {
                elementorFrontend.addListenerOnce(uniqueHandlerID, listener.event, listener.callback, listener.to);
            });
        },

        removeEditorListeners: function removeEditorListeners() {
            var uniqueHandlerID = this.getUniqueHandlerID();

            this.getEditorListeners().forEach(function (listener) {
                elementorFrontend.removeListeners(uniqueHandlerID, listener.event, null, listener.to);
            });
        },

        getElementName: function getElementName() {
            return this.$element.data('element_type').split('.')[0];
        },

        getID: function getID() {
            return this.$element.data('id');
        },

        getModelCID: function getModelCID() {
            return this.$element.data('model-cid');
        },

        getElementSettings: function getElementSettings(setting) {
            var elementSettings = {},
            modelCID = this.getModelCID();

            if (this.isEdit && modelCID) {
                var settings = elementorFrontend.config.elements.data[modelCID],
                settingsKeys = elementorFrontend.config.elements.keys[settings.attributes.widgetType || settings.attributes.elType];

                jQuery.each(settings.getActiveControls(), function (controlKey) {
                    if (-1 !== settingsKeys.indexOf(controlKey)) {
                        elementSettings[controlKey] = settings.attributes[controlKey];
                    }
                });
            } else {
                elementSettings = this.$element.data('settings') || {};
            }

            return this.getItems(elementSettings, setting);
        },

        getEditSettings: function getEditSettings(setting) {
            var attributes = {};

            if (this.isEdit) {
                attributes = elementorFrontend.config.elements.editSettings[this.getModelCID()].attributes;
            }

            return this.getItems(attributes, setting);
        },

        onDestroy: function onDestroy() {
            this.removeEditorListeners();

            if (this.unbindEvents) {
                this.unbindEvents();
            }
        }
    });
}),
/* 7 */
(function (module, exports, __webpack_require__) {

    function CleverScrollTo($selector, settings) {
        var $ = jQuery,
        self = this,
        $window = $(window),
        $instance = $selector,
        checkTemps = $selector.find(".cafe-scrollto-sections-wrap").length,
        $htmlBody = $("html, body"),
        deviceType = $("body").data("elementor-device-mode"),
        $itemsList = $(".cafe-scrollto-nav-item", $instance),
        $menuItems = $(".cafe-scrollto-nav-menu-item", $instance),
        defaultSettings = {
            speed: 1000,
            offset: 1,
            fullSection: true
        },
        settings = $.extend({}, defaultSettings, settings),
        sections = {},
        currentSection = null,
        isScrolling = false;

        jQuery.extend(jQuery.easing, {
            easeInOutCirc: function (x, t, b, c, d) {
                if ((t /= d / 2) < 1) return (-c / 2) * (Math.sqrt(1 - t * t) - 1) + b;
                return (c / 2) * (Math.sqrt(1 - (t -= 2) * t) + 1) + b;
            }
        });

        self.checkNextSection = function (object, key) {
            var keys = Object.keys(object),
            idIndex = keys.indexOf(key),
            nextIndex = (idIndex += 1);

            if (nextIndex >= keys.length) {
                return false;
            }

            var nextKey = keys[nextIndex];

            return nextKey;
        };

        self.checkPrevSection = function (object, key) {
            var keys = Object.keys(object),
            idIndex = keys.indexOf(key),
            prevIndex = (idIndex -= 1);

            if (0 > idIndex) {
                return false;
            }

            var prevKey = keys[prevIndex];

            return prevKey;
        };

        self.debounce = function (threshold, callback) {
            var timeout;

            return function debounced($event) {
                function delayed() {
                    callback.call(this, $event);
                    timeout = null;
                }

                if (timeout) {
                    clearTimeout(timeout);
                }

                timeout = setTimeout(delayed, threshold);
            };
        };
        self.visible = function (selector, partial, hidden) {

            var s = selector.get(0),
            vpHeight = $window.outerHeight(),
            clientSize = hidden === true ? s.offsetWidth * s.offsetHeight : true;
            if (typeof s.getBoundingClientRect === 'function') {
                var rec = s.getBoundingClientRect();
                var tViz = rec.top >= 0 && rec.top < vpHeight,
                bViz = rec.bottom > 0 && rec.bottom <= vpHeight,
                vVisible = partial ? tViz || bViz : tViz && bViz,
                vVisible = (rec.top < 0 && rec.bottom > vpHeight) ? true : vVisible;
                return clientSize && vVisible;
            } else {
                var viewTop = 0,
                viewBottom = viewTop + vpHeight,
                position = $window.position(),
                _top = position.top,
                _bottom = _top + $window.height(),
                compareTop = partial === true ? _bottom : _top,
                compareBottom = partial === true ? _top : _bottom;
                return !!clientSize && ((compareBottom <= viewBottom) && (compareTop >= viewTop));
            }

        };

        self.init = function () {
            self.setSectionsData();
            $itemsList.on("click.premiumVerticalScroll", self.onNavDotChange);
            $menuItems.on("click.premiumVerticalScroll", self.onNavDotChange);

            $itemsList.on("mouseenter.premiumVerticalScroll", self.onNavDotEnter);

            $itemsList.on("mouseleave.premiumVerticalScroll", self.onNavDotLeave);

            if (deviceType === "desktop") {
                $window.on("scroll.premiumVerticalScroll", self.onWheel);
            }
            $window.on(
                "resize.premiumVerticalScroll orientationchange.premiumVerticalScroll",
                self.debounce(50, self.onResize)
                );
            $window.on("load", function () {
                self.setSectionsData();
            });

            $(document).keydown(function (event) {
                if (38 == event.keyCode) {
                    self.onKeyUp(event, "up");
                }

                if (40 == event.keyCode) {
                    self.onKeyUp(event, "down");
                }
            });
            if (settings.fullSection) {
                var vSection = document.getElementById($instance.attr("id"));
                if (checkTemps) {
                    document.addEventListener ?
                    vSection.addEventListener("wheel", self.onWheel, !1) :
                    vSection.attachEvent("onmousewheel", self.onWheel);
                } else {
                    document.addEventListener ?
                    document.addEventListener("wheel", self.onWheel, !1) :
                    document.attachEvent("onmousewheel", self.onWheel);
                }
            }

            for (var section in sections) {
                var $section = sections[section].selector;
                elementorFrontend.waypoint(
                    $section,
                    function (direction) {
                        var $this = $(this),
                        sectionId = $this.attr("id");
                        if ("down" === direction && !isScrolling) {
                            currentSection = sectionId;
                            $itemsList.removeClass("active");
                            $menuItems.removeClass("active");
                            $("[data-menuanchor=" + sectionId + "]", $instance).addClass(
                                "active"
                                );
                        }
                    }, {
                        offset: "95%",
                        triggerOnce: false
                    }
                    );

                elementorFrontend.waypoint(
                    $section,
                    function (direction) {
                        var $this = $(this),
                        sectionId = $this.attr("id");
                        if ("up" === direction && !isScrolling) {
                            currentSection = sectionId;
                            $itemsList.removeClass("active");
                            $menuItems.removeClass("active");
                            $("[data-menuanchor=" + sectionId + "]", $instance).addClass(
                                "active"
                                );
                        }
                    }, {
                        offset: "0%",
                        triggerOnce: false
                    }
                    );
            }
        };

        self.setSectionsData = function () {
            $itemsList.each(function () {
                var $this = $(this),
                sectionId = $this.data("menuanchor"),
                $section = $("#" + sectionId);
                if ($section[0]) {
                    sections[sectionId] = {
                        selector: $section,
                        offset: Math.round($section.offset().top),
                        height: $section.outerHeight()
                    };
                }
            });
        };

        self.onNavDotEnter = function () {
            var $this = $(this),
            index = $this.data("index");
            if (settings.tooltips) {
                $('<div class="cafe-scrollto-nav-item-tooltip"><span>' + $this.data('label') + '</span></div>').hide().appendTo($this).fadeIn(200);
            }
        };

        self.onNavDotLeave = function () {
            $(".cafe-scrollto-nav-item-tooltip").fadeOut(200, function () {
                $(this).remove();
            });
        };

        self.onNavDotChange = function (event) {
            var $this = $(this),
            index = $this.index(),
            sectionId = $this.data("menuanchor"),
            offset = null;

            if (!sections.hasOwnProperty(sectionId)) {
                return false;
            }

            offset = sections[sectionId].offset - settings.offset;

            if (!isScrolling) {
                isScrolling = true;

                currentSection = sectionId;
                $menuItems.removeClass("active");
                $itemsList.removeClass("active");

                if ($this.hasClass("cafe-scrollto-nav-menu-item")) {
                    $($itemsList[index]).addClass("active");
                } else {
                    $($menuItems[index]).addClass("active");
                }

                $this.addClass("active");

                $htmlBody
                .stop()
                .clearQueue()
                .animate({
                    scrollTop: offset
                },
                settings.speed,
                "easeInOutCirc",
                function () {
                    isScrolling = false;
                }
                );
            }
        };

        self.onKeyUp = function (event, direction) {
            var direction = direction || "up",
            sectionId,
            nextItem = $(
                ".cafe-scrollto-nav-item[data-menuanchor=" + currentSection + "]",
                $instance
                ).next(),
            prevItem = $(
                ".cafe-scrollto-nav-item[data-menuanchor=" + currentSection + "]",
                $instance
                ).prev();

            event.preventDefault();

            if (isScrolling) {
                return false;
            }

            if ("up" === direction) {
                if (prevItem[0]) {
                    prevItem.trigger("click.premiumVerticalScroll");
                }
            }

            if ("down" === direction) {
                if (nextItem[0]) {
                    nextItem.trigger("click.premiumVerticalScroll");
                }
            }
        };

        self.onScroll = function (event) {
            /* On Scroll Event */
            if (isScrolling) {
                event.preventDefault();
            }
        };

        function getFirstSection(object) {
            return Object.keys(object)[0];
        }

        function getLastSection(object) {
            return Object.keys(object)[Object.keys(object).length - 1];
        }

        function getDirection(e) {
            e = window.event || e;
            var t = Math.max(-1, Math.min(1, e.wheelDelta || -e.deltaY || -e.detail));
            return t;
        }

        self.onWheel = function (event) {
            if (isScrolling) {
                event.preventDefault();
                return false;
            }

            var $target = $(event.target),
            sectionSelector = checkTemps ?
            ".cafe-scrollto-temp" :
            ".elementor-top-section",
            $section = $target.closest(sectionSelector),
            $vTarget = self.visible($instance, true, false),
            sectionId = $section.attr("id"),
            offset = 0,
            newSectionId = false,
            prevSectionId = false,
            nextSectionId = false,
            delta = getDirection(event),
            direction = 0 > delta ? "down" : "up",
            windowScrollTop = $window.scrollTop(),
            dotIndex = $(".cafe-scrollto-nav-item.active").index();
            if ("mobile" === deviceType || "tablet" === deviceType) {
                $(".cafe-scrollto-nav-item-tooltip").hide();
                if (dotIndex === $itemsList.length - 1 && !$vTarget) {
                    $(".cafe-scrollto-nav-icons, .cafe-scrollto-nav-menu").addClass(
                        "cafe-scrollto-nav-icons-hide"
                        );
                } else if (dotIndex === 0 && !$vTarget) {
                    if ($instance.offset().top - $(document).scrollTop() > 200) {
                        $(".cafe-scrollto-nav-icons, .cafe-scrollto-nav-menu").addClass(
                            "cafe-scrollto-nav-icons-hide"
                            );
                    }
                } else {
                    $(".cafe-scrollto-nav-icons, .cafe-scrollto-nav-menu").removeClass(
                        "cafe-scrollto-nav-icons-hide"
                        );
                }
            }

            if (beforeCheck()) {
                sectionId = getFirstSection(sections);
            }

            if (afterCheck()) {
                sectionId = getLastSection(sections);
            }
            if (sectionId && sections.hasOwnProperty(sectionId)) {
                prevSectionId = self.checkPrevSection(sections, sectionId);
                nextSectionId = self.checkNextSection(sections, sectionId);
                if ("up" === direction) {
                    if (!nextSectionId && sections[sectionId].offset < windowScrollTop) {
                        newSectionId = sectionId;
                    } else {
                        newSectionId = prevSectionId;
                    }
                }

                if ("down" === direction) {
                    if (
                        !prevSectionId &&
                        sections[sectionId].offset > windowScrollTop + 5
                        ) {
                        newSectionId = sectionId;
                } else {
                    newSectionId = nextSectionId;
                }
            }

            if (newSectionId) {
                $(".cafe-scrollto-nav-icons, .cafe-scrollto-nav-menu").removeClass(
                    "cafe-scrollto-nav-icons-hide"
                    );
                event.preventDefault();
                offset = sections[newSectionId].offset - settings.offset;
                currentSection = newSectionId;
                $itemsList.removeClass("active");
                $menuItems.removeClass("active");
                $("[data-menuanchor=" + newSectionId + "]", $instance).addClass(
                    "active"
                    );

                isScrolling = true;
                self.scrollStop();
                $htmlBody.animate({
                    scrollTop: offset
                },
                settings.speed,
                "easeInOutCirc",
                function () {
                    isScrolling = false;
                }
                );
            } else {
                var $lastselector = checkTemps ? $instance : $("#" + sectionId);
                if ("down" === direction) {
                    if (
                        $lastselector.offset().top +
                        $lastselector.innerHeight() -
                        $(document).scrollTop() >
                        600
                        ) {
                        $(".cafe-scrollto-nav-icons, .cafe-scrollto-nav-menu").addClass(
                            "cafe-scrollto-nav-icons-hide"
                            );
                }
            } else if ("up" === direction) {
                if ($lastselector.offset().top - $(document).scrollTop() > 200) {
                    $(".cafe-scrollto-nav-icons, .cafe-scrollto-nav-menu").addClass(
                        "cafe-scrollto-nav-icons-hide"
                        );
                }
            }
        }
    }
};

function beforeCheck(event) {
    var windowScrollTop = $window.scrollTop(),
    firstSectionId = getFirstSection(sections),
    offset = sections[firstSectionId].offset,
    topBorder = windowScrollTop + $window.outerHeight(),
    visible = self.visible($instance, true, false);

    if (topBorder > offset) {
        return false;
    } else if (visible) {
        return true;
    }
    return false;
}

function afterCheck(event) {
    var windowScrollTop = $window.scrollTop(),
    lastSectionId = getLastSection(sections),
    offset = sections[lastSectionId].offset,
    bottomBorder =
    sections[lastSectionId].offset + sections[lastSectionId].height,
    visible = self.visible($instance, true, false);

    if (windowScrollTop < bottomBorder) {
        return false;
    } else if (visible) {
        return true;
    }

    return false;
}

self.onResize = function (event) {
    self.setSectionsData();
};

self.scrollStop = function () {
    $htmlBody.stop(true);
};
};

module.exports = function ($scope) {
    var section = $scope.find(".cafe-scrollto-section");
    var module = new CleverScrollTo(section, section.data("settings"));
    module.init();
}
})
]);
