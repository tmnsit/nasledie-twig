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

	"banner" => [
		"attr" => " id=\"" . $this->GetEditAreaId($entryId) . "\" ",
		"title" => $data["title"]["~PREVIEW_TEXT"],
		"text" => $data["text"]["~PREVIEW_TEXT"],
		"image" => [
			"src" => CFile::GetPath($data["img"]["PROPERTIES"]["FILE"]["VALUE"]),
			"alt" => "",
			"lazy" => true
		],
		"button" => [
			"theme" => "border-white",
			"hover" => "white",
			"text" => $data["btn"]["PROPERTIES"]["LINK"]["DESCRIPTION"],
			"href" => $data["btn"]["PROPERTIES"]["LINK"]["VALUE"]
		],
		"right"   => ($arParams["REVERSE"]=="Y"?false:true),
		"overlay" => true
	],
];

$arResult["TEMPLATE_DATA"] = $twigData;
