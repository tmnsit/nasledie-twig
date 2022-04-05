<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Карьера");
?>

<?$APPLICATION->IncludeComponent(
	"uplab.core:template.block",
	"intro-detail",
	Array(
		"BANNER_CODE" => $APPLICATION->GetCurDir(),
		"CACHE_FOR_PAGE" => "N",
		"CACHE_TIME" => "3600000",
		"CACHE_TYPE" => "A",
		"DELAY" => "N",
		// "EXTRA_NAV_ITEM_ID" => $arResult["VARIABLES"]["ELEMENT_ID"],
	)
);?>

<?$APPLICATION->IncludeComponent(
	"uplab.core:template.block", 
	"agree", 
	array(
		"CACHE_FOR_PAGE" => "N",
		"CACHE_TIME" => "3600000",
		"CACHE_TYPE" => "A",
		"DELAY" => "N",
		"COMPONENT_TEMPLATE" => "agree",
		"BLOCK_TITLE" => "Карьера",
        "ELEMENT_CODE" => $APPLICATION->GetCurDir(),
	),
	false
);?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>