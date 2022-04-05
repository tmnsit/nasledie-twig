$(function() {
	$(document).on("click", 'button[data-next-url]', function(e){
		
		var url = $(this).data("next-url");
		
		$.ajax({
			url: url,
			success: function(result) {
				$(".j-load-more-items").find(".card-story-list").append($(result.html).find(".card-story-list").html());
				window.dispatchEvent(new CustomEvent('reinit'));
				window.dispatchEvent(new CustomEvent('init.scrollAnimation'));
				window.dispatchEvent(new CustomEvent('init.lazyload'));
				$(".pagination-layout__text").find("span").text($(result.html).find(".pagination-layout__text").find("span").text());
				var newUrl = $(result.html).find("[data-next-url]").data("next-url");
				var hideBtn = $(result.html).find("[data-next-url]").data("hide-btn");
				$("[data-next-url]").data("next-url", newUrl);
				
				if (hideBtn) {
					$(".pagination-layout__button").find("button").hide();
				}
				
			}
		});
		
		e.preventDefault();
		return false;
	});
});