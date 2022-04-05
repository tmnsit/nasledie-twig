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

$twigData["projects"]["title"] = $arParams["BLOCK_TITLE"];

// types
$arSelect = Array("ID", "NAME");
$arFilter = Array("IBLOCK_ID" => OBJECTTYPE_IBLOCK, "ACTIVE" => "Y", "ID" => $arParams["TAB_TYPES"]);
$res = CIBlockElement::GetList(Array("SORT"=>"ASC"), $arFilter, false, false, $arSelect);
while($ob = $res->GetNextElement())
{
    $arFields = $ob->GetFields();
    $projectsTypes[$arFields["ID"]] = $arFields;
}

if (count($arParams["TAB_TYPES"])>1) {
    $twigData["projects"]["navs"][0]["theme"] = "blue-border-transparent";
    $twigData["projects"]["navs"][0]["text"] = "Все проекты";
    if ($arParams["TYPE"] == "") {
        $twigData["projects"]["navs"][0]["active"] = true;
    }

    foreach ($projectsTypes as $key => $value) {
        if ($arParams["TYPE"] == $value["NAME"]) {
            $twigData["projects"]["navs"][$key]["active"] = true;
        }
        $twigData["projects"]["navs"][$key]["theme"] = "blue-border-transparent";
        $twigData["projects"]["navs"][$key]["text"] = $value["NAME"];
    }
} else {
    $arParams["TYPE"] = $projectsTypes[$arParams["TAB_TYPES"][0]]["NAME"];
}

// mpr($arParams["PAGE"], false);
if ($arParams["TAB_TYPES_FILTER"]) {
    $arFilter = Array(
        "IBLOCK_ID" => PROJECTS_IBLOCK, 
        "ACTIVE" => "Y", 
        "LOGIC" => "AND",
        "!PROPERTY_TYPE" => $arParams["TAB_TYPES_FILTER"],
        "PROPERTY_TYPE.NAME" => $arParams["TYPE"],
    );
} else {
    $arFilter = Array("IBLOCK_ID" => PROJECTS_IBLOCK, "ACTIVE" => "Y", "PROPERTY_TYPE.NAME" => $arParams["TYPE"]);
}

$arSelect = Array("IBLOCK_ID", "ID", "NAME", "PREVIEW_TEXT", "DETAIL_TEXT", "PREVIEW_PICTURE", "DETAIL_PAGE_URL", "PROPERTY_*");

$res = CIBlockElement::GetList(Array("SORT"=>"ASC"), $arFilter, false, ($arParams["COUNT"]) ? Array("nPageSize"=>$arParams["COUNT"]) : false , $arSelect);
while($ob = $res->GetNextElement())
{
    $arFields = $ob->GetFields();
    $arFields["PROPERTIES"] = $ob->GetProperties();
    $arFields["RES_PREVIEW_PICTURE"] = CFile::ResizeImageGet($arFields["PREVIEW_PICTURE"], array("width"=>1370, "height"=>574), BX_RESIZE_IMAGE_EXACT, true)["src"];
    $projectsItems[$arFields["ID"]] = $arFields;
}

foreach ($projectsItems as $key => $value) {
    $date = getdate(MakeTimeStamp($value["PROPERTIES"]["DEADLINE"]["VALUE"]));
    $kvartal = getCurrentQuartalNumber($date["mon"]);
    $twigData["projects"]["list"][$key]["date"] = ($value["PROPERTIES"]["DEADLINE"]["VALUE"]) ? $kvartal." ".$date["year"] : "Введен в эксплуатацию" ;
    $twigData["projects"]["list"][$key]["text"] = ($value["PREVIEW_TEXT"]) ? $value["PREVIEW_TEXT"] : $value["DETAIL_TEXT"] ;
    $twigData["projects"]["list"][$key]["title"] = $value["NAME"];
    $twigData["projects"]["list"][$key]["price"] = ($value["PROPERTIES"]["MIN_PRICE"]["VALUE"]) ? "от ".number_format($value["PROPERTIES"]["MIN_PRICE"]["VALUE"], 0, ",", " ")." ₽" : "" ;
    $twigData["projects"]["list"][$key]["city"] = $value["PROPERTIES"]["CITY"]["VALUE"];
    $twigData["projects"]["list"][$key]["img"]["src"] = $value["RES_PREVIEW_PICTURE"];
    $twigData["projects"]["list"][$key]["img"]["alt"] = $value["NAME"];

    if ($value["PROPERTIES"]["SHOW_DETAIL"]["VALUE"] == "Да") {
        $twigData["projects"]["list"][$key]["button"]["href"] = $value["DETAIL_PAGE_URL"];
        $twigData["projects"]["list"][$key]["button"]["text"] = "Узнать подробнее";
        $twigData["projects"]["list"][$key]["button"]["theme"] = "blue";
    }

    // mpr($value["PROPERTIES"]["TYPE"]["VALUE"], false);
    if ($value["PROPERTIES"]["TYPE"]["VALUE"]) {
        $type = \Bitrix\Iblock\ElementTable::getById($value["PROPERTIES"]["TYPE"]["VALUE"]);
        // if (method_exists($type, "getName")) {
            $name = $type->fetchObject()->getName();
            $twigData["projects"]["list"][$key]["category"] = $name;
        // }
    } else {
        $twigData["projects"]["list"][$key]["category"] = "";
    }

    if ($value["PROPERTIES"]["YELLOW_NAMEPLATE"]["VALUE"]) {
        foreach ($value["PROPERTIES"]["YELLOW_NAMEPLATE"]["VALUE"] as $id) {
            $nameplate = \Bitrix\Iblock\ElementTable::getById($id);
            // if (method_exists($nameplate, "getName")) {
                $name = $nameplate->fetchObject()->getName();
                $twigData["projects"]["list"][$key]["label"][] = $name;
            // }
        }
    } else {
        $twigData["projects"]["list"][$key]["label"] = [];
    }
    if ($value["PROPERTIES"]["WHITE_NAMEPLATE"]["VALUE"]) {
        foreach ($value["PROPERTIES"]["WHITE_NAMEPLATE"]["VALUE"] as $id) {
            $nameplate = \Bitrix\Iblock\ElementTable::getById($id);
            // if (method_exists($nameplate, "getName")) {
                $name = $nameplate->fetchObject()->getName();
                $twigData["projects"]["list"][$key]["tags"][] = $name;
            // }
        }
    } else {
        $twigData["projects"]["list"][$key]["tags"] = [];
    }
}

$arResult["TEMPLATE_DATA"] = $twigData;