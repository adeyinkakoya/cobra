(function($) {
  "use strict";
    $=jQuery;
    jQuery(document).ready(function($){
       //Short Code 
        //$('.module-shortcode').fitVids();
        //$('.shortcode-widget-content').fitVids();
        $('.bk_accordions').each(function(){
            var accordions_id=$(this).attr('id');
            if(accordions_id){
                $('#'+accordions_id).accordion({
                    icons:{'header':'ui-icon-plus sprites','activeHeader':'ui-icon-minus sprites'},
                    collapsible:true
                });
            }
        });
        $('.bk_tabs').each(function(){
            var tabs_id=$(this).attr('id');
            if(tabs_id){
                $('#'+tabs_id).tabs();
            }
        });
            
        // Parallax
        // Single Parallax
        var bkscParallax = $('.bkparallaxsc');
        var bkscParallaxImg = new Array();
        $.each( bkscParallax, function( index, value ) {       
            bkscParallaxImg[index] = $(this).find('.parallaximage');
        });
        $(window).scroll(function() {
            $.each( bkscParallaxImg, function( index, value ) {       
                if ( bkscParallaxImg[index].length !== 0 ) {
                    //console.log(bkscParallaxImg.offset().top);
                    var bkBgy_p = -( ($(window).scrollTop() - bkscParallaxImg[index].offset().top) / 3.5),
                        bkBgPos = '50% ' + bkBgy_p + 'px';
                    bkscParallaxImg[index].css( "background-position", bkBgPos );
                }
            });
        }); 
    });
})(jQuery);