<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("TITLE", "Контакты");
$APPLICATION->SetTitle("Контакты");
use Bitrix\Main\Page\Asset;
$asset = Asset::getInstance();
$asset->addJs('https://api-maps.yandex.ru/2.1/?apikey=c4f68798-f377-470f-99b1-53b916be1aae&lang=ru_RU');
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

<?$APPLICATION->IncludeComponent(
    "uplab.core:template.block",
    "contacts",
    Array(
        "BANNER_CODE" => $APPLICATION->GetCurDir(),
        "CACHE_FOR_PAGE" => "N",
        "CACHE_TIME" => "3600000",
        "CACHE_TYPE" => "A",
        "DELAY" => "N"
    )
);?>

<?$APPLICATION->IncludeComponent(
    "uplab.core:template.block",
    "map",
    Array(
        "BANNER_CODE" => $APPLICATION->GetCurDir(),
        "CACHE_FOR_PAGE" => "N",
        "CACHE_TIME" => "3600000",
        "CACHE_TYPE" => "A",
        "DELAY" => "N"
    )
);?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>