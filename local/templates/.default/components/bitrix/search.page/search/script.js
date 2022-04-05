function searchQuery(obj) {
	var value = $(obj).val();
	console.log(value);
	$.ajax({
		url: "/search/",
		dataType: "json",
		type: "GET",
		data: {q: value},
		success: function(result) {
			
			$(".search-section__search").next("div").remove();
			
			var $result = $(result.html);
			if ($result.find(".search-section-popular").length == 1) {
				$(".search-section__search").after('<div class="search-section-popular mt-md-48 mt-40 mb-md-112 mb-64">'+$result.find(".search-section-popular").html()+'</div>');
			} else {
				$(".search-section__search").after('<div class="search-section__select bg-white bg-wings">'+$result.find(".search-section__select").html()+'</div>');	
			}
            window.dispatchEvent(new CustomEvent('init.scrollAnimation'));   
		}
	});	
}

$(function() {
	$(document).on("change", "[data-change-update-search]", function() {
		var $input = $(".search-form").find(".j-sort-value");
		if ($input.length) {
			$input.val($(this).val())
		} else {
			$(".search-form").prepend('<input type="hidden" name="ORDER" value="'+$(this).val()+'">');
		}
		$(".search-form").trigger("submit");
	});
	
	$(document).on("click", "[data-load-search-page]", function(e) {
		
		var url = $(this).data("next-url");
		
		$.ajax({
			url:url,
			success: function(result) {
				$(".search-result-item-list").append($(result.html).find(".search-result-item-list").html());
				$(".pagination-layout__text").find("span").text($(result.html).find(".pagination-layout__text").find("span").text());
				window.dispatchEvent(new CustomEvent('reinit'));
				window.dispatchEvent(new CustomEvent('init.scrollAnimation'));
				window.dispatchEvent(new CustomEvent('init.lazyload'));
				var newUrl = $(result.html).find("[data-next-url]").data("next-url");
				var hideBtn = $(result.html).find("[data-next-url]").data("hide-btn");
				$("[data-next-url]").data("next-url", newUrl);
				
				if (hideBtn) {
					$(".pagination-layout__button").find("button").hide();
				}								
			}
		})
		
		e.preventDefault();
		return false;
	});
});