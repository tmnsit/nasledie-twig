$(function() {
    console.log('filter');

    // $('.filter-vertical__form').prepend('<input type="hidden" name="page-size" value="1">');
    $('.filter-vertical__form').prepend('<input type="hidden" name="page-num" value="1"></input>');

    $(document).find('.filter-vertical__form').on('submit', function(e) {
        console.log('submit');
        var form = $(this);
        $(form).find('[name="page-num"]').val(1);
        var dataForm = $(form).serializeArray();
        // var dataForm = $(form).serialize();

        console.log(dataForm);

        $.ajax({
          method: "post",
          // dataType: "html",
          url: '/appartaments/index.php',
          data: {
            post: dataForm,
          },
          success: function success(result) {
              // console.log(result);
              var html = $(result).find('.catalog__list.more-list .catalog__item');
              var post = $(result).find('#ajax-wrap');
              // console.log(post);
              $(document).find('.catalog__list.more-list').html(html);
              $(document).find('#ajax-wrap').append(post);
          },
          error: function error(jqXHR, textStatus, errorThrown) {
            // console.log(textStatus);
          }
        });
    });

    // more
    $(document).find('.catalog__more-btn').on('click', function() {
      // console.log('show more');
      var form = $('.filter-vertical__form');
      var pageNum = $(form).find('[name="page-num"]').val();
      $(form).find('[name="page-num"]').val(parseInt(pageNum)+1);
      var dataForm = $(form).serializeArray();
      // console.log(dataForm);

      $('.catalog__content').addClass('load');
      setTimeout(function () {
        $('.catalog__content').removeClass('load');
      }, 1000);

      $.ajax({
        method: "post",
        // dataType: "html",
        url: '/appartaments/index.php',
        data: {
          post: dataForm,
        },
        success: function success(result) {
            // console.log(result);
            var html = $(result).find('.catalog__list.more-list .catalog__item');
            var post = $(result).find('#ajax-wrap');
            // console.log(post);
            $(document).find('.catalog__list.more-list').append(html);
            $(document).find('#ajax-wrap').append(post);
        },
        error: function error(jqXHR, textStatus, errorThrown) {
          // console.log(textStatus);
        }
      });

    });

    filterChange();
});

function filterChange() {
  var form = $('.filter-vertical__form');

  $('#price-filter-slider')[0].noUiSlider.on('end', function() {
    filterCount();
  });

  $('#square-filter-slider')[0].noUiSlider.on('end', function() {
    filterCount();
  });

  $(form).find('input[type="checkbox"]').on('change', function() {
    filterCount();
  });
}

function filterCount() {
  var form = $('.filter-vertical__form');
  var dataForm = $(form).serializeArray();
  console.log(dataForm);

  $.ajax({
    method: "post",
    // dataType: "html",
    url: '/local/ajax/filter-count.php',
    data: {
      post: dataForm,
    },
    success: function success(result) {
        console.log(result);
        $(form).find('.filter-vertical__submit').text(result);
    },
    error: function error(jqXHR, textStatus, errorThrown) {
      // console.log(textStatus);
    }
  });
}