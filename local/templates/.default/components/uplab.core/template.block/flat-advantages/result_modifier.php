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

$project = $arParams["PROJECT"];
// mpr($project, false);
$twigData["flatAdvantages"]["title"] = ($project["PROPERTIES"]["PROPS_TITLE"]["VALUE"]) ? $project["PROPERTIES"]["PROPS_TITLE"]["VALUE"] : "Особености жилого комплекса" ;

// props
if ($project["PROPERTIES"]["PROPS_LINK"]["VALUE"]) {
    $arSelect = Array("IBLOCK_ID", "ID", "NAME", "PREVIEW_PICTURE", "PREVIEW_TEXT", "PROPERTY_ICON");
    $arFilter = Array("IBLOCK_ID" => PROPSOBJECTS_IBLOCK, "ID"=> $project["PROPERTIES"]["PROPS_LINK"]["VALUE"], "ACTIVE" => "Y");
    $res = CIBlockElement::GetList(Array("SORT"=>"ASC"), $arFilter, false, false, $arSelect);
    while($ob = $res->GetNextElement())
    {
        $arFields = $ob->GetFields();
        $value["PREVIEW_TEXT"] = htmlspecialcharsBack($value["PREVIEW_TEXT"]);
        $arFields["PREVIEW_PICTURE"] = ($arFields["PREVIEW_PICTURE"]) ? CFile::ResizeImageGet($arFields["PREVIEW_PICTURE"], array('width'=>1043, 'height'=>626), BX_RESIZE_IMAGE_EXACT, true)["src"] : "" ;
        $arFields["PROPERTY_ICON_VALUE"] = ($arFields["PROPERTY_ICON_VALUE"]) ? CFile::GetPath($arFields["PROPERTY_ICON_VALUE"]) : "/local/templates/.default/components/bitrix/news/projects/images/icon.svg" ;
        $project["PROPS_LINK"][] = $arFields;
    }
    foreach ($project["PROPS_LINK"] as $key => $value) {
        $twigData["flatAdvantages"]["list"][$key]["title"] = $value["NAME"];
        $twigData["flatAdvantages"]["list"][$key]["text"] = $value["PREVIEW_TEXT"];
        $twigData["flatAdvantages"]["list"][$key]["img"]["src"] = $value["PREVIEW_PICTURE"];
        $twigData["flatAdvantages"]["list"][$key]["img"]["alt"] = $value["NAME"];
        $twigData["flatAdvantages"]["list"][$key]["icon"] = $value["PROPERTY_ICON_VALUE"];
    }
}

// $twigData["flatAdvantages"]["list"][0]["nav"]["icon"] = "/upload/iblock/4f6/xujf84sbv5wjd0x6vl0pl3uroo5971x2.svg";
// mpr($project["PROPS_LINK"], false);

$arResult["TEMPLATE_DATA"] = $twigData;