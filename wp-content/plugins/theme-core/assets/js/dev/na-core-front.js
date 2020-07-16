
(function ($) {
    "use strict";
    function customAttribute(){
        // Custom  }
        $( '.nano-custom-attribute > li' ).live( 'click', function(e) {
            e.preventDefault();

            var variation_value = $(this).data( 'value' ),
                selectId        = $(this).parent().data( 'attribute' ),
                select          = $( 'select#'+selectId );

            $(this).addClass( 'selected' ).siblings().removeClass( 'selected' );

            select.val( variation_value ).trigger( 'change' );
        } );

        $( '.variations_form' ).live( 'change', 'select[data-attribute_name]', function() {
            // Auto select option thas has only 1 choice availible
            setTimeout( function() {
                $( '.variations_form select[data-attribute_name]' ).each( function( i, e ) {
                    if ( $( e ).val() == '' && $( e ).children( '[value!=""]' ).length == 1 ) {
                        $( e ).val( $( e ).children( '[value!=""]' ).attr( 'value' ) ).trigger( 'change' );
                    }
                } );
            }, 50 );

            $( '.nano-custom-attribute[data-attribute]' ).each( function( i, e ) {
                ( function( e ) {
                    setTimeout( function() {
                        var option = $( e ).attr( 'data-attribute' ),
                            select = $( '#' + option );

                        $( e ).children().each( function( i2, e2 ) {
                            if ( select.children( '[value="' + $( e2 ).attr( 'data-value' ) + '"]' ).length == 1 ) {
                                $( e2 ).show();
                            } else {
                                $( e2 ).hide();
                            }
                        } );
                    }, 50 );
                } )( e );
            } );
        } );

        $( 'a.reset_variations' ).live( 'click',  function() {
            $( '.nano-custom-attribute' ).each( function( i, e ) {
                $( e ).find( 'li.selected' ).removeClass( 'selected' );
            } )
        } );
    }

    $(document).ready(function() {
        customAttribute();


        var paged = 1;
        //loadMore =====================================================================================================
        jQuery('.type-loadMore').each(function(){
            var loadMore_button      = jQuery('.wrapper-posts').find('#loadMore');
            loadMore_button.live('click', function(){
                paged++;
                var wrapper        = $('.wrapper-posts'),
                    number         = parseInt(wrapper.data( 'number' )),
                    cat            = wrapper.data( 'cat'),
                    col            = wrapper.data( 'col'),
                    ads            = wrapper.data( 'ads'),
                    pages          = wrapper.data( 'paged'),
                    layout         = wrapper.data( 'layout');
                $.ajax({
                    url: NaScript.ajax_url,
                    dataType: 'html',
                    type: 'POST',
                    data: {
                        action        : 'load_more_post',
                        number        : number,
                        cat           : cat,
                        paged         : paged,
                        col           : col,
                        ads           : ads,
                        layout        : layout
                    },
                    beforeSend: function() {
                        loadMore_button.addClass( 'loading' );
                    },
                    success:function(data) {
                        var val = $(data);
                        var $container =  $( '.wrapper-posts').find('.affect-isotope').isotope();
                        $container.append(val).isotope( 'appended', val );
                        $("img.lazy").lazyload();
                        setTimeout(function() {
                            $container.imagesLoaded().progress( function() {
                                $container.isotope('layout');
                            });
                        }, 100)

                        loadMore_button.removeClass( 'loading' );
                        if ( paged == pages ) {
                            loadMore_button.addClass( 'hidden' );
                        }
                    },

                    error: function(data){
                        console.log(data);
                    },
                });
                return false;
            });
        });
        //infinitescroll ===============================================================================================
        $('.type-infiniteScroll').each(function(){
            var win = $(window);
            var nextPage      = $('.wrapper-posts').find('#nextPage');
            function bindScroll(){
                if($(window).scrollTop() + $(window).innerHeight() > $(document).height() - 250) {
                    $(window).unbind('scroll');
                    loadMore();
                }
            }
            function loadMore()
            {
                paged++;
                var wrapper        = $('.wrapper-posts'),
                    number         = parseInt(wrapper.data( 'number' )),
                    cat            = wrapper.data( 'cat'),
                    col            = wrapper.data( 'col'),
                    pages          = wrapper.data( 'paged'),
                    ads            = wrapper.data( 'ads'),
                    layout         = wrapper.data( 'layout');

                $.ajax({
                    url: NaScript.ajax_url,
                    dataType: 'html',
                    type: 'POST',
                    data: {
                        action        : 'load_more_post',
                        number        : number,
                        cat           : cat,
                        paged         : paged,
                        col           : col,
                        ads           : ads,
                        layout        : layout
                    },
                    beforeSend: function() {
                        nextPage.addClass( 'loading' );
                    },
                    success:function(data) {
                        var val = $(data);
                        // Set Container
                        var $container =  $( '.wrapper-posts').find('.affect-isotope').isotope();
                        $container.append(val).isotope( 'appended', val );
                        $("img.lazy").lazyload();
                        setTimeout(function() {
                            $container.imagesLoaded().progress( function() {
                                $container.isotope('layout');
                            });
                        }, 100)

                        nextPage.removeClass( 'loading' );
                        $(window).bind('scroll', bindScroll);
                        if ( paged == pages ) {
                            nextPage.addClass( 'hidden' );
                        }
                    },
                    error: function(data){
                        console.log(data);
                    },
                });



            }
            $(window).scroll(bindScroll);
        });
        //loadCategory =====================================================================================================
        jQuery('.wrapper-filter .cat-item').each(function(){
            var loadMoreCat_button      = $('.wrapper-posts').find('#loadMoreCat');
            var loadMore_button         = $('.wrapper-posts').find('#loadMore');
            var $wrapper              = $( '.wrapper-posts').find('.tab-content');
            jQuery(this).live('click', function(){
                var wrapper        = $('.wrapper-posts'),
                    agr            = $('.wrapper-posts').find('.agr-loading'),
                    archive        = $('.wrapper-posts').find('.archive-blog'),
                    cat            = $(this).data( 'catfilter' ),
                    number         = parseInt(wrapper.data( 'number' )),
                    col            = wrapper.data( 'col'),
                    ads            = wrapper.data( 'ads'),
                    layout         = wrapper.data( 'layout');
                jQuery('.wrapper-filter .cat-item').parent().removeClass('active');
                jQuery(this).parent().addClass( 'active' );

                // RequestData ============================
                var requestData = {
                    action        : 'load_more_category',
                    number        : number,
                    cat           : cat,
                    col           : col,
                    ads           : ads,
                    layout        : layout
                };

                if(!jQuery(this).hasClass('loaded')){
                    $.ajax({
                        url: NaScript.ajax_url,
                        dataType: 'html',
                        type: 'POST',
                        data: requestData,
                        beforeSend: function() {
                            agr.addClass( 'post-loading' );
                            archive.addClass( 'archive-affect' );
                            return true;
                        },
                        success:function(data) {
                            agr.removeClass( 'post-loading' );
                            archive.removeClass( 'archive-affect');
                            ajaxResponse(data);
                        },
                        error: function(data){
                            console.log(data);
                        }
                    });
                }

                jQuery(this).not('.loaded').addClass('loaded');
                var $activeContent='allCat';
                if(jQuery(this).parent().hasClass('active')){
                    $activeContent = jQuery(this).data( 'catfilter' );
                }
                $wrapper.find('.archive-blog').removeClass('active');
                $wrapper.find('.archive-blog').removeClass('affect-isotope');
                $wrapper.find('#'+$activeContent).addClass('active').addClass('affect-isotope');;
                jQuery( '.wrapper-posts').find('.affect-isotope').isotope({
                    transitionDuration: '0.4s',
                    masonry: {
                        columnWidth:'.col-item'
                    },
                    fitWidth: true,
                });
            });

            function ajaxResponse(data) {
                var val                     = $(data);
                var $container              = $( '.wrapper-posts').find('.affect-isotope').isotope({
                    transitionDuration: '0.4s',
                    masonry: {
                        columnWidth:'.col-item'
                    },
                    fitWidth: true,
                });

                loadMore_button.addClass( 'hidden' );
                loadMoreCat_button.removeClass( 'hidden' );
                $wrapper.append(val).find('.affect-isotope').isotope({
                    transitionDuration: '0.4s',
                    masonry: {
                        columnWidth:'.col-item'
                    },
                    fitWidth: true,
                });
                $wrapper.find("img.lazy").lazyload({
                    threshold : 500
                });
                setTimeout(function() {
                    $container.imagesLoaded().progress( function() {
                        $container.isotope('layout');
                    });
                    $("img.lazy").lazyload({
                        threshold : 500
                    });
                }, 100)
            }

        });


        jQuery('.wrapper-filter').each(function(){
            var loadMoreCat_button      = $('.wrapper-posts').find('#loadMoreCat');
            var paged = 1;
            loadMoreCat_button.on('click', function(){
                jQuery('.wrapper-filter .cat-item').on('click', function(){
                    return paged = 1;
                });
                paged++;
                var pages= 1,
                    cat='',
                    number='9',
                    col='',
                    ads='',
                    layout='',
                    wrapperActive=jQuery('.wrapper-posts').find('.archive-blog.active');

                if(jQuery('.wrapper-posts').find('.archive-blog').hasClass('active')){
                        pages          = parseInt(wrapperActive.find('#filterPages').data('filter-pages')),
                        cat            = wrapperActive.find('#filterPages').data('filter-cat'),
                        number         = wrapperActive.find('#filterPages').data('filter-number'),
                        col            = jQuery('.wrapper-posts').data( 'col'),
                        ads            = jQuery('.wrapper-posts').data( 'ads'),
                        layout         = jQuery('.wrapper-posts').data( 'layout');
                }

                if(paged <= pages) {
                    $.ajax({
                        url: NaScript.ajax_url,
                        dataType: 'html',
                        type: 'POST',
                        data: {
                            action: 'load_more_post',
                            number: number,
                            cat: cat,
                            paged: paged,
                            col: col,
                            ads: ads,
                            layout: layout
                        },
                        beforeSend: function () {
                            loadMoreCat_button.addClass('loading');
                        },
                        success: function (response) {
                            var val2 = $(response);
                            var $container =  $( '.wrapper-posts').find('.affect-isotope').isotope({
                                transitionDuration: '0.4s',
                                masonry: {
                                    columnWidth:'.col-item'
                                },
                                fitWidth: true,
                            });
                            $container.append(val2).isotope( 'appended', val2 );
                            $("img.lazy").lazyload({
                                threshold : 500
                            });
                            setTimeout(function() {
                                $container.imagesLoaded().progress( function() {
                                    $container.isotope('layout');
                                });
                                $("img.lazy").lazyload({
                                    threshold : 500
                                });
                            }, 100)

                            loadMoreCat_button.removeClass('loading');

                            if (paged == pages) {
                                loadMoreCat_button.addClass('hidden');
                            }
                        },
                        error: function (data) {
                            console.log(data);
                        },
                    });
                    return false;
                }
                if (pages == '1') {
                    loadMoreCat_button.addClass('hidden');
                }
            });
        });
    });

})(jQuery);
