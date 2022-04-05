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

$twigData["agree"]["title"] = $arParams["BLOCK_TITLE"];

if ($arParams["ELEMENT_CODE"]) {
    $arSelect = Array("NAME", "PREVIEW_TEXT");
    $arFilter = Array("IBLOCK_ID"=>PAGES_IBLOCK, "ACTIVE"=>"Y");
    $res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
    while($ob = $res->GetNextElement()){ 
        $arFields = $ob->GetFields();
        $twigData["agree"]["text"] = htmlspecialcharsBack($arFields["PREVIEW_TEXT"]);
    }
} else {
    $twigData["agree"]["text"] = htmlspecialcharsBack($arParams["TEXT_PAGE"]);
}

$arResult["TEMPLATE_DATA"] = $twigData;