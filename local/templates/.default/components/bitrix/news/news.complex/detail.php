<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
?>

<?$APPLICATION->IncludeComponent(
	"uplab.core:template.block",
	"intro-detail",
	Array(
		"BANNER_CODE" => "news",
		"CACHE_FOR_PAGE" => "N",
		"CACHE_TIME" => "3600000",
		"CACHE_TYPE" => "A",
		"DELAY" => "N",
		"EXTRA_NAV_ITEM_ID" => $arResult["VARIABLES"]["ELEMENT_ID"],
	)
);?>

<?$APPLICATION->IncludeComponent("uplab.core:template.block", "news-detail", Array(
		"CACHE_FOR_PAGE" => "N",	// Добавить адрес страницы в кеш
		"CACHE_TIME" => "3600000",	// Время кеширования (сек.)
		"CACHE_TYPE" => "A",	// Тип кеширования
		"DELAY" => "N",	// Отложенное выполнение компонента,
		"ELEMENT_ID" => $arResult["VARIABLES"]["ELEMENT_ID"],
	),
	$component
);?>