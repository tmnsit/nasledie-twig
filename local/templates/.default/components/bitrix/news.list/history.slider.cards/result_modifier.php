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
			"alt" => $arItem["NAME"],
			"disable_lazy" => true
		],
		"text" => $arItem["PREVIEW_TEXT"],
		"note" => $arItem["PROPERTIES"]["NAME_ORG"]["VALUE"]
	];
	
				
	$arItems[] = $arTwigItem;
}

$entryId = $config->setEditLink($this, ["history_btn"]);

$twigData = [
	"slider_cards_layout" => [
		"heading" => $arParams["HEADING_BLOCK"],
		"attr" => " id=\"" . $this->GetEditAreaId($entryId) . "\" ",
		"card_name" => "^card-story",
		"cards" => $arItems,	
		"buttons" => []		
	]
];
if ($arParams["HIDE_BTN"]!="Y") {
	$btn = $config->getLink("history_btn");
	$twigData["slider_cards_layout"]["buttons"][] = [
		"theme" => "border-dark",
		"hover" => "white",
		"href" => $btn["href"],
		"text" => $btn["text"]		
	];
}

$arResult["TEMPLATE_DATA"] = $twigData;