BX = window.BX || {};

// BX.showWait = () => $(window).trigger('preloader:show');
// BX.hideHide = () => $(window).trigger('preloader:hide');

jQuery.fn.extend({
    scrollTo: function (offset, time, dst) {
        time = time || 600;
        offset = offset || 0;
        dst = dst || this.offset().top + offset;
        if (dst)
            $("html,body").animate({scrollTop: dst}, time);
        return this;
    }
});