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

$rsData = CIBlockElement::GetList([], ["IBLOCK_ID" => CONFIGS_IBLOCK, "SECTION_CODE" => $arParams["SECTION_CODE"]]);
$data = [];
$codes_edit = [];
while($obElement = $rsData->GetNextElement()) {
	$arElement = $obElement->GetFields();
	$arElement["PROPERTIES"] = $obElement->GetProperties();
	$codes_edit[] = $arElement["CODE"];
	$code = str_replace($arParams["SECTION_CODE"].'_', "", $arElement["CODE"]);
	$data[$code] = $arElement;
}
$items = [];
if ($data["accordion"]) {
	foreach($data["accordion"]["PROPERTIES"]["SLIDER"]["~VALUE"] as $key => $sLabel) {
		
		$items[] = [
			"active" => false,
			"text" => $sLabel["TEXT"],
			"heading" => $data["accordion"]["PROPERTIES"]["SLIDER"]["DESCRIPTION"][$key]
		];		
	}
}


$entryId = $insConfig->setEditLink($this, $codes_edit);

$twigData = [
	"accordion" => [
		"attr" => " id=\"" . $this->GetEditAreaId($entryId) . "\" ",
		"heading" => $data["title"]["~PREVIEW_TEXT"],
		"items" => $items
	]	
];


$arResult["TEMPLATE_DATA"] = $twigData;
