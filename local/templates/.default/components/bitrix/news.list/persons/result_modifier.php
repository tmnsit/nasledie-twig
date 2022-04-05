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
		"reverse" => ($arItem["PROPERTIES"]["REVERSE"]["VALUE"] == "Да"?true:false),
		"heading" => $arItem["~NAME"],
		"text" => $arItem["PREVIEW_TEXT"],
		"button" => [
			"href" => $arItem["PROPERTIES"]["BTN"]["VALUE"],
			"text" => $arItem["PROPERTIES"]["BTN"]["DESCRIPTION"]
		],
		"image" => [
			"src" => $arItem["PREVIEW_PICTURE"]["SRC"],
			"alt" => $arItem["NAME"]
		]
	];
	
	
	$arItems[] = $arTwigItem;
}

$twigData = [
	"block_characters" => $arItems	
];

$arResult["TEMPLATE_DATA"] = $twigData;