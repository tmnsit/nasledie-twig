<?
use Bitrix\Main\Application;
use ProjectName\Local\Helper;
use Uplab\Core\Components\TemplateBlock;
use ProjectName\Local\Config;

defined("B_PROLOG_INCLUDED") && B_PROLOG_INCLUDED === true || die();
/**
 * @global CMain      $APPLICATION
 * @var array         $arParams
 * @var array         $arResult
 * @var TemplateBlock $component
*/

$twigData["industrialConstruction"]["title"] = $arParams["BLOCK_TITLE"];
$twigData["industrialConstruction"]["text"] = $arParams["BLOCK_SUBTITLE"];


$arSelect = Array("IBLOCK_ID", "ID", "NAME", "PREVIEW_TEXT", "PROPERTY_ICON");
$arFilter = Array("IBLOCK_ID" => INDUSTRIALCONSTRUCTION_IBLOCK, "ACTIVE" => "Y");
$res = CIBlockElement::GetList(Array("DATE_ACTIVE_FROM"=>"DESC"), $arFilter, false, false, $arSelect);
while($ob = $res->GetNextElement())
{
    $arFields = $ob->GetFields();
    $arIndustrialConstruction[] = $arFields;
}

foreach ($arIndustrialConstruction as $key => $value) {
    $twigData["industrialConstruction"]["list"][$key]["title"] = $value["NAME"];
    $twigData["industrialConstruction"]["list"][$key]["text"] = $value["PREVIEW_TEXT"];
    $twigData["industrialConstruction"]["list"][$key]["img"]["src"] = CFile::GetPath($arFields["PROPERTY_ICON_VALUE"]);
    $twigData["industrialConstruction"]["list"][$key]["img"]["alt"] = $value["NAME"];
}

$arResult["TEMPLATE_DATA"] = $twigData;