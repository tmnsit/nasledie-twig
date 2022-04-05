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
if ($data["slider"]) {
	foreach($data["slider"]["PROPERTIES"]["SLIDER"]["VALUE"] as $key => $sLabel) {
		
		$number = $key+1;
		if ($number<10) {
			$number = '0'.$number;
		}
			
		$items[] = [
			"number" => $number,
			"text" => $sLabel["TEXT"],
			"heading" => $data["slider"]["PROPERTIES"]["SLIDER"]["DESCRIPTION"][$key]
		];		
	}
}

$factors = [];
if ($data["factors"]) {
	foreach($data["factors"]["PROPERTIES"]["LABELS"]["VALUE"] as $key => $sLabel) {
		
		$number = $key+1;
		if ($number<10) {
			$number = '0'.$number;
		}
			
		$factors[] = [
			"heading" => $sLabel,
			"text" => $data["factors"]["PROPERTIES"]["LABELS"]["DESCRIPTION"][$key]
		];		
	}
}

$entryId = $insConfig->setEditLink($this, $codes_edit);

$twigData = [
	"section_complex" => [
		"attr" => " id=\"" . $this->GetEditAreaId($entryId) . "\" ",
		"main" => [
			"heading" => $data["title"]["~PREVIEW_TEXT"],
			"lead" => Helper::subSting($data["lead"]["~PREVIEW_TEXT"], 110),
			"text" => Helper::subSting($data["text"]["~PREVIEW_TEXT"], 260),
			"image" => [
				"src" => CFile::GetPath($data["picture"]["PROPERTIES"]["FILE"]["VALUE"]),
				"alt" => $data["title"]["~PREVIEW_TEXT"]
			]
		]
	]	
];

if ($data["title_slider"]["~PREVIEW_TEXT"]) {
	$twigData["section_complex"]["slider"] = [
		"heading" => $data["title_slider"]["~PREVIEW_TEXT"],
		"items" => $items			
	];
}
if ($data["title_factor"]["~PREVIEW_TEXT"]) {
	$twigData["section_complex"]["factor"] = [
		"heading" => $data["title_factor"]["~PREVIEW_TEXT"],
		"factor_list" => [
			"items" => $factors			
		]		
	];
}
$arResult["TEMPLATE_DATA"] = $twigData;
