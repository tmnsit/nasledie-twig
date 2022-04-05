<?
use Bitrix\Main\Application;
use EuroCement\Local\Helper;
use Uplab\Core\Components\TemplateBlock;
use EuroCement\Local\Config;

defined("B_PROLOG_INCLUDED") && B_PROLOG_INCLUDED === true || die();	

$insConfig = Config::getInstance();
/**
 * @global CMain      $APPLICATION
 * @var array         $arParams
 * @var array         $arResult
 * @var TemplateBlock $component
 */
 

$breadcrumbs = $APPLICATION->GetNavChain(
	false,
	0,
	"/local/templates/.default/chain_template.php",
	true,
	false
);	

if (!$arResult["NAV_RESULT"]->NavRecordCount) {
	$arResult["NAV_RESULT"]->NavRecordCount = 0;
}
$twigData = [
	"hero" => [
		"breadcrumb" => $breadcrumbs,
		"heading" => "Рзультаты поиска по запросу «".$arResult["REQUEST"]["QUERY"]."»",
		"form" => [
			"action" => "/search/",
			"method" => "GET",
			"input" => [
				"placeholder" => "Поиск по сайту",
				"name" => "q",
				"attr" => ' value="'.$arResult["REQUEST"]["QUERY"].'"'
			]
		],
		"result_count" => "Найден".Helper::getEndWord($arResult["NAV_RESULT"]->NavRecordCount, ["","о","о"])." ".$arResult["NAV_RESULT"]->NavRecordCount.' результат'.Helper::getEndWord($arResult["NAV_RESULT"]->NavRecordCount),
		"search_filters" => [
			[
				"attr" => "data-change-update-search",
				"radio" => true,
				"name" => "ORDER",
				"theme" => "light",
				"value" => "RANK",
				"text" => "По релевантности",
				"checked" => ($arParams["DEFAULT_SORT"]=="rank"?true:false)
			],
			[
				"attr" => "data-change-update-search",
				"radio" => true,
				"name" => "ORDER",
				"theme" => "light",
				"value" => "DATE",
				"text" => "По дате обновления",
				"checked" => ($arParams["DEFAULT_SORT"]=="date"?true:false)
			]
		]		

	]	
];


$logo_white = $insConfig->getFileWithAlt("logo_white");
$logo_color = $insConfig->getFileWithAlt("logo_color");
$btn_contacts = $insConfig->getLink("link_contacts");


$content = [
	"logo" => [
		"src" => $logo_color["src"],
		"alter_src" => $logo_white["src"],
		"href" => "/",
		"alt" => $logo_color["alt"]		
	],
	"link_list" => [
		[
			"main" => true,
			"href" => "mailto:".$insConfig->getTextValue("email"),
			"text" => $insConfig->getTextValue("email")
		],
		$btn_contacts,
		[
			"href" => "#",
			"text" => "!"
		]		
	],	
];

$twigData["menu"]["content"] = $content;



$arItems = [];

foreach($arResult["SEARCH"] as $arItem) {

	$arDataItem = [
		"type" =>"section",
		"href" => $arItem["URL"],
		"date" => "",
		"heading" => $arItem["~TITLE_FORMATED"],
		"text" => (($arItem["~BODY_FORMATED"]!=' ....')?$arItem["~BODY_FORMATED"]:''),
		"path" => $arItem["CHAIN_PATH"],
		"extra" => [
			"href" => $arItem["URL"],
			"text" => $arItem["DATE_CHANGE"]
			
		]
	];
	$arItems[] = $arDataItem;
}

if (count($arItems) > 0) {

	$twigData["content"]["result_list"] = [
		"items" => $arItems
	];	

} 

if ($arPhrases = \Uplab\Core\Data\Search\SearchPhraseTable::getFreqPhrases()) {
	$arSearchPopular = [
		"heading" => "Популярные запросы",
		"items" => [],
	];
	foreach ($arPhrases as $arPhrase) {
		$arSearchPopular["items"][] = [
			"href" => "./?q={$arPhrase["PHRASE"]}",
			"text" => $arPhrase["PHRASE"],
		];
	}
} else {
	$arSearchPopular = [
		"heading" => "Популярные запросы"
	];
}

$twigData["content"]["popular_list"] = $arSearchPopular;

if ($arResult["REQUEST"]["QUERY"]) {
	$twigData["content"]["not_found"] = "По Вашему запросу ничего не найдено";	
}

$bNumNextPage = $arResult["NAV_RESULT"]->PAGEN;
$bCountCalc = $arResult["NAV_RESULT"]->PAGEN;
if ($bNumNextPage == 0) {
	$bNumNextPage = 0;
}
if ($bCountCalc == 0) {
	$bCountCalc = 1;
}

$maxCount = $arResult["NAV_RESULT"]->NavRecordCount;
$currentShowed = $bCountCalc*$arParams["PAGE_RESULT_COUNT"];
$bsiabledBtn = false;
if ($currentShowed >= $maxCount) {
	$currentShowed = $maxCount;
	$bsiabledBtn = true;
}

$nextUrl = $arParams["SEF_FOLDER"].'?PAGEN_'.$arResult["NAV_RESULT"]->NavNum.'='.($bNumNextPage+1).'&q='.$arResult["REQUEST"]["QUERY"].'&ORDER='.$arParams["ORDER_PARAM"];

$twigData["content"]["pagination_layout"] = [
	"button" => [
		"theme" => "border-dark",
		"text" => "Показать ещё",
		"attr" => " data-load-search-page data-next-url='".$nextUrl."' data-hide-btn='".$bsiabledBtn."' ".($bsiabledBtn?'style="display:none;"':'') 
	]
];
if ($arResult["NAV_RESULT"]->NavRecordCount) {
	$twigData["content"]["pagination_layout"]["text"] = "Показано ".($currentShowed)." из ".$maxCount;
} else {
	$twigData["content"]["not_found"] = "По Вашему запросу ничего не найдено";	
}

$arResult["TEMPLATE_DATA"] = $twigData;