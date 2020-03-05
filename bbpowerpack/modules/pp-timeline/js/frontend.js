/**
 * This file should contain frontend logic for
 * all module instances.
 */
(function($) {
    $(document).ready(function(){
        if($('html').hasClass('fl-builder-edit') === false) {
            var $timeline_block = $('.pp-timeline-item');

            //hide timeline blocks which are outside the viewport
            $timeline_block.each(function(){
                $(this).find('.pp-timeline-content').addClass('pp-is-hidden');
                $(this).find('.pp-separator-arrow').addClass('pp-is-hidden');

                if($(this).offset().top <= $(window).scrollTop()+$(window).height()) {
                    $(this).find('.pp-timeline-content').removeClass('pp-is-hidden').addClass('pp-fade');
                    $(this).find('.pp-separator-arrow').removeClass('pp-is-hidden').addClass('pp-fade');
                }
            });

            //on scolling, show/animate timeline blocks when enter the viewport
            $(window).on('scroll', function(){
                $timeline_block.each(function(){
                    if( $(this).offset().top <= $(window).scrollTop()+$(window).height() && $(this).find('.pp-timeline-content').hasClass('pp-is-hidden') ) {
                        $(this).find('.pp-timeline-content').removeClass('pp-is-hidden').addClass('pp-fade');
                        $(this).find('.pp-separator-arrow').removeClass('pp-is-hidden').addClass('pp-fade');
                    }
                });
            });
        }
    });
})(jQuery);
