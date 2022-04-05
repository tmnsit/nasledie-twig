<?

use Bitrix\Main\Application;
use ProjectName\Local\Helper;
use Uplab\Core\Components\TemplateBlock;
use ProjectName\Local\Config;

defined("B_PROLOG_INCLUDED") && B_PROLOG_INCLUDED === true || die();
/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 * @var TemplateBlock $component
 */

// btn more
// $twigData["banksList"]["button"] = [
//     "theme" => "blue",
//     "text" => "Показать еще"
// ];

$key = 0;
$arSelect = Array("NAME", "PREVIEW_TEXT", "ID");
$arFilter = Array("IBLOCK_ID" => BANKS_IBLOCK, "ACTIVE" => "Y");
$res = CIBlockElement::GetList(Array("SORT" => "ASC"), $arFilter, false, false, $arSelect);
while ($ob = $res->GetNextElement()) {
    $arFields = $ob->GetFields();
    // $twigData["banksList"]["list"][$key]["button"]['theme'] = "blue-border-transparent";
    // $twigData["banksList"]["list"][$key]["button"]['text'] = "Подать заявку";
    // Props

    $res_prop = CIBlockElement::GetProperty(BANKS_IBLOCK, $arFields['ID']);
    while ($prop = $res_prop->GetNext()) {
        $props[$prop['CODE']] = $prop;
    }
    $arFields["PROPS"] = $props;
    if ($img = CFile::GetPath($arFields["PROPS"]["ICON"]['VALUE']))
    {
        $twigData["banksList"]["list"][$key]["img"]['src'] = $img;
        $twigData["banksList"]["list"][$key]["img"]['alt'] = $arFields['NAME'];
    }

    if($arFields["PROPS"]["SUM"]['VALUE']){
        $twigData["banksList"]["list"][$key]["payment"] = "от " . $arFields["PROPS"]["SUM"]['VALUE'] . "%";
    }

    if($arFields["PROPS"]["PERIOD"]['VALUE']){
        $twigData["banksList"]["list"][$key]["year"] = "до " . $arFields["PROPS"]["PERIOD"]['VALUE'] . "лет";
    }

    if($arFields["PROPS"]["RATE"]['VALUE']){
        $twigData["banksList"]["list"][$key]["bet"] = "от " . $arFields["PROPS"]["RATE"]['VALUE']  . "%";
    }

    if($arFields["PROPS"]["LINK"]['VALUE']){
        $twigData["banksList"]["list"][$key]["button"]['href'] = $arFields["PROPS"]["LINK"]['VALUE'];
    }
    $key++;
}

$twigData["creditCalculate"]["title"] = "Ипотечный калькулятор";
$arSelect = Array("IBLOCK_ID", "ID", "NAME", "PREVIEW_TEXT", "PREVIEW_PICTURE", "PROPERTY_RATE", "PROPERTY_PRICE_MIN", "PROPERTY_PRICE_MAX", "PROPERTY_PRICE_CURR", "PROPERTY_PERIOD_MIN", "PROPERTY_PERIOD_MAX", "PROPERTY_PERIOD_CURR");
$arFilter = Array("IBLOCK_ID" => CALCULATOR_IBLOCK, "CODE" => $arParams["CACL_CODE"], "ACTIVE" => "Y");
$res = CIBlockElement::GetList(Array("DATE_ACTIVE_FROM"=>"DESC"), $arFilter, false, false, $arSelect);
while($ob = $res->GetNextElement())
{
    $arFields = $ob->GetFields();
    $twigData["creditCalculate"]["percent"] = $arFields["PROPERTY_RATE_VALUE"];
    $twigData["creditCalculate"]["price"]["min"] = $arFields["PROPERTY_PRICE_MIN_VALUE"];
    $twigData["creditCalculate"]["price"]["max"] = $arFields["PROPERTY_PRICE_MAX_VALUE"];
    $twigData["creditCalculate"]["price"]["current"] = $arFields["PROPERTY_PRICE_CURR_VALUE"];
    $twigData["creditCalculate"]["year"]["min"] = $arFields["PROPERTY_PERIOD_MIN_VALUE"];
    $twigData["creditCalculate"]["year"]["max"] = $arFields["PROPERTY_PERIOD_MAX_VALUE"];
    $twigData["creditCalculate"]["year"]["current"] = $arFields["PROPERTY_PERIOD_CURR_VALUE"];
}

$twigData["creditCalculate"]["button"]["href"] = "#ipoteka-form";
$twigData["creditCalculate"]["button"]["fancybox"] = true;
$twigData["creditCalculate"]["button"]["theme"] = "blue";
$twigData["creditCalculate"]["button"]["text"] = "Подать заявку";

$arResult["TEMPLATE_DATA"] = $twigData;
