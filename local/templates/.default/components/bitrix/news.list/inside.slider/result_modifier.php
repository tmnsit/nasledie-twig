<?
use Bitrix\Main\Application;
use EuroCement\Local\Helper;
use Uplab\Core\Components\TemplateBlock;
use EuroCement\Local\Config;

defined("B_PROLOG_INCLUDED") && B_PROLOG_INCLUDED === true || die();
/**
 * @global CMain      $APPLICATION
 * @var array         $arParams
 * @var array         $arResult
 * @var TemplateBlock $component
 */

$config = Config::getInstance();

$arSlider = [];

$rnd = $this->randString();

$elementEdit = CIBlock::GetArrayByID($arParams['IBLOCK_ID'], 'ELEMENT_EDIT');
$elementDelete = CIBlock::GetArrayByID($arParams['IBLOCK_ID'], 'ELEMENT_DELETE');
	
foreach($arResult["ITEMS"] as $arItem) {

	$entryId = $arItem['ID'] . $rnd;
	$this->AddEditAction($entryId, $arItem['EDIT_LINK'], $elementEdit);
	$this->AddDeleteAction($entryId, $arItem['DELETE_LINK'], $elementDelete);
		
	$arTwigItem = [
		"attr" => " id=\"" . $this->GetEditAreaId($entryId) . "\" ",

		"href" => $arItem["DETAIL_PAGE_URL"],
		"image" => [
			"src" => $arItem["PREVIEW_PICTURE"]["SRC"],
			"alt" => $arItem["NAME"]
		],
		"tags" => [
			[
				"href" => $arItem["DETAIL_PAGE_URL"],
				"text" => $arItem["PROPERTIES"]["TAG"]["VALUE"]
			]
		],
		"text" => $arItem["NAME"]
	];
	
	if ($arParams["HIDE_DATE"]!="Y") {
		$arTwigItem["notes"] = [[
			"text" => $arItem["DISPLAY_ACTIVE_FROM"]
		]];
	}
	
	
	$arItems[] = $arTwigItem;
}


$entryId = $config->setEditLink($this, [($arParams["CUSTOM_TITLE"]?$arParams["CUSTOM_TITLE"]:"main_inside_title"), "main_inside_btn"]);
$btn = $config->getLink("main_inside_btn");
$twigData = [
	"slider_cards_layout" => [
		"attr" => " id=\"" . $this->GetEditAreaId($entryId) . "\" ",
		"heading" => $config->getTextValue(($arParams["CUSTOM_TITLE"]?$arParams["CUSTOM_TITLE"]:"main_inside_title")),
		"card_name" => "^card-publication",
		"cards" => $arItems		
	]
];
if ($arParams["HIDE_BTN"] != "Y") {
	$twigData["slider_cards_layout"]["buttons"][] = [
		"theme" => "border-dark",
		"hover" => "white",
		"href" => $btn["href"],
		"text" => $btn["text"]		
	];
}

$arResult["TEMPLATE_DATA"] = $twigData;