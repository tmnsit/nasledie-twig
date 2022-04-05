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
if ($data["numbers"]) {
	foreach($data["numbers"]["PROPERTIES"]["LABELS"]["~VALUE"] as $key => $sLabel) {
		$suffix = '';
		if (strpos($sLabel, "+")) {
			$suffix = '+';
			$sLabel = str_replace("+", "", $sLabel);
		}
		if (strpos($sLabel, "%")) {
			$suffix = '%';
			$sLabel = str_replace("%", "", $sLabel);
		}		
		
		$items[] = 
			[
				"separator" => " ",
				"heading" => $sLabel,
				"suffix" => $suffix,
				"text" => $data["numbers"]["PROPERTIES"]["LABELS"]["~DESCRIPTION"][$key]
			];		
	}
}

$entryId = $insConfig->setEditLink($this, $codes_edit);

$twigData = [
	"text_block" => [
		"attr" => " id=\"" . $this->GetEditAreaId($entryId) . "\" ",
		"heading" => Helper::subSting($data["title"]["~PREVIEW_TEXT"]),
		"content" => [
			"text" => Helper::subSting($data["text"]["~PREVIEW_TEXT"], 240),
			"factor_list" => [
				"items" => $items
			]
		]
	]	
];

$arResult["TEMPLATE_DATA"] = $twigData;
