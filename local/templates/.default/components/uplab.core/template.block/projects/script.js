$(function() {
	$(document).find('.projects-nav__item').on('click', function(e) {
		var activeItem = $(this);
		var activeItemText = $(activeItem).text().trim();
		var list = $(this).closest('.projects__nav').siblings('.projects__list');
		$(list).css('opacity', 0);

    $(this).parent().find('.projects-nav__item').removeClass('active');
		$(this).addClass('active');
    $.ajax({
        method: "post",
        dataType: "html",
        url: '/projects/index.php',
        data: {
          activeItem: activeItemText,
        },
        success: function success(result) {
        // $(list).find('.projects__list').html();
          var html = $(result).find('.projects__list .projects__item');
          // var post = $(result).find('#ajax-wrap');
          $(list).html(html);
          // $(document).find('#ajax-wrap').append(post);
          $(list).css('opacity', 1);
        },
        error: function error(jqXHR, textStatus, errorThrown) {
          // console.log(textStatus);
        }
      });
	});
});