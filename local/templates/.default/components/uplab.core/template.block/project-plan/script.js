$(function() {
    $(document).find('.project-plan-filter__btn').on('click', function(e) {
        console.log('click');
        $(this).closest('.project-plan__filter').find('.project-plan-filter__btn').removeClass('active');
        $(this).addClass('active');

        var projectList = $(this).closest('.project-plan__filter').siblings('.project-plan__list');
        console.log(projectList);
        $(projectList).css('opacity', 0);

        var activeTab = $(this).text().trim();
        console.log(activeTab);
        console.log(window.location.pathname);
        var url = window.location.pathname;

        $.ajax({
            method: "post",
            dataType: "html",
            url: url,
            data: {
                activeTab: activeTab,
            },
            success: function success(result) {
                console.log(result);
                $(projectList).html();
                var html = $(result).find('.project-plan__list .project-plan__item');
                $(projectList).html(html);
                $(projectList).css('opacity', 1);
                // var post = $(result).find('#ajax-wrap');
                // $(list).html(html);
                // $(document).find('#ajax-wrap').append(post);
                // $(list).css('opacity', 1);
            },
            error: function error(jqXHR, textStatus, errorThrown) {
                // console.log(textStatus);
            }
        });

    });
});