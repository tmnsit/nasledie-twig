<?
use Bitrix\Main\Application;
use EuroCement\Local\Helper;
use Uplab\Core\Components\TemplateBlock;

defined("B_PROLOG_INCLUDED") && B_PROLOG_INCLUDED === true || die();
/**
 * @global CMain      $APPLICATION
 * @var array         $arParams
 * @var array         $arResult
 * @var TemplateBlock $component
 */



$rnd = $this->randString();

$elementEdit = CIBlock::GetArrayByID($arParams['IBLOCK_ID'], 'ELEMENT_EDIT');
$elementDelete = CIBlock::GetArrayByID($arParams['IBLOCK_ID'], 'ELEMENT_DELETE');

foreach($arResult["ITEMS"] as $arItem) {

	$entryId = $arItem['ID'] . $rnd;
	$this->AddEditAction($entryId, $arItem['EDIT_LINK'], $elementEdit);
	$this->AddDeleteAction($entryId, $arItem['DELETE_LINK'], $elementDelete);
		
	$arTwigItem = [
		"attr" => " id=\"" . $this->GetEditAreaId($entryId) . "\" ",
		"heading" => $arItem["NAME"],
		"href" => $arItem["DETAIL_PAGE_URL"],
		"image" => [
			"src" => $arItem["PREVIEW_PICTURE"]["SRC"],
			"alt" => $arItem["NAME"]
		],
		"text" => ($arItem["PREVIEW_TEXT"]?$arItem["PREVIEW_TEXT"]:$arItem["DISPLAY_ACTIVE_FROM"]),
		"note" => ($arItem["PROPERTIES"]["NAME_ORG"]["VALUE"]?$arItem["PROPERTIES"]["NAME_ORG"]["VALUE"]:$arItem["PROPERTIES"]["TAG"]["VALUE"])
	];
	
				
	$arItems[] = $arTwigItem;
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
$currentShowed = $bCountCalc*$arParams["NEWS_COUNT"];
$bsiabledBtn = false;
if ($currentShowed >= $maxCount) {
	$currentShowed = $maxCount;
	$bsiabledBtn = true;
}

$nextUrl = $arParams["IBLOCK_URL"].'?PAGEN_'.$arResult["NAV_RESULT"]->NavNum.'='.($bNumNextPage+1);
$twigData = [
	"card_story_list" => [
		"items" => $arItems,	
		"pagination_layout" => [
			"button" => [
				"theme" => "border-dark",
				"hover" => "white",
				"text" => "Показать ещё",
				"attr" => " data-some-additional-attributes='' data-next-url='".$nextUrl."' data-hide-btn='".$bsiabledBtn."' ".($bsiabledBtn?'style="display:none;"':'') 
			],
			"text" => "Показано ".($currentShowed)." из ".$maxCount
		]	
	]
];
$arResult["TEMPLATE_DATA"] = $twigData;
