$(function() {
    window.projectList = [];
	// $(document).find('.projects__nav .projects-nav__item.active .projects-nav__btn').click();
    $(document).find('.projects__nav .projects-nav__btn').on('click', function(e) {
        // console.log(e);
        // e.preventDefault();
        
		$.ajax({
			processData: false,
			contentType: false,
			type: "POST",
            url: '/local/ajax/filter-projects.php',
			// data: formData,
			success: function(result) {
                
				// projectList = [
				// 	{
				// 				date: "3 квартал 2022",
				// 				category: "Объекты социального назначения",
				// 				title: "ЖК Квартал лета",
				// 				price: "от 2 580 500 ₽",
				// 				city: "г. Ессентуки",
				// 				label: ["Комфорт-класс", "Комфорт-класс", "Комфорт-класс"],
				// 				button: {
				// 					href: "/",
				// 					text: "Узнать подробнее",
				// 					theme: "blue"
				// 				},
				// 				tags: ["Квартиры с ремонтом", "White box"],
				// 				img: {
				// 					src: "tmp/projects/1.png",
				// 					alt: "img"
				// 				},
				// 				text: "Высокий уровень вовлечения представителей целевой аудитории является четким доказательством простого факта: существующая теория требует анализа прогресса профессионального сообщества. Высокий уровень вовлечения представителей целевой аудитории является четким."
				// 				},
				// ];

			},
			error: function (jqXHR, textStatus, errorThrown) {z
                // console.log(textStatus);
			}
		});
		
		
		// return false;
    });
});