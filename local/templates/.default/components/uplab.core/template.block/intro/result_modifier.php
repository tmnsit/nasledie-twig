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

$twigData["isMain"] = ($arParams["PAGE"] == "/") ? true : false ;

$arSelect = Array("IBLOCK_ID", "NAME", "PREVIEW_TEXT", "PREVIEW_PICTURE", "PROPERTY_LINK", "DETAIL_PICTURE");
$arFilter = Array("IBLOCK_ID" => MAINBANNER_IBLOCK, "ACTIVE" => "Y");
$res = CIBlockElement::GetList(Array("DATE_ACTIVE_FROM"=>"DESC"), $arFilter, false, Array("nPageSize"=>$arParams["PAGE_SIZE"]), $arSelect);
while($ob = $res->GetNextElement())
{
    $arFields = $ob->GetFields();
    $arFields["RES_PREVIEW_PICTURE"] = CFile::ResizeImageGet($arFields["PREVIEW_PICTURE"], array("width"=>1700, "height"=>923), BX_RESIZE_IMAGE_PROPORTIONAL, true);
    $arFields["RES_DETAIL_PICTURE"] = CFile::ResizeImageGet($arFields["DETAIL_PICTURE"], array("width"=>500, "height"=>860), BX_RESIZE_IMAGE_PROPORTIONAL, true);
    $slides[] = $arFields;
}

foreach ($slides as $key => $value) {
    // $twigData["intro"]["slider"][$key]["title"] = $value["NAME"];
    // $twigData["intro"]["slider"][$key]["text"] = $value["PREVIEW_TEXT"];
    $twigData["intro"]["slider"][$key]["img"]["desktop"]["src"] = $value["RES_PREVIEW_PICTURE"]["src"];
    $twigData["intro"]["slider"][$key]["img"]["mobile"]["src"] = $value["RES_DETAIL_PICTURE"]["src"];
    $twigData["intro"]["slider"][$key]["img"]["alt"] = $value["NAME"];

    // $twigData["intro"]["slider"][$key]["button"]["text"] = $value["NAME"];
    // $twigData["intro"]["slider"][$key]["button"]["href"] = $value["NAME"];    
}

$twigData["intro"]["popupLink"]["href"] = "#callback-form";
$twigData["intro"]["popupLink"]["fancybox"] = true;

$arResult["TEMPLATE_DATA"] = $twigData;