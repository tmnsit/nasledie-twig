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
	)
);?>

<?$APPLICATION->IncludeComponent(
	"uplab.core:template.block", 
	"catalog", 
	array(
		"CACHE_FOR_PAGE" => "N",
		"CACHE_TIME" => "3600000",
		"CACHE_TYPE" => "A",
		"DELAY" => "N",
		"COMPONENT_TEMPLATE" => "catalog",
	),
	false
);?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>