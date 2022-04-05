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

$insConfig = Config::getInstance();

$arSlider = [];

$rnd = $this->randString();

$elementEdit = CIBlock::GetArrayByID($arParams['IBLOCK_ID'], 'ELEMENT_EDIT');
$elementDelete = CIBlock::GetArrayByID($arParams['IBLOCK_ID'], 'ELEMENT_DELETE');
	
foreach($arResult["ITEMS"] as $key => $arItem) {

	$entryId = $arItem['ID'] . $rnd;
	$this->AddEditAction($entryId, $arItem['EDIT_LINK'], $elementEdit);
	$this->AddDeleteAction($entryId, $arItem['DELETE_LINK'], $elementDelete);
		
	$arSliderItem = [
		"attr" => " id=\"" . $this->GetEditAreaId($entryId) . "\" ",
		"active" => ($key == 0 ? true : false),
		"heading" => $arItem["NAME"],
		"text" => $arItem["PREVIEW_TEXT"]
	];
	
	$arSlider[] = $arSliderItem;
}

$btn = $insConfig->getLink("faq_btn");

$entryId = $insConfig->setEditLink($this, ["faq_btn", "faq_title"]);

$twigData = [
	"accordion" => [
		"attr" => " id=\"" . $this->GetEditAreaId($entryId) . "\" ",
		"heading" => $insConfig->getTextValue("faq_title"),
		//"action" => [
		//	"text" => $btn["text"],
		//	"href" => $btn["href"],
		//	"attr" => "data-modal data-effect='mfp-move-from-right'"
		//],
		"items" => $arSlider,			
	]	
];

$arResult["TEMPLATE_DATA"] = $twigData;
