function pp_testimonial_equal_height( selector )
{
    var maxHeight = 0;
    $(selector).each(function(index) {
        if(($(this).outerHeight()) > maxHeight) {
            maxHeight = $(this).outerHeight();
        }
    });
    $(selector).css('height', maxHeight + 'px');
}
