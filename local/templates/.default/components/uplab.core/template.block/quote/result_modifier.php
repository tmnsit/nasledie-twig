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


$entryId = $insConfig->setEditLink($this, $codes_edit);

$twigData = [
	"quote_block" => [
		
			"items" => [[
				"attr" => " id=\"" . $this->GetEditAreaId($entryId) . "\" ",
				"icon" => [
					"name" => "64/quote",
					"size" => "large"
				],
				"text" => $data["short_text"]["~PREVIEW_TEXT"],
				"more_text" => [
					"text" => $data["text"]["~PREVIEW_TEXT"],
					"link" => [
						"before" => "Подробнее",
						"after" => "Скрыть"						
					]
				],
				"image" => [
					"src" => CFile::GetPath($data["img"]["PROPERTIES"]["FILE"]["VALUE"]),
					"alt" => "",
					"disable_lazy" => true
				],		
				"link" => [
					"href" => "javascript:void(0);",
					"text" => ""
				],
				"bottom" => [
					"text" => $data["name"]["~PREVIEW_TEXT"],
					"desc" => $data["position"]["~PREVIEW_TEXT"]
				]			
			]]
		]
	
];

$arResult["TEMPLATE_DATA"] = $twigData;
