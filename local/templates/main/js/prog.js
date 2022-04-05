$(function() {
	
	$(document).on("click", "[data-modal]", function() {
		if ($(this).data("title-job")) {
			var clear_title = $(this).data("title-job")
			var title = ' '+clear_title;
		}
		var bu = $(this).data("bu-id");
		var vacancy_id = $(this).data("vacancy-id");
		var selectorForm = $(this).attr("href");
		if (title) {
			$(selectorForm).find("h3.modal__head.h3").find("span").html(title);
		}
		if (bu) {
			var value = $(selectorForm).find("select").find('option[data-id="'+bu+'"]').attr("value");
			$(selectorForm).find("select").val(value);
			$(selectorForm).find("select").trigger("change");
		}
		if (vacancy_id) {
			$('input[data-vacancy-name-form]').val(clear_title+'|'+vacancy_id);
		}
	});
	
	$(document).on("click", "[data-tag-delete]", function() {
		if ($(".filter[data-filter-vacancy]").length) {
			$(".filter[data-filter-vacancy]").trigger("submit");
		}
	});
	$(document).on("change", ".filter[data-filter-vacancy] [data-select]", function(e) {
		if ($(".filter[data-filter-vacancy]").length) {
			$(".filter[data-filter-vacancy]").trigger("submit");
		}
	});
	
	
	$(document).on("click", "[data-search-box-result-item]", function() {
		if ($(".filter[data-filter-vacancy]").length) {
			$(".filter[data-filter-vacancy]").trigger("submit");
		}		
	});
	
	$(document).on("submit", "[data-filter-main]", function() {
		var $form = $(this);
		$form.find("select").removeAttr("name");
		$form.find("select").attr("disabled", "disabled");
	});
	
	$(document).on("click", "[share-fb]", function(e) {
		var purl = $(this).data("url");
		var ptitle = $(this).data("title");
		var text = $(this).data("text");
		var pimg = $(this).data("img");
		Share.facebook(purl, ptitle, pimg, text);
		e.preventDefault();
		return false;
	});
	
	$(document).on("click", "[share-vk]", function(e) {
		var purl = $(this).data("url");
		var ptitle = $(this).data("title");
		var text = $(this).data("text");
		var pimg = $(this).data("img");		
		Share.vkontakte(purl, ptitle, pimg, text);
		e.preventDefault();
		return false;
	});
	
	$(document).on("click", "[share-ok]", function(e) {
		var purl = $(this).data("url");
		var ptitle = $(this).data("title");
		var text = $(this).data("text");
		var pimg = $(this).data("img");	
		Share.odnoklassniki(purl, ptitle, pimg, text);
		e.preventDefault();
		return false;
	});
	
	$(document).on("click", "button[data-load-vacancy]", function(e) {
		var numPage = $(this).data("page")*1;
		var numCount = $(this).data("count")*1;
		var max_page = $(this).data("max-page")*1;
		var orderPage = $(this).data("order");
		
		$.ajax({
			url: "/vacancy/",
			data:{page:numPage, count:numCount, type: "vacancy", order: orderPage},
			success: function(result) {
				var html_cards = $(result.html).find(".filter-result__container").html();
				var pagination_text = $(result.html).find(".pagination-layout__text").html();
				var orderPageNew = $(result.html).find("button[data-load-vacancy]").data('order');
				console.log(orderPageNew);
				$(".filter-result__container").append(html_cards);
				$(".pagination-layout__text").html(pagination_text);
				$("button[data-load-vacancy]").data("page", numPage+1);
				$("button[data-load-vacancy]").data("order", orderPageNew);
				
				if (max_page == numPage) {
					$("button[data-load-vacancy]").hide();
				}
				window.dispatchEvent(new CustomEvent('reinit'));
				window.dispatchEvent(new CustomEvent('init.scrollAnimation'));
				window.dispatchEvent(new CustomEvent('init.cardAnimation'));
				window.dispatchEvent(new CustomEvent('init.lazyload'));		
				window.dispatchEvent(new CustomEvent('rellax:refresh'));		
				
				
						
			}
		});
		
		e.preventDefault();
		return false;
	});
	
	
	$(document).on("submit", "form[data-filter-vacancy]", function(e) {
		
		var $form = $(this);
		if ($(window).width()<=989) {
			var params = $("#filter-popup").find('select, textarea, input').serialize()+'&'+$form.find('input[name="query"], select[name="order"]').serialize();
		} else {
			var params = $form.serialize();
		}
		window.history.pushState(null, null, "?"+params); 	
		
		$.ajax({
			url: $form.attr("action"),
			data: params,
			success: function(result){
				var html_cards = $(result.html).find(".filter-result__container").html();
				var pagination_text = $(result.html).find(".pagination-layout__text").html();
				var result_title = $(result.html).find(".filter-result__title").html();
				var orderPageNew = $(result.html).find("button[data-load-vacancy]").data('order');
				
				$(".filter-result__container").html(html_cards);
				$(".pagination-layout__text").html(pagination_text);
				$(".filter-result__title").html(result_title);
				$("button[data-load-vacancy]").data("page", 2);
				
				var max_page = $(result.html).find("button[data-load-vacancy]").data("max-page")*1;
				$("button[data-load-vacancy]").data("order", orderPageNew);
				
				if (max_page == 1 || max_page == 0) {
					$("button[data-load-vacancy]").hide();
				} else {
					$("button[data-load-vacancy]").show();					
				}	
				window.dispatchEvent(new CustomEvent('reinit'));
				window.dispatchEvent(new CustomEvent('init.scrollAnimation'));
				window.dispatchEvent(new CustomEvent('init.cardAnimation'));
				window.dispatchEvent(new CustomEvent('init.lazyload'));	
				window.dispatchEvent(new CustomEvent('rellax:refresh'));							
			}
		});
		
		e.preventDefault();
		return false;
	});
		
	$(document).find(".filter-sidebar__content").find('input[type="checkbox"]').on("change", function() {
		$(this).closest("form").trigger("submit");
	});
});