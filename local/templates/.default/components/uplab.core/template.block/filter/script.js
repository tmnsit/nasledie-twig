$(function() {
    filterChange();
})

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
  var dataStr = $(form).serialize();
  console.log(dataStr);

  $.ajax({
    method: "post",
    // dataType: "html",
    url: '/local/ajax/filter-count.php',
    data: {
      post: dataForm,
    },
    success: function success(result) {
        console.log(result);
        $(form).find('.filter__btn').text(result);
        var btnAttr = $(form).find('.filter__btn').attr('href');
        $(form).find('.filter__btn').attr('href', btnAttr+dataStr);
        
    },
    error: function error(jqXHR, textStatus, errorThrown) {
      // console.log(textStatus);
    }
  });
}