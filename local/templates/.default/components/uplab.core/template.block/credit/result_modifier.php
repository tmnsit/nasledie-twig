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

$twigData["credit"]["title"] = $arParams["BLOCK_TITLE"];

$arSelect = Array("IBLOCK_ID", "ID", "NAME", "PREVIEW_TEXT", "PREVIEW_PICTURE", "PROPERTY_RATE", "PROPERTY_PRICE_MIN", "PROPERTY_PRICE_MAX", "PROPERTY_PRICE_CURR", "PROPERTY_PERIOD_MIN", "PROPERTY_PERIOD_MAX", "PROPERTY_PERIOD_CURR");
$arFilter = Array("IBLOCK_ID" => CALCULATOR_IBLOCK, "CODE" => $arParams["CACL_CODE"], "ACTIVE" => "Y");
$res = CIBlockElement::GetList(Array("DATE_ACTIVE_FROM"=>"DESC"), $arFilter, false, false, $arSelect);
while($ob = $res->GetNextElement())
{
    $arFields = $ob->GetFields();

    $twigData["credit"]["text"] = $arFields["PREVIEW_TEXT"];
    $twigData["credit"]["img"]["src"] = CFile::ResizeImageGet($arFields["PREVIEW_PICTURE"], array("width"=>715, "height"=>434), BX_RESIZE_IMAGE_PROPORTIONAL, true)["src"];
    $twigData["credit"]["img"]["alt"] = $arFields["NAME"];
    $twigData["credit"]["percent"] = $arFields["PROPERTY_RATE_VALUE"];
    $twigData["credit"]["price"]["min"] = $arFields["PROPERTY_PRICE_MIN_VALUE"];
    $twigData["credit"]["price"]["max"] = $arFields["PROPERTY_PRICE_MAX_VALUE"];
    $twigData["credit"]["price"]["current"] = $arFields["PROPERTY_PRICE_CURR_VALUE"];
    $twigData["credit"]["year"]["min"] = $arFields["PROPERTY_PERIOD_MIN_VALUE"];
    $twigData["credit"]["year"]["max"] = $arFields["PROPERTY_PERIOD_MAX_VALUE"];
    $twigData["credit"]["year"]["current"] = $arFields["PROPERTY_PERIOD_CURR_VALUE"];
}

$twigData["credit"]["button"]["href"] = "#ipoteka-form";
$twigData["credit"]["button"]["fancybox"] = true;
$twigData["credit"]["button"]["theme"] = "blue";
$twigData["credit"]["button"]["text"] = "Подать заявку";

$arResult["TEMPLATE_DATA"] = $twigData;