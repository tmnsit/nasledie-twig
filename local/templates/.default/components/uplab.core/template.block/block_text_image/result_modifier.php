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

$factors = [];
if ($data["factors"]) {
	foreach($data["factors"]["PROPERTIES"]["LABELS"]["VALUE"] as $key => $sLabel) {
		$suffix = '';
		if (strpos($sLabel, "+")) {
			$suffix = '+';
			$sLabel = str_replace("+", "", $sLabel);
		}
		if (strpos($sLabel, "%")) {
			$suffix = '%';
			$sLabel = str_replace("%", "", $sLabel);
		}	
				
		$number = $key+1;
		if ($number<10) {
			$number = '0'.$number;
		}
			
		$factors[] = [
			"heading" => $sLabel,
			"suffix" => $suffix,
			"text" => $data["factors"]["PROPERTIES"]["LABELS"]["DESCRIPTION"][$key]
		];		
	}
}

$entryId = $insConfig->setEditLink($this, $codes_edit);

$twigData = [
	"block_text" => [
		"attr" => " id=\"" . $this->GetEditAreaId($entryId) . "\" ",
		"content" => [
			"text" => $data["text"]["~PREVIEW_TEXT"],
			"image" => [
				"src" => CFile::GetPath($data["picture"]["PROPERTIES"]["FILE"]["VALUE"]),
				"alt" => $data["title"]["~PREVIEW_TEXT"]
			]
		]
	]	
];

if ($arParams["BG"]) {
	$twigData["block_text"]["background_color"] = $arParams["BG"];
}


if ($factors) {
	$twigData["block_text"]["content"]["factor_list"] = [
		"layout" => 2,
		"items" => $factors			
	];
}
$arResult["TEMPLATE_DATA"] = $twigData;
