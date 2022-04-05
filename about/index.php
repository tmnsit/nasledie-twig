<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("TITLE", "О компании");
$APPLICATION->SetTitle("О компании");
?>

<?$APPLICATION->IncludeComponent(
	"uplab.core:template.block",
	"intro-detail",
	Array(
		"BANNER_CODE" => $APPLICATION->GetCurDir(),
		"CACHE_FOR_PAGE" => "N",
		"CACHE_TIME" => "3600000",
		"CACHE_TYPE" => "A",
		"DELAY" => "N"
	)
);?>

<div class="container">
    <div class="layout">
        <div class="layout__sidebar">
            <div class="layout__sidebar-wrapper">
                <?$APPLICATION->IncludeComponent("uplab.core:template.block", "sidebar", Array(
                        "CACHE_FOR_PAGE" => "N",	// Добавить адрес страницы в кеш
                        "CACHE_TIME" => "3600000",	// Время кеширования (сек.)
                        "CACHE_TYPE" => "A",	// Тип кеширования
                        "DELAY" => "N",	// Отложенное выполнение компонента,
                    ),
                    false
                );?>
            </div>
        </div>
        <div class="layout__content">
            <?$APPLICATION->IncludeComponent("uplab.core:template.block", "about-description", Array(
                    "CACHE_FOR_PAGE" => "N",	// Добавить адрес страницы в кеш
                    "CACHE_TIME" => "3600000",	// Время кеширования (сек.)
                    "CACHE_TYPE" => "A",	// Тип кеширования
                    "DELAY" => "N",	// Отложенное выполнение компонента,
                    "PAGE_SIZE" => 6,
                    "BLOCK_TITLE" => "О компании"
                ),
                false
            );?>

            <div id="leaving-projects">
                <?$APPLICATION->IncludeComponent(
	"uplab.core:template.block", 
	"projects", 
	array(
		"TYPE" => $activeItem,
		"CACHE_FOR_PAGE" => "N",
		"CACHE_TIME" => "3600000",
		"CACHE_TYPE" => "N",
		"DELAY" => "N",
		"COMPONENT_TEMPLATE" => "projects",
		"BLOCK_TITLE" => "Жилое строительство",
		"BTN_TEXT_DETAIL" => "",
		"BTN_CLASS" => "",
		"TAB_TYPES" => array(
			0 => "116",
		),
		"COUNT" => "2"
	),
	false
);?>
            </div>

            <?$APPLICATION->IncludeComponent(
                "uplab.core:template.block", 
                "industrial-construction", 
                array(
                    "CACHE_FOR_PAGE" => "N",
                    "CACHE_TIME" => "3600000",
                    "CACHE_TYPE" => "A",
                    "DELAY" => "N",
                    "COMPONENT_TEMPLATE" => "industrial-construction",
                    "BLOCK_TITLE" => "Преимущества компании",
                    "BLOCK_SUBTITLE" => "Наследие Девелопмент специализируется на строительно - монтажных работах объектов различной сложности, с обширной географией по всей стране."
                ),
                false
            );?>

            <div id="social-construction">
                <?$APPLICATION->IncludeComponent(
	"uplab.core:template.block", 
	"projects", 
	array(
		"TYPE" => $activeItem,
		"CACHE_FOR_PAGE" => "N",
		"CACHE_TIME" => "3600000",
		"CACHE_TYPE" => "N",
		"DELAY" => "N",
		"COMPONENT_TEMPLATE" => "projects",
		"BLOCK_TITLE" => "Объекты социального и промышленного назначения",
		"BTN_TEXT_DETAIL" => "",
		"BTN_CLASS" => "",
		"TAB_TYPES" => array(
			0 => "117",
			1 => "118",
		),
		"TAB_TYPES_FILTER" => array(
			0 => "128",
		),
		"COUNT" => "2"
	),
	false
);?>
            </div>

            <?/*
            <?$APPLICATION->IncludeComponent(
                "uplab.core:template.block", 
                "projects", 
                array(
                    "CACHE_FOR_PAGE" => "N",
                    "CACHE_TIME" => "3600000",
                    "CACHE_TYPE" => "A",
                    "DELAY" => "N",
                    "BLOCK_TITLE" => "Объекты социального и промышленного назначения",
                    "COMPONENT_TEMPLATE" => "projects",
                    "BTN_TEXT_DETAIL" => "Узнать подробнее",
                    "BTN_CLASS" => "blue",
                    "TAB_TYPES" => array(
                        0 => "129",
                        1 => "130",
                    )
                ),
                false
            );?>
            */?>

            <?$APPLICATION->IncludeComponent(
                "uplab.core:template.block", 
                "news", 
                array(
                    "CACHE_FOR_PAGE" => "N",
                    "CACHE_TIME" => "3600000",
                    "CACHE_TYPE" => "A",
                    "DELAY" => "N",
                    "PAGE_SIZE" => "2",
                    "COMPONENT_TEMPLATE" => "news",
                    "BLOCK_TITLE" => "Новости",
                    "TEXT_MORE" => "Показать все",
                    "LINK_MORE" => "/news/"
                ),
                false
            );?>
        </div>
    </div>
</div>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>