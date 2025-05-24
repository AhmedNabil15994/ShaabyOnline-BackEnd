/*================================================
 [  Table of contents  ]
 ================================================
 #Header
 #Slider home
 #Products Slider
 #Gift Warp Slider
 #Categories Slider
 #Slider range price
 #Collapsewill
 #Smoothproducts
 #Choose address type
 #Select2
 #Favorite button
 #User side responsive menu
 #Responsive search header
 #Choose day
 #Select Wrap
 #Select card
 #Select addition
 #Filter Responsive
 #Close panel in responsive
 #Print invoice
 #Tooltip
 #Add address item
 #Remove promo code
 #Google Map
 ======================================
 [ End table content ]
 ======================================*/

(function ($) {
    "use strict";
    /* ---------------------------------------------
     #Header
     --------------------------------------------- */
    $(document).ready(function () {
        new WOW().init();

        $(document).on('click', '.quantity .plus, .quantity .minus', function (e) {
// Get values
            var $qty = $(this).closest('.quantity').find('.qty'),
                    currentVal = parseFloat($qty.val()),
                    max = parseFloat($qty.attr('max')),
                    min = parseFloat($qty.attr('min')),
                    step = $qty.attr('step');
            // Format values
            if (!currentVal || currentVal === '' || currentVal === 'NaN')
                currentVal = 0;
            if (max === '' || max === 'NaN')
                max = '';
            if (min === '' || min === 'NaN')
                min = 0;
            if (step === 'any' || step === '' || step === undefined || parseFloat(step) === 'NaN')
                step = 1;
            // Change the value
            if ($(this).is('.plus')) {
                if (max && (max == currentVal || currentVal > max)) {
                    $qty.val(max);
                } else {
                    $qty.val(currentVal + parseFloat(step));
                }
            } else {
                if (min && (min == currentVal || currentVal < min)) {
                    $qty.val(min);
                } else if (currentVal > 0) {
                    $qty.val(currentVal - parseFloat(step));
                }
            }
// Trigger change event
            $qty.trigger('change');
            e.preventDefault();
        });
        // menu on mobile
        $(".header-nav .toggle-submenu").on('click', function () {
            $(this).parent().toggleClass('open-submenu');
            return false;
        });

        $(".btn-open-mobile").on('click', function () {
            $(this).toggleClass('active');
            $(".header-menu").toggleClass("has-open");
            $(".main-content").addClass("overlay");
            return false;
        });
        $(".header-menu .btn-close").on('click', function () {
            $('.header-menu').removeClass('has-open');
            $(".main-content").removeClass("overlay");
            return false;
        });
        $(".main-content").on('click', function () {
            $('.header-menu').removeClass('has-open');
            $(".main-content").removeClass("overlay");
        });
    });

    //  Slider home  
    $(".home-slides").owlCarousel({
        navigation: false,
        pagination: false,
        nav: false,
        dots: true,
        loop: false,
        margin: 0,
        items: 1,
//        autoplay: 3000,
        autoplayTimeout: 4000,
        smartSpeed: 1000,
        responsive: {
            0: {
                items: 1
            },
            480: {
                items: 1
            },
            768: {
                items: 1
            },
            992: {
                items: 1
            },
            1200: {
                items: 1
            }
        }
    });

//vendors Slider
    $(".vendors").owlCarousel({
        navigation: true,
        pagination: true,
        nav: true,
        dots: false,
        loop: false,
        margin: 30,
        items: 8,
        autoplay: 3000,
        autoplayTimeout: 4000,
        smartSpeed: 1000,
        navText: ['<span class="fa fa-angle-left"></span>', '<span class="fa fa-angle-right"></span>'],
        responsive: {
            0: {
                items: 2
            },
            480: {
                items: 2
            },
            768: {
                items: 2
            },
            992: {
                items: 5
            },
            1200: {
                items: 8
            }
        }
    });

    //Products Slider
    $(".products-slider").owlCarousel({
        navigation: true,
        pagination: true,
        nav: true,
        dots: false,
        loop: false,
        autoplay: false,
        margin: 30,
        items: 5,
        navText: ['<span class="fa fa-angle-left"></span>', '<span class="fa fa-angle-right"></span>'],
        responsive: {
            0: {
                items: 2
            },
            480: {
                items: 2
            },
            768: {
                items: 2
            },
            992: {
                items: 3
            },
            1200: {
                items: 5
            }
        }
    });

//Slider range price
    $('.slider-range-price').each(function () {
        var min = parseInt($(this).data('min'));
        var max = parseInt($(this).data('max'));
        var unit = $(this).data('unit');
        var value_min = parseInt($(this).data('value-min'));
        var value_max = parseInt($(this).data('value-max'));
        var label_reasult = $(this).data('label-reasult');
        var t = $(this);
        $(this).slider({
            range: true,
            min: min,
            max: max,
            values: [value_min, value_max],
            slide: function (event, ui) {
                var result = label_reasult + " <span>" + unit + ui.values[0] + ' </span> - <span> ' + unit + ui.values[1] + '</span>';
                t.closest('.price_slider_wrapper').find('.price_slider_amount').html(result);
            }
        });
    });

// Collapsewill
    $('.collapseWill').on('click', function (e) {
        $(this).toggleClass("pressed");
        e.preventDefault();
    });

//Smoothproducts
    $('.sp-wrap').smoothproducts();

//    Choose address type
    $('.address-type1').on('click', function (e) {
        $(this).toggleClass("cut-radio-style");
        $('.address-type2').removeClass("cut-radio-style");
    });
    $('.address-type2').on('click', function (e) {
        $(this).toggleClass("cut-radio-style");
        $('.address-type1').removeClass("cut-radio-style");
    });

//Select2
    $('.select-detail').select2();

//Favorite button
    $('.favo-btn').on('click', function (e) {
        $(this).toggleClass("active");
    });
//    User side responsive menu
    $('.user-side-menu h4').on('click', function (e) {
        $(".user-side-menu ul").slideToggle();
    });
//    Responsive search header
    $('.res-searc-icon').on('click', function (e) {
        $(".d-re-no").slideToggle();
    });
//    Choose day
    $('.day-block').on('click', function (e) {
        $('.day-block').not(this).removeClass('active');
        $(this).toggleClass("active");
    });
//    Select Wrap
    $('.choose-warp .gift-wrap').on('click', function (e) {
        $('.choose-warp .gift-wrap').not(this).removeClass('active');
        $(this).toggleClass("active");
    });
    $('.choose-products-wrap .gift-wrap').on('click', function (e) {
        $(this).toggleClass("active");
    });
//Select card
    $('.choose-card .gift-wrap').on('click', function (e) {
        $('.choose-card .gift-wrap').not(this).removeClass('active');
        $(this).toggleClass("active");
    });
//Select addition
    $('.choose-additions .gift-wrap').on('click', function (e) {
        $(this).toggleClass("active");
    });
//Filter Responsive

    $('.filter-res').on('click', function () {
        $('.filter-options').toggleClass("active");
        event.stopPropagation();
    });
    $('.btn-save-filter .btn').on('click', function () {
        $('.filter-options').removeClass("active");
    });
//Close panel in responsive
//    var width = $(window).width();
//    if (width <= 720) {
//        $('.content-sidebar .panel-collapse').removeClass('show');
//    }

//    Print invoice
    $('.print-invoice').click(function () {
        window.print();
    });

//    Tooltip
    $('[data-toggle="tooltip"]').tooltip();

    //    Add address item
    $('.address-item .product-summ-det').click(function () {
        $(this).closest(".address-item").toggleClass("active");
        $(this).closest('.address-item').siblings().removeClass("active");
    });

    //    Remove promo code
    $('.promo-code .remove').click(function () {
        $('.promo-code').addClass("hide");
    });

    /*======================================
     Google Map
     ======================================*/
    if ($('#google-map').length > 0) {
        //set your google maps parameters
        var latitude = 51.5255069,
                longitude = -0.0836207,
                map_zoom = 14;

        //google map custom marker icon 
        var marker_url = 'images/map-marker.png';

        //we define here the style of the map
        var style = [{"featureType": "landscape", "stylers": [{"saturation": -100}, {"lightness": 65}, {"visibility": "on"}]}, {"featureType": "poi", "stylers": [{"saturation": -100}, {"lightness": 51}, {"visibility": "simplified"}]}, {"featureType": "road.highway", "stylers": [{"saturation": -100}, {"visibility": "simplified"}]}, {"featureType": "road.arterial", "stylers": [{"saturation": -100}, {"lightness": 30}, {"visibility": "on"}]}, {"featureType": "road.local", "stylers": [{"saturation": -100}, {"lightness": 40}, {"visibility": "on"}]}, {"featureType": "transit", "stylers": [{"saturation": -100}, {"visibility": "simplified"}]}, {"featureType": "administrative.province", "stylers": [{"visibility": "off"}]}, {"featureType": "water", "elementType": "labels", "stylers": [{"visibility": "on"}, {"lightness": -25}, {"saturation": -100}]}, {"featureType": "water", "elementType": "geometry", "stylers": [{"hue": "#ffff00"}, {"lightness": -25}, {"saturation": -97}]}];

        //set google map options
        var map_options = {
            center: new google.maps.LatLng(latitude, longitude),
            zoom: map_zoom,
            panControl: true,
            zoomControl: true,
            mapTypeControl: true,
            streetViewControl: true,
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            scrollwheel: false,
            styles: style,
        }
        //inizialize the map
        var map = new google.maps.Map(document.getElementById('google-map'), map_options);
        //add a custom marker to the map				
        var marker = new google.maps.Marker({
            position: new google.maps.LatLng(latitude, longitude),
            map: map,
            visible: true,
            icon: marker_url,
        });
    }

})(jQuery); // End of use strict
