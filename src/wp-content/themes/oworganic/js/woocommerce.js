(function($) {
    "use strict";
    
    $.extend($.apusThemeCore, {
        /**
         *  Initialize scripts
         */
        woo_init: function() {
            var self = this;

            self.loginRegister();

            self.cartOffcanvas();

            self.addToCartAction();

            self.getProductAjax();

            self.searchProduct();

            self.productDetail();
            
            self.initQuickview();

            self.initSwatches();

            self.wishlistInit();

            self.searchHeader();

            $( 'body' ).on( 'found_variation', function( event, variation ) {
                self.variationsImageUpdate(variation);
            });

            $( 'body' ).on( 'reset_image', function( event, variation ) {
                self.variationsImageUpdate(variation);
            });
            if ( $.isFunction( $.fn.select2 ) ) {
                $('.apus-search-form .select-category select').select2();
            }
            $(document).on('click', '.apus-topcart a.mini-cart', function(){
                $('.apus-topcart .cart_list').perfectScrollbar();
            });
            $(document).on('click', '.filter-btn', function(){
                $(this).closest('.filter-btn-wrapper').find('.shop-filter-sidebar-wrapper').addClass('active');
                $(this).closest('.filter-btn-wrapper').find('.shop-filter-sidebar-overlay').addClass('active');
            });
            $(document).on('click', '.close-filter', function(){
                $(this).closest('.filter-btn-wrapper').find('.shop-filter-sidebar-wrapper').removeClass('active');
                $(this).closest('.filter-btn-wrapper').find('.shop-filter-sidebar-overlay').removeClass('active');
            });
            $('.shop-filter-sidebar-overlay').on('click', function(){
                $(this).closest('.filter-btn-wrapper').find('.shop-filter-sidebar-wrapper').removeClass('active');
                $(this).removeClass('active');
            });


            setTimeout(function(){
                $('.top-categories-inner .list-category-products').perfectScrollbar();
            }, 100);

            $('body').on( 'yith_woocompare_open_popup', function( e, data ) {
                if ( data.button ) {
                    var button = data.button;
                    if ( !button.hasClass('button-single') ) {
                        button.html('<svg aria-hidden="true" focusable="false" width="18" height="18" data-prefix="far" data-icon="balance-scale" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><path fill="currentColor" d="M256 336h-.02c0-16.18 1.34-8.73-85.05-181.51-8.83-17.65-25.89-26.49-42.95-26.49-17.04 0-34.08 8.82-42.92 26.49C-2.06 328.75.02 320.33.02 336H0c0 44.18 57.31 80 128 80s128-35.82 128-80zM83.24 265.13c11.4-22.65 26.02-51.69 44.46-89.1.03-.01.13-.03.29-.03l.02-.04c19.82 39.64 35.03 69.81 46.7 92.96 11.28 22.38 19.7 39.12 25.55 51.08H55.83c6.2-12.68 15.24-30.69 27.41-54.87zM528 464H344V155.93c27.42-8.67 48.59-31.36 54.39-59.93H528c8.84 0 16-7.16 16-16V64c0-8.84-7.16-16-16-16H393.25C380.89 19.77 352.79 0 320 0s-60.89 19.77-73.25 48H112c-8.84 0-16 7.16-16 16v16c0 8.84 7.16 16 16 16h129.61c5.8 28.57 26.97 51.26 54.39 59.93V464H112c-8.84 0-16 7.16-16 16v16c0 8.84 7.16 16 16 16h416c8.84 0 16-7.16 16-16v-16c0-8.84-7.16-16-16-16zM320 112c-17.64 0-32-14.36-32-32s14.36-32 32-32 32 14.36 32 32-14.36 32-32 32zm319.98 224c0-16.18 1.34-8.73-85.05-181.51-8.83-17.65-25.89-26.49-42.95-26.49-17.04 0-34.08 8.82-42.92 26.49-87.12 174.26-85.04 165.84-85.04 181.51H384c0 44.18 57.31 80 128 80s128-35.82 128-80h-.02zm-200.15-16c6.19-12.68 15.23-30.69 27.4-54.87 11.4-22.65 26.02-51.69 44.46-89.1.03-.01.13-.03.29-.03l.02-.04c19.82 39.64 35.03 69.81 46.7 92.96 11.28 22.38 19.7 39.12 25.55 51.08H439.83z" class=""></path></svg>');
                    } else {
                        button.html('<svg aria-hidden="true" focusable="false" width="18" height="18" data-prefix="far" data-icon="balance-scale" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><path fill="currentColor" d="M256 336h-.02c0-16.18 1.34-8.73-85.05-181.51-8.83-17.65-25.89-26.49-42.95-26.49-17.04 0-34.08 8.82-42.92 26.49C-2.06 328.75.02 320.33.02 336H0c0 44.18 57.31 80 128 80s128-35.82 128-80zM83.24 265.13c11.4-22.65 26.02-51.69 44.46-89.1.03-.01.13-.03.29-.03l.02-.04c19.82 39.64 35.03 69.81 46.7 92.96 11.28 22.38 19.7 39.12 25.55 51.08H55.83c6.2-12.68 15.24-30.69 27.41-54.87zM528 464H344V155.93c27.42-8.67 48.59-31.36 54.39-59.93H528c8.84 0 16-7.16 16-16V64c0-8.84-7.16-16-16-16H393.25C380.89 19.77 352.79 0 320 0s-60.89 19.77-73.25 48H112c-8.84 0-16 7.16-16 16v16c0 8.84 7.16 16 16 16h129.61c5.8 28.57 26.97 51.26 54.39 59.93V464H112c-8.84 0-16 7.16-16 16v16c0 8.84 7.16 16 16 16h416c8.84 0 16-7.16 16-16v-16c0-8.84-7.16-16-16-16zM320 112c-17.64 0-32-14.36-32-32s14.36-32 32-32 32 14.36 32 32-14.36 32-32 32zm319.98 224c0-16.18 1.34-8.73-85.05-181.51-8.83-17.65-25.89-26.49-42.95-26.49-17.04 0-34.08 8.82-42.92 26.49-87.12 174.26-85.04 165.84-85.04 181.51H384c0 44.18 57.31 80 128 80s128-35.82 128-80h-.02zm-200.15-16c6.19-12.68 15.23-30.69 27.4-54.87 11.4-22.65 26.02-51.69 44.46-89.1.03-.01.13-.03.29-.03l.02-.04c19.82 39.64 35.03 69.81 46.7 92.96 11.28 22.38 19.7 39.12 25.55 51.08H439.83z" class=""></path></svg><span class="text">' + oworganic_woo_opts.conpare_text + '</span>');
                    }
                }
            });
        },
        wishlistInit: function() {
            $( 'body' ).on( 'added_to_wishlist', function( event, variation ) {
                $('.wishlist-icon .count').each(function(){
                    var count = $(this).text();
                    count = parseInt(count) + 1;
                    $(this).text(count);
                });
                    
            });
            $('body').on('removed_from_wishlist', function( event, variation ) {
                if ( $('.wishlist-icon .count').length > 0 ) {
                    $('.wishlist-icon .count').each(function(){
                        var count = $(this).text();
                        count = parseInt(count) - 1;
                        $(this).text(count);
                    });
                }
            });
        },

        searchHeader: function() {
            $('.apus-search-form').each(function(){
                var $form_container = $(this);
                $form_container.find('.show-search-header').on('click', function(e){
                    e.preventDefault();
                    
                    if ( $form_container.find('.apus-search-form-inner').hasClass('active') ) {
                        $form_container.find('.apus-search-form-inner').removeClass('active');
                        $form_container.find('.overlay-search-header').removeClass('active');
                        setTimeout(function(){
                            $("body").removeClass('show-header-static');
                        }, 300);
                    } else {
                        $form_container.find('.apus-search-form-inner').addClass('active');
                        $form_container.find('.overlay-search-header').addClass('active');
                        $("body").addClass('show-header-static');
                    }
                });

                $form_container.find('.overlay-search-header, .close-search').on('click', function(e){
                    $form_container.find('.apus-search-form-inner').removeClass('active');
                    $form_container.find('.overlay-search-header').removeClass('active');
                    setTimeout(function(){
                        $("body").toggleClass('show-header-static');
                    }, 300);
                });
            });

        },

        cartOffcanvas: function() {
            $('.mini-cart.offcanvas').on('click', function(e){
                e.preventDefault();
                if ( $('.offcanvas-content').hasClass('active') ) {
                    $('.offcanvas-content').removeClass('active');
                    $('.overlay-offcanvas-content').removeClass('active');
                } else {
                    $('.offcanvas-content').addClass('active');
                    $('.overlay-offcanvas-content').addClass('active');
                }
            });
            $('.overlay-offcanvas-content, .close-cart, .widget_shopping_cart_heading').on('click', function(){
                $('.offcanvas-content').removeClass('active');
                $('.overlay-offcanvas-content').removeClass('active');
            });
        },
        addToCartAction: function() {
            jQuery('body').bind('added_to_cart', function( fragments, cart_hash ){
                $('.offcanvas-content').addClass('active');
                $('.overlay-offcanvas-content').addClass('active');
            });
        },
        getProductAjax: function() {
            var self = this;
            $('[data-load="ajax"] a').on('click', function(e){
                e.preventDefault();
                var $href = $(this).attr('href');

                $(this).parent().parent().find('li').removeClass('active');
                $(this).parent().addClass('active');

                var main = $($href);
                if ( main.length > 0 ) {
                    if ( main.data('loaded') == false ) {
                        main.parent().addClass('loading');
                        main.data('loaded', 'true');

                        $.ajax({
                            url: oworganic_woo_opts.ajaxurl.toString().replace( '%%endpoint%%', 'oworganic_ajax_get_products' ),
                            type:'POST',
                            dataType: 'html',
                            data:  {
                                settings: main.data('settings'),
                                tab: main.data('tab')
                            }
                        }).done(function(reponse) {
                            main.html( reponse );
                            main.parent().removeClass('loading');
                            main.parent().find('.tab-pane').removeClass('active');
                            main.addClass('active');

                            main.find('[data-time="timmer"]').each(function(index, el) {
                                var $this = $(this);
                                var $date = $this.data('date').split("-");
                                var $format = "<div class=\"times\"><div class=\"day\">%%D%% "+ oworganic_countdown_opts.days +"</div><div class=\"hours\">%%H%% "+ oworganic_countdown_opts.hours +"</div><div class=\"minutes\">%%M%% "+ oworganic_countdown_opts.mins +"</div><div class=\"seconds\">%%S%% "+ oworganic_countdown_opts.secs +"</div></div>";
                                if ( $(this).data('format')) {
                                    $format = $(this).data('format');
                                }
                                $this.apusCountDown({
                                    TargetDate:$date[0]+"/"+$date[1]+"/"+$date[2]+" "+$date[3]+":"+$date[4]+":"+$date[5],
                                    DisplayFormat: $format,
                                    FinishMessage: "",
                                });
                            });

                            if ( main.find('.slick-carousel') ) {
                                self.initSlick(main.find('.slick-carousel'));
                            }
                            self.layzyLoadImage();
                        });
                        return true;
                    } else {
                        main.parent().removeClass('loading');
                        main.parent().find('.tab-pane').removeClass('active');
                        main.addClass('active');

                        var $slick = $("[data-carousel=slick]", main);
                        if ($slick.length > 0 && $slick.hasClass('slick-initialized')) {
                            $slick.slick('refresh');
                        }
                        self.layzyLoadImage();
                    }
                }
            });
        },
        loginRegister: function(){
            var self = this;
            $('body').on( 'click', '.register-login-action', function(e){
                e.preventDefault();
                var href = $(this).attr('href');
                $(this).closest('.user').find('.register_login_wrapper').removeClass('active');
                $(href).addClass('active');

                if ( $(this).hasClass('creat-account') ) {
                    var $cookie_val = '#customer_register';
                } else {
                    var $cookie_val = '#customer_login';
                }
                self.setCookie('oworganic_login_register', $cookie_val, 1);
            } );
        },
        searchProduct: function(){
            if ( $('.apus-autocompleate-input').length ) {
                $('.apus-autocompleate-input').typeahead({
                        hint: true,
                        highlight: true,
                        minLength : 3,
                    }, {
                        limit: 10,
                        name: 'search',
                        source: function (query, processSync, processAsync) {
                            processSync([oworganic_woo_opts.empty_msg]);
                            $('.twitter-typeahead').addClass('loading');
                            return $.ajax({
                                url: oworganic_woo_opts.ajaxurl.toString().replace( '%%endpoint%%', 'oworganic_autocomplete_search' ),
                                type: 'GET',
                                data: {
                                    's': query,
                                    'category': $('.apus-search-form .dropdown_product_cat').val(),
                                    'security': oworganic_woo_opts.ajax_nonce
                                },
                                dataType: 'json',
                                success: function (json) {
                                    $('.twitter-typeahead').removeClass('loading');
                                    return processAsync(json);
                                }
                            });
                        },
                        templates: {
                            empty : [
                                '<div class="empty-message">',
                                oworganic_woo_opts.empty_msg,
                                '</div>'
                            ].join('\n'),
                            suggestion: function(data) {
                                return '<div class="autocomplete-list-item"><a href="'+ data.url +'" class="media autocompleate-media"><div class="media-left media-middle"><img src="'+ data.image +'" class="media-object" height="100" width="100"></div><div class="media-body media-middle"><div class="product-cat">'+ data.category +'</div><h3 class="name-product">'+ data.title +'</h3><div class="price">'+ data.price +'</div></div></a></div>';
                            }
                        },
                    }
                );
                $('.apus-autocompleate-input').on('typeahead:selected', function (e, data) {
                    e.preventDefault();
                    setTimeout(function(){
                        $('.apus-autocompleate-input').val(data.title);    
                    }, 5);
                    
                    return false;
                });
            }
        },
        productDetail: function(){
            // review click link
            $('.woocommerce-review-link').on('click', function(){
                $('.woocommerce-tabs a[href="#tabs-list-reviews"]').trigger('click');
                $('html, body').animate({
                    scrollTop: $("#reviews").offset().top
                }, 1000);
                return false;
            });

            $( document.body )
            .off( 'click', '.woocommerce-tabs.tabs-v2 .tab-item a.tab-header-title' )
            .on( 'click', '.woocommerce-tabs.tabs-v2 .tab-item a.tab-header-title', function( event ) {
                event.preventDefault();

                $(this).closest('.tab-item').find('.tabs-content-wrapper').addClass('active');
                $(this).closest('.woocommerce-tabs').find('.overlay-tabs').addClass('active');
            } );

            // $('.woocommerce-tabs.tabs-v2 .tab-item a.tab-header-title').on('click', function(){
            //     $(this).closest('.tab-item').find('.tabs-content-wrapper').addClass('active');
            //     $(this).closest('.woocommerce-tabs').find('.overlay-tabs').addClass('active');
            // });
            $('.overlay-tabs, .close-tab').on('click', function(){
                $('.woocommerce-tabs.tabs-v2 .tabs-content-wrapper').removeClass('active');
                $('.overlay-tabs').removeClass('active');
            });


            // Remove active tab
            $( 'body' ).on( 'init', '.apus-wc-tabs', function() {
                var hash  = window.location.hash;
                var url   = window.location.href;
                var $tabs = $( this );

                if ( hash.toLowerCase().indexOf( 'comment-' ) >= 0 || hash === '#reviews' || hash === '#tab-reviews' ) {
                    $tabs.find( '.reviews_tab a' ).trigger('click');
                } else if ( url.indexOf( 'comment-page-' ) > 0 || url.indexOf( 'cpage=' ) > 0 ) {
                    $tabs.find( '.reviews_tab a' ).trigger('click');
                } else if ( hash === '#tab-additional_information' ) {
                    $tabs.find( '.additional_information_tab a' ).trigger('click');
                }
            } );


            $('.delivery-shipping-info .item .item-btn').magnificPopup({
                mainClass: 'apus-mfp-zoom-in login-popup',
                type:'inline',
                midClick: true
            });

            var main_sticky = $('.add-to-cart-bottom-wrapper');
            if ( main_sticky.length > 0 && $('.details-product form.cart').length > 0 ){
                setTimeout(function(){
                    var height = main_sticky.outerHeight();
                    $('body.sticky-add-to-cart').css({
                        'margin-bottom': height + 'px'
                    });
                    var Apus_Add_To_Cart_Fixed = function(){
                        "use strict";
                        var fromBottom = $('.details-product form.cart').offset().top + $('.details-product form.cart').outerHeight();
                        if( $(document).scrollTop() > fromBottom ){
                            main_sticky.addClass('sticky');
                        } else {
                            main_sticky.removeClass('sticky');
                        }
                    }
                    if ($(window).width() > 991) {
                        $(window).scroll(function(event) {
                            Apus_Add_To_Cart_Fixed();
                        });
                        Apus_Add_To_Cart_Fixed();
                    }
                    
                }, 100);
            }

            if ($('.details-product .sticky-this').length > 0 ) {
                if ($(window).width() > 991) {
                    $('.details-product .sticky-this').stick_in_parent({
                        parent: ".product-v-wrapper"
                    });
                }
            }

        },
        initQuickview: function(){
            var self = this;
            $('body').on('click', 'a.quickview', function (e) {
                e.preventDefault();
                var $self = $(this);
                $self.addClass('loading');
                var product_id = $(this).data('product_id');
                var url = oworganic_woo_opts.ajaxurl.toString().replace( '%%endpoint%%', 'oworganic_quickview_product' ) + '&product_id=' + product_id;
                
                $.get(url,function(data,status){
                    $.magnificPopup.open({
                        mainClass: 'apus-mfp-zoom-in apus-quickview',
                        items : {
                            src : data,
                            type: 'inline'
                        },
                        callbacks: {
                            open: function() {
                                // variation
                                
                                if ( $('.apus-quickview').find('.slick-carousel').length ) {
                                    var $slick = $('.apus-quickview').find('.slick-carousel');
                                    if ( $slick.hasClass('slick-initialized')) {
                                        $slick.slick('refresh');
                                    } else {
                                        self.initSlick($slick);
                                    }
                                }
                                setTimeout(function(){
                                    self.layzyLoadImage();

                                    if ( typeof wc_add_to_cart_variation_params !== 'undefined' ) {
                                        $( '.variations_form' ).each( function() {
                                            $( this ).wc_variation_form().find('.variations select:eq(0)').trigger('change');
                                        });
                                    }
                                    if ( $.isFunction( $.fn.tawcvs_variation_swatches_form ) ) {
                                        $( '.variations_form' ).tawcvs_variation_swatches_form();
                                    }
                                }, 200);
                                
                                self.refresh_quantity_increments();

                                // setTimeout(function(){
                                //     var $max_heigh = $('.apus-mfp-zoom-in.apus-quickview .gallery-wrapper').outerHeight();
                                //     $('.apus-mfp-zoom-in.apus-quickview .information').css({'height': $max_heigh});
                                //     $('.apus-mfp-zoom-in.apus-quickview .information').perfectScrollbar();
                                // }, 100);
                            }
                        }
                    });
                    
                    $self.removeClass('loading');
                });
            });
        },
        initSwatches: function() {
            $( 'body' ).on( 'click', '.swatches-wrapper li a', function() {
                var $parent = $(this).closest('.product-block');
                var $image = $parent.find('.image img');
                $('.swatches-wrapper li a').removeClass('active');
                if ( $(this).attr( 'data-image_src' ) ) {
                    $image.attr('src', $(this).attr( 'data-image_src' ) );
                    $(this).addClass('active');
                }
                if ( $(this).attr( 'data-image_srcset' ) ) {
                    $image.attr('srcset', $(this).attr( 'data-image_srcset' ) );
                }
                if ( $(this).attr( 'data-image_sizes') ) {
                    $image.attr('sizes', $(this).attr( 'data-image_sizes' ) );
                }
            });
        },
        variationsImageUpdate: function( variation ) {
            var $form             = $('.variations_form'),
                $product          = $form.closest( '.product' ),
                $product_gallery  = $product.find( '.apus-woocommerce-product-gallery-wrapper' ),
                $gallery_img      = $product.find( '.apus-woocommerce-product-gallery-thumbs img:eq(0)' ),
                $product_img_wrap = $product_gallery.find( '.woocommerce-product-gallery__image, .woocommerce-product-gallery__image--placeholder' ).eq( 0 ),
                $product_img      = $product_img_wrap.find( '.wp-post-image' ),
                $product_link     = $product_img_wrap.find( 'a' ).eq( 0 );


            if ( variation && variation.image && variation.image.src && variation.image.src.length > 1 ) {
                
                if ( $( '.apus-woocommerce-product-gallery-thumbs img[src="' + variation.image.thumb_src + '"]' ).length > 0 ) {
                    $( '.apus-woocommerce-product-gallery-thumbs img[src="' + variation.image.thumb_src + '"]' ).trigger( 'click' );
                    $form.attr( 'current-image', variation.image_id );
                    return;
                } else {
                    $product_img.wc_set_variation_attr( 'src', variation.image.src );
                    $product_img.wc_set_variation_attr( 'height', variation.image.src_h );
                    $product_img.wc_set_variation_attr( 'width', variation.image.src_w );
                    $product_img.wc_set_variation_attr( 'srcset', variation.image.srcset );
                    $product_img.wc_set_variation_attr( 'sizes', variation.image.sizes );
                    $product_img.wc_set_variation_attr( 'title', variation.image.title );
                    $product_img.wc_set_variation_attr( 'alt', variation.image.alt );
                    $product_img.wc_set_variation_attr( 'data-src', variation.image.full_src );
                    $product_img.wc_set_variation_attr( 'data-large_image', variation.image.full_src );
                    $product_img.wc_set_variation_attr( 'data-large_image_width', variation.image.full_src_w );
                    $product_img.wc_set_variation_attr( 'data-large_image_height', variation.image.full_src_h );
                    $product_img_wrap.wc_set_variation_attr( 'data-thumb', variation.image.src );
                    $gallery_img.wc_set_variation_attr( 'src', variation.image.thumb_src );
                    $gallery_img.wc_set_variation_attr( 'srcset', variation.image.thumb_srcset );

                    $product_link.wc_set_variation_attr( 'href', variation.image.full_src );
                    $gallery_img.removeAttr('srcset');
                    if ( $('.apus-woocommerce-product-gallery').hasClass('slick-carousel') ) {
                        $('.apus-woocommerce-product-gallery').slick('slickGoTo', 0);
                    }
                }
            } else {
                $product_img.wc_reset_variation_attr( 'src' );
                $product_img.wc_reset_variation_attr( 'width' );
                $product_img.wc_reset_variation_attr( 'height' );
                $product_img.wc_reset_variation_attr( 'srcset' );
                $product_img.wc_reset_variation_attr( 'sizes' );
                $product_img.wc_reset_variation_attr( 'title' );
                $product_img.wc_reset_variation_attr( 'alt' );
                $product_img.wc_reset_variation_attr( 'data-src' );
                $product_img.wc_reset_variation_attr( 'data-large_image' );
                $product_img.wc_reset_variation_attr( 'data-large_image_width' );
                $product_img.wc_reset_variation_attr( 'data-large_image_height' );
                $product_img_wrap.wc_reset_variation_attr( 'data-thumb' );
                $gallery_img.wc_reset_variation_attr( 'src' );
                $product_link.wc_reset_variation_attr( 'href' );
            }

            window.setTimeout( function() {
                $( window ).trigger( 'resize' );
                $form.wc_maybe_trigger_slide_position_reset( variation );
                $product_gallery.trigger( 'woocommerce_gallery_init_zoom' );
            }, 20 );
        },
        initFilter: function() {
            var self = this;

            $('body').on('click', '.show-filter', function(e){
                e.preventDefault();
                $(".shop-top-sidebar-wrapper").toggle(300);
            });

            self.filterScrollbarsInit();
            $('body').on('click', '.shop-top-categories a', function(e) {
                e.preventDefault();
                self.shopGetPage($(this).attr('href'));
            });

            $('body').on('click', '.widget_product_categories a', function(e) {
                e.preventDefault();
                self.shopGetPage($(this).attr('href'));
            });
            $('body').on('click', '.woocommerce-widget-layered-nav-list a', function(e) {
                e.preventDefault();
                self.shopGetPage($(this).attr('href'));
            });
            $('body').on('click', '.apus-price-filter a', function(e) {
                e.preventDefault();
                self.shopGetPage($(this).attr('href'));
            });
            $('body').on('click', '.apus-product-sorting a', function(e) {
                e.preventDefault();
                self.shopGetPage($(this).attr('href'));
            });
            $('body').on('click', '.widget_orderby a', function(e) {
                e.preventDefault();
                self.shopGetPage($(this).attr('href'), false, true);
            });
            $('body').on('click', '.widget_product_tag_cloud a', function(e) {
                e.preventDefault();
                self.shopGetPage($(this).attr('href'), false, true);
            });

            $('body').on('change', '.orderby-wrapper select', function(){
                $('.orderby-wrapper form.woocommerce-ordering').trigger('submit');
            });

            $('body').on('submit', '.orderby-wrapper form.woocommerce-ordering', function (e) {
                e.preventDefault();
                var url = $(this).attr('action');

                var formData = $(this).find(":input").filter(function(index, element) {
                        return $(element).val() != '';
                    }).serialize();

                if( url.indexOf('?') != -1 ) {
                    url = url + '&' + formData;
                } else{
                    url = url + '?' + formData;
                }
                
                self.shopGetPage( url );
                return false;
            });

            $('body').on('click', '.shop-filter-top-wrapper aside .widget-title', function(){
                $(this).closest('aside').find(' .widget-title ').toggleClass('active');
                $(this).closest('aside').find(' .widget-title + * ').slideToggle();
            });


            // ajax pagination
            if ( $('.ajax-pagination').length ) {
                self.ajaxPaginationLoad();
            }
        },
        shopGetPage: function(pageUrl, isBackButton, isProductTag){
            var self = this;
            if (self.shopAjax) { return false; }
            
            if (pageUrl) {
                // Remove any visible shop notices
                //self.shopRemoveNotices();                                             
                
                // Set current shop URL (used to reset search and product-tag AJAX results)
                self.shopSetCurrentUrl(isProductTag);
                
                // Show 'loader' overlay
                self.shopShowLoader();
                
                // Make sure the URL has a trailing-slash before query args (301 redirect fix)
                pageUrl = pageUrl.replace(/\/?(\?|#|$)/, '/$1');
                
                // Set browser history "pushState" (if not back button "popstate" event)
                if (!isBackButton) {
                    self.setPushState(pageUrl);
                }
                
                self.shopAjax = $.ajax({
                    url: pageUrl,
                    data: {
                        'load_type': 'full',
                        '_preset': oworganic_woo_opts._preset
                    },
                    dataType: 'html',
                    cache: false,
                    headers: {'cache-control': 'no-cache'},
                    
                    method: 'POST', // Note: Using "POST" method for the Ajax request to avoid "load_type" query-string in pagination links
                    
                    error: function(XMLHttpRequest, textStatus, errorThrown) {
                        console.log('Apus: AJAX error - shopGetPage() - ' + errorThrown);
                        
                        // Hide 'loader' overlay (after scroll animation)
                        self.shopHideLoader();
                        
                        self.shopAjax = false;
                    },
                    success: function(response) {
                        // Update shop content
                        self.shopUpdateContent(response);
                        
                        self.shopAjax = false;
                    }
                });
                
            }
        },
        shopHideLoader: function(){
            $('body').find('#apus-shop-products-wrapper').removeClass('loading');
        },
        shopShowLoader: function(){
            $('body').find('#apus-shop-products-wrapper').addClass('loading');
        },
        setPushState: function(pageUrl) {
            window.history.pushState({apusShop: true}, '', pageUrl);
        },
        shopSetCurrentUrl: function(isProductTag) {
            var self = this;
            
            // Exclude product-tag page URL's
            if (!self.isProductTagUrl) {
                // Set current page URL
                self.searchAndTagsResetURL = window.location.href;
            }
            
            // Is the current URL a product-tag URL?
            self.isProductTagUrl = (isProductTag) ? true : false;
        },
        /**
         *  Shop: Update shop content with AJAX HTML
         */
        shopUpdateContent: function(ajaxHTML) {
            var self = this,
                $ajaxHTML = $('<div>' + ajaxHTML + '</div>'); // Wrap the returned HTML string in a dummy 'div' element we can get the elements
            
            // Page title - wp_title()
            var wpTitle = $ajaxHTML.find('#apus-wp-title').text();
            if (wpTitle.length) {
                // Update document/page title
                document.title = wpTitle;
            }
            
            // Extract elements
            var $categories = $ajaxHTML.find('.shop-top-categories'),
                $sidebar = $ajaxHTML.find('.shop-top-sidebar-wrapper'),
                $sidebar_left = $ajaxHTML.find('.shop-sidebar-left-wrapper'),
                $sidebar_right = $ajaxHTML.find('.shop-sidebar-right-wrapper'),
                $shop = $ajaxHTML.find('#apus-shop-products-wrapper');

            // Prepare/replace categories
            if ($categories.length) { 
                var $shopCategories = $('.shop-top-categories');
                
                $shopCategories.replaceWith($categories); 
            }

            // Prepare/replace sidebar filters
            if ($sidebar_left.length) {
                var $shopSidebar = $('.shop-sidebar-left-wrapper');
                $shopSidebar.replaceWith($sidebar_left);
                self.filterScrollbarsInit();
            }

            if ($sidebar_right.length) {
                var $shopSidebar = $('.shop-sidebar-right-wrapper');
                $shopSidebar.replaceWith($sidebar_right);
                self.filterScrollbarsInit();
            }
            
            // Replace shop
            if ($shop.length) {
                $('#apus-shop-products-wrapper').replaceWith($shop);
            }

            $("body").css("overflow-y", "initial");
            
            // Load images (init Unveil)
            self.layzyLoadImage();
            // Isoto Load
            self.initIsotope();
            // paging
            self.ajaxPaginationLoad();

            setTimeout(function() {
                // Hide 'loader' overlay (after scroll animation)
                self.shopHideLoader();
            }, 100);
        },
        filterScrollbarsInit: function() {
            $('.apus-woocommerce-widget-layered-nav .wrapper-limit').perfectScrollbar();
            $('.apus-widget_price_filter .wrapper-limit').perfectScrollbar();
            $('.apus_widget_product_sorting .wrapper-limit').perfectScrollbar();
            $('.widget_product_tag_cloud .tagcloud').perfectScrollbar();
        },
        /**
         *  Shop: Initialize infinite load
         */
        ajaxPaginationLoad: function() {
            var self = this,
                $infloadControls = $('.ajax-pagination'),                   
                nextPageUrl;
            
            // Used to check if "infload" needs to be initialized after Ajax page load
            self.shopInfLoadBound = true;
            
            
            self.infloadScroll = ($infloadControls.hasClass('infinite-action')) ? true : false;
            
            if (self.infloadScroll) {
                self.infscrollLock = false;
                
                var pxFromWindowBottomToBottom,
                    pxFromMenuToBottom = Math.round($(document).height() - $infloadControls.offset().top);
                    //bufferPx = 0;
                
                /* Bind: Window resize event to re-calculate the 'pxFromMenuToBottom' value (so the items load at the correct scroll-position) */
                var to = null;
                $(window).resize(function() {
                    if (to) { clearTimeout(to); }
                    to = setTimeout(function() {
                        pxFromMenuToBottom = Math.round($(document).height() - $infloadControls.offset().top);
                    }, 100);
                });
                
                $(window).scroll(function(){
                    if (self.infscrollLock) {
                        return;
                    }
                    
                    pxFromWindowBottomToBottom = 0 + $(document).height() - ($(window).scrollTop()) - $(window).height();
                    
                    // If distance remaining in the scroll (including buffer) is less than the pagination element to bottom:
                    if ((pxFromWindowBottomToBottom/* - bufferPx*/) < pxFromMenuToBottom) {
                        self.ajaxPaginationGet();
                    }
                });
            } else {
                var $productsWrap = $('body');
                
                /* Bind: "Load" button */
                $productsWrap.on('click', '#apus-shop-products-wrapper .apus-loadmore-btn', function(e) {
                    e.preventDefault();
                    self.ajaxPaginationGet();
                });
                
            }
            
            if (self.infloadScroll) {
                $(window).trigger('scroll'); // Trigger scroll in case the pagination element (+buffer) is above the window bottom
            }
        },
        /**
         *  Shop: AJAX load next page
         */
        ajaxPaginationGet: function() {
            var self = this;
            
            if (self.shopAjax) return false;
            
            // Remove any visible shop notices
            //self.shopRemoveNotices();
            
            // Get elements (these can be replaced with AJAX, don't pre-cache)
            var $nextPageLink = $('.apus-pagination-next-link').find('a'),
                $infloadControls = $('.ajax-pagination'),
                nextPageUrl = $nextPageLink.attr('href');
            
            if (nextPageUrl) {
                //nextPageUrl = self.updateUrlParameter(nextPageUrl, 'load_type', 'products');
                
                // Show 'loader'
                $infloadControls.addClass('apus-loader');
                
                self.shopAjax = $.ajax({
                    url: nextPageUrl,
                    data: {
                        load_type: 'products',
                        '_preset': oworganic_woo_opts._preset
                    },
                    dataType: 'html',
                    cache: false,
                    headers: {'cache-control': 'no-cache'},
                    method: 'GET',
                    error: function(XMLHttpRequest, textStatus, errorThrown) {
                        console.log('APUS: AJAX error - ajaxPaginationGet() - ' + errorThrown);
                    },
                    complete: function() {
                        // Hide 'loader'
                        $infloadControls.removeClass('apus-loader');
                    },
                    success: function(response) {
                        var $response = $('<div>' + response + '</div>'), $moreProducts = $response.children('.apus-products');
                        // add new products
                        
                        var $layout_type = $('.apus-shop-products-wrapper').data('layout_type');
                        if ( $layout_type == 'metro' ) {
                            var $new = $moreProducts.find('.isotope-item').appendTo($('.apus-shop-products-wrapper .products .isotope-items'));
                            
                            setTimeout(function(){
                                $('.apus-shop-products-wrapper').find('.isotope-items').isotope( 'insert', $new );    
                            }, 50);
                            
                        } else {
                            $('.apus-shop-products-wrapper .products .row-products-wrapper').append($moreProducts.html());
                        }


                        // Load images (init Unveil)
                        self.layzyLoadImage();
                        
                        // Get the 'next page' URL
                        nextPageUrl = $response.find('.apus-pagination-next-link').children('a').attr('href');
                        
                        if (nextPageUrl) {
                            $nextPageLink.attr('href', nextPageUrl);
                        } else {
                            $('.apus-shop-products-wrapper').addClass('all-products-loaded');
                            
                            if (self.infloadScroll) {
                                self.infscrollLock = true; // "Lock" scroll (no more products/pages)
                            }
                            $infloadControls.find('.apus-loadmore-btn').addClass('hidden');
                            $nextPageLink.removeAttr('href');
                        }
                        
                        self.shopAjax = false;
                        
                        if (self.infloadScroll) {
                            $(window).trigger('scroll'); // Trigger 'scroll' in case the pagination element (+buffer) is still above the window bottom
                        }
                    }
                });
            } else {
                if (self.infloadScroll) {
                    self.infscrollLock = true; // "Lock" scroll (no more products/pages)
                }
            }
        }
    });

    $.apusThemeExtensions.shop = $.apusThemeCore.woo_init;


    // gallery

    var ApusProductGallery = function( $target, args ) {
        var self = this;
        this.$target = $target;
        this.$images = $( '.woocommerce-product-gallery__image', $target );

        // No images? Abort.
        if ( 0 === this.$images.length ) {
            this.$target.css( 'opacity', 1 );
            return;
        }

        // Make this object available.
        $target.data( 'product_gallery', this );

        // Pick functionality to initialize...
        this.zoom_enabled       = $.isFunction( $.fn.zoom ) && wc_single_product_params.zoom_enabled;
        this.photoswipe_enabled = typeof PhotoSwipe !== 'undefined' && wc_single_product_params.photoswipe_enabled;

        // ...also taking args into account.
        if ( args ) {
            this.zoom_enabled       = false === args.zoom_enabled ? false : this.zoom_enabled;
            this.photoswipe_enabled = false === args.photoswipe_enabled ? false : this.photoswipe_enabled;
        }

        

        // Bind functions to this.
        this.initZoom             = this.initZoom.bind( this );
        this.initZoomForTarget    = this.initZoomForTarget.bind( this );
        this.initPhotoswipe       = this.initPhotoswipe.bind( this );
        this.getGalleryItems      = this.getGalleryItems.bind( this );
        this.openPhotoswipe       = this.openPhotoswipe.bind( this );

            this.$target.css( 'opacity', 1 );

        if ( this.zoom_enabled ) {
            this.initZoom();
            $target.on( 'woocommerce_gallery_init_zoom', this.initZoom );
        }

        if ( this.photoswipe_enabled ) {
            this.initPhotoswipe();
        }

        $('.apus-woocommerce-product-gallery').on('beforeChange', function(event, slick, currentSlide, nextSlide){
            self.initZoomForTarget( self.$images.eq(nextSlide) );
        });
    };


    /**
     * Init zoom.
     */
    ApusProductGallery.prototype.initZoom = function() {
        this.initZoomForTarget( this.$images.first() );
    };

    /**
     * Init zoom.
     */
    ApusProductGallery.prototype.initZoomForTarget = function( zoomTarget ) {

        if ( ! this.zoom_enabled ) {
            return false;
        }

        var galleryWidth = this.$target.width(),
            zoomEnabled  = false;

        $( zoomTarget ).each( function( index, target ) {
            var image = $( target ).find( 'img' );

            if ( image.data( 'large_image_width' ) > galleryWidth ) {
                zoomEnabled = true;
                return false;
            }
        } );

        // But only zoom if the img is larger than its container.
        if ( zoomEnabled ) {
            var zoom_options = {
                touch: false
            };

            if ( 'ontouchstart' in window ) {
                zoom_options.on = 'click';
            }

            zoomTarget.trigger( 'zoom.destroy' );
            zoomTarget.zoom( zoom_options );
        }
    };

    /**
     * Init PhotoSwipe.
     */
    ApusProductGallery.prototype.initPhotoswipe = function() {
        if ( this.$images.length > 0 ) {
            this.$target.prepend( '<a href="#" class="woocommerce-product-gallery__trigger"><i class="ti-fullscreen"></i></a>' );
            this.$target.on( 'click', '.woocommerce-product-gallery__trigger', this.openPhotoswipe );
        }
        //this.$target.on( 'click', '.woocommerce-product-gallery__image a', this.openPhotoswipe );
    };

    /**
     * Get product gallery image items.
     */
    ApusProductGallery.prototype.getGalleryItems = function() {
        var $slides = this.$images,
            items   = [];

        if ( $slides.length > 0 ) {
            $slides.each( function( i, el ) {
                var img = $( el ).find( 'img' ),
                    large_image_src = img.attr( 'data-large_image' ),
                    large_image_w   = img.attr( 'data-large_image_width' ),
                    large_image_h   = img.attr( 'data-large_image_height' ),
                    item            = {
                        src  : large_image_src,
                        w    : large_image_w,
                        h    : large_image_h,
                        title: img.attr( 'data-caption' ) ? img.attr( 'data-caption' ) : img.attr( 'title' )
                    };
                items.push( item );
            } );
        }

        return items;
    };

    /**
     * Open photoswipe modal.
     */
    ApusProductGallery.prototype.openPhotoswipe = function( e ) {
        e.preventDefault();

        var pswpElement = $( '.pswp' )[0],
            items       = this.getGalleryItems(),
            eventTarget = $( e.target ),
            clicked;

        if ( this.$target.find( '.woocommerce-product-gallery__image.slick-current' ).length > 0 ) {
            clicked = this.$target.find( '.woocommerce-product-gallery__image.slick-current' );
        } else {
            clicked = eventTarget.closest( '.woocommerce-product-gallery__image' );
        }
        var options = $.extend( {
            index: $( clicked ).index()
        }, wc_single_product_params.photoswipe_options );

        // Initializes and opens PhotoSwipe.
        var photoswipe = new PhotoSwipe( pswpElement, PhotoSwipeUI_Default, items, options );
        photoswipe.init();
    };

    /**
     * Function to call wc_product_gallery on jquery selector.
     */
    $.fn.apus_wc_product_gallery = function( args ) {
        new ApusProductGallery( this, args );
        return this;
    };

    /*
     * Initialize all galleries on page.
     */
    $( '.apus-woocommerce-product-gallery-wrapper' ).each( function() {
        $( this ).apus_wc_product_gallery();
    } );

    
})(jQuery);