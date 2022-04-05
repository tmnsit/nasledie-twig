<?
require($_SERVER['DOCUMENT_ROOT'].'/bitrix/header.php');
$APPLICATION->SetPageProperty("TITLE", "Наследие девелопмент");
$APPLICATION->SetTitle("Главная");
?>

<?$APPLICATION->IncludeComponent("uplab.core:template.block", "intro", Array(
		"CACHE_FOR_PAGE" => "N",	// Добавить адрес страницы в кеш
		"CACHE_TIME" => "3600000",	// Время кеширования (сек.)
		"CACHE_TYPE" => "A",	// Тип кеширования
		"DELAY" => "N",	// Отложенное выполнение компонента,
		"PAGE" => $APPLICATION->GetCurPage(),
	),
	false
);?>

<?$APPLICATION->IncludeComponent("uplab.core:template.block", "filter", Array(
		"CACHE_FOR_PAGE" => "N",	// Добавить адрес страницы в кеш
		"CACHE_TIME" => "3600000",	// Время кеширования (сек.)
		"CACHE_TYPE" => "A",	// Тип кеширования
		"DELAY" => "N",	// Отложенное выполнение компонента,
		"PAGE" => $APPLICATION->GetCurPage(),
	),
	false
);?>

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
		"BLOCK_TITLE" => "",
		"BTN_TEXT_DETAIL" => "",
		"BTN_CLASS" => "",
		"TAB_TYPES" => array(
			0 => "128",
		),
		"COUNT" => "2",
		"BLOCK_TITLE" => "Проекты"
	),
	false
);?>

<?/*
<?$APPLICATION->IncludeComponent(
	"uplab.core:template.block", 
	"project", 
	array(
		"CACHE_FOR_PAGE" => "N",
		"CACHE_TIME" => "3600000",
		"CACHE_TYPE" => "A",
		"DELAY" => "N",
		"COMPONENT_TEMPLATE" => "project",
		"BLOCK_TITLE" => "Проекты",
		"PAGE_SIZE" => "2",
	),
	false
);?>
*/?>

<?$APPLICATION->IncludeComponent(
	"uplab.core:template.block", 
	"about", 
	array(
		"CACHE_FOR_PAGE" => "N",
		"CACHE_TIME" => "3600000",
		"CACHE_TYPE" => "A",
		"DELAY" => "N",
		"COMPONENT_TEMPLATE" => "about",
		"BLOCK_TITLE" => "О компании",
		"TEXT_BTN" => "Подробнее о компании",
		"LINK_BTN" => "/about/"
	),
	false
);?>

<?$APPLICATION->IncludeComponent(
	"uplab.core:template.block", 
	"credit", 
	array(
		"CACHE_FOR_PAGE" => "N",
		"CACHE_TIME" => "3600000",
		"CACHE_TYPE" => "A",
		"DELAY" => "N",
		"COMPONENT_TEMPLATE" => "credit",
		"BLOCK_TITLE" => "Ипотека онлайн",
		"TEXT_BTN" => "Подать заявку",
		"LINK_BTN" => "#ipoteka-form",
		"CACL_CODE" => "kalkulyator-na-glavnoy"
	),
	false
);?>

<?$APPLICATION->IncludeComponent(
	"uplab.core:template.block", 
	"banks-offers", 
	array(
		"CACHE_FOR_PAGE" => "N",
		"CACHE_TIME" => "3600000",
		"CACHE_TYPE" => "A",
		"DELAY" => "N",
		"COMPONENT_TEMPLATE" => "banks-offers",
		"BLOCK_TITLE" => "Банковские предложения",
		"TEXT_BTN" => "Узнать подробнее",
		"LINK_BTN" => "/payment/"
	),
	false
);?>

<?$APPLICATION->IncludeComponent(
	"uplab.core:template.block", 
	"news", 
	array(
		"CACHE_FOR_PAGE" => "N",
		"CACHE_TIME" => "3600000",
		"CACHE_TYPE" => "A",
		"DELAY" => "N",
		"PAGE_SIZE" => "3",
		"PAGE" => $APPLICATION->GetCurPage(),
		"BLOCK_TITLE" => "Новости",
		"COMPONENT_TEMPLATE" => "news",
		"TEXT_MORE" => "Показать все",
		"LINK_MORE" => "/news/"
	),
	false
);?>

<?
require($_SERVER['DOCUMENT_ROOT'].'/bitrix/footer.php');
?>