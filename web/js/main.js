$(function(){
    var btn = $('#scrollUp');
    var scrollBtnIsvisible = false;
    var scrollerTriggerPoint = $('html, body').offset().top + 150;

    $(document).on('scroll', function() {
        var pos = $(window).scrollTop();
        if (pos > scrollerTriggerPoint && !scrollBtnIsvisible) {
            btn.stop().fadeIn();
            scrollBtnIsvisible = true;
        } else if (pos < scrollerTriggerPoint && scrollBtnIsvisible) {
            btn.stop().fadeOut();
            scrollBtnIsvisible = false;
        }
    }).scroll();

    btn.on('click', function(e) {
        e.preventDefault()
        $('html, body').animate({ scrollTop: 0 }, 300);
    });
});