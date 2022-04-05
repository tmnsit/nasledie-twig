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

// FINISHING_IBLOCK
if ($project["PROPERTIES"]["FINISHING_LINK"]["VALUE"]) {
    $sliderId = "finishing-section";
    
    if ($project["PROPERTIES"]["FINISHING_LINK"]["VALUE"]) {
        $twigData["projectSliders"][$sliderId]["id"] = $sliderId;
        $twigData["projectSliders"][$sliderId]["title"] = ($project["PROPERTIES"]["FINISHING_TITLE"]["VALUE"]) ? $project["PROPERTIES"]["FINISHING_TITLE"]["VALUE"] : "Отделка" ;
        $arSelect = Array("IBLOCK_ID", "ID", "NAME", "PREVIEW_PICTURE", "PROPPERTY_DESCRIPTION");
        $arFilter = Array("IBLOCK_ID" => FINISHING_IBLOCK, "ID"=> $project["PROPERTIES"]["FINISHING_LINK"]["VALUE"], "ACTIVE" => "Y");
        $res = CIBlockElement::GetList(Array("SORT"=>"ASC"), $arFilter, false, false, $arSelect);
        while($ob = $res->GetNextElement())
        {
            $arFields = $ob->GetFields();
            $arFields["PROPERTIES"] = $ob->GetProperties();

            $twigData["projectSliders"][$sliderId]["slides"][$arFields["ID"]]["img"]["src"] = ($arFields["PREVIEW_PICTURE"]) ? CFile::ResizeImageGet($arFields["PREVIEW_PICTURE"], array('width'=>1043, 'height'=>500), BX_RESIZE_IMAGE_EXACT, true)["src"] : "" ;
            $twigData["projectSliders"][$sliderId]["slides"][$arFields["ID"]]["img"]["alt"] = "alt";
            // mpr($arFields, false);
            // mpr($arFields["PROPERTIES"]["DESCRIPTION"], false);
            if ($arFields["PROPERTIES"]["DESCRIPTION"]["VALUE"]) {
                foreach ($arFields["PROPERTIES"]["DESCRIPTION"]["VALUE"] as $key => $value) {
                    // mpr($arFields["PROPERTIES"]["DESCRIPTION"]["PROPERTY_VALUE_ID"][$key], false);
                    $twigData["projectSliders"][$sliderId]["slides"][$arFields["ID"]]["description"][$arFields["PROPERTIES"]["DESCRIPTION"]["PROPERTY_VALUE_ID"][$key]]["id"] = "finishing-tab-".$sliderId."-".$arFields["PROPERTIES"]["DESCRIPTION"]["PROPERTY_VALUE_ID"][$key];
                    $twigData["projectSliders"][$sliderId]["slides"][$arFields["ID"]]["description"][$arFields["PROPERTIES"]["DESCRIPTION"]["PROPERTY_VALUE_ID"][$key]]["title"] = $arFields["PROPERTIES"]["DESCRIPTION"]["DESCRIPTION"][$key];
                    $twigData["projectSliders"][$sliderId]["slides"][$arFields["ID"]]["description"][$arFields["PROPERTIES"]["DESCRIPTION"]["PROPERTY_VALUE_ID"][$key]]["text"] = htmlspecialcharsBack($value["TEXT"]);
                }
            }
        }
    }
}

// ECOLOGY_IBLOCK
// if ($project["PROPERTIES"]["ECOLOGY_LINK"]["VALUE"]) {
//     $sliderId = "eco-section";
//     $twigData["flatAdvantages"]["projectSliders"] = [];
//     if ($project["PROPERTIES"]["ECOLOGY_LINK"]["VALUE"]) {
//         $twigData["projectSliders"][$sliderId]["id"] = $project["PROPERTIES"]["ECOLOGY_LINK"]["ID"];
//         $twigData["projectSliders"][$sliderId]["title"] = ($project["PROPERTIES"]["ECOLOGY_TITLE"]["VALUE"]) ? $project["PROPERTIES"]["ECOLOGY_TITLE"]["VALUE"] : "Отделка" ;

//         $arSelect = Array("IBLOCK_ID", "ID", "NAME", "PREVIEW_PICTURE", "PROPPERTY_DESCRIPTION");
//         $arFilter = Array("IBLOCK_ID" => ECOLOGY_IBLOCK, "ID"=> $project["PROPERTIES"]["ECOLOGY_LINK"]["VALUE"], "ACTIVE" => "Y");
//         $res = CIBlockElement::GetList(Array("SORT"=>"ASC"), $arFilter, false, false, $arSelect);
//         while($ob = $res->GetNextElement())
//         {
//             $arFields = $ob->GetFields();
//             $arFields["PROPERTIES"] = $ob->GetProperties();
//             $twigData["projectSliders"][$sliderId]["slides"][$arFields["ID"]]["img"]["src"] = ($arFields["PREVIEW_PICTURE"]) ? CFile::ResizeImageGet($arFields["PREVIEW_PICTURE"], array('width'=>1043, 'height'=>500), BX_RESIZE_IMAGE_EXACT, true)["src"] : "" ;
//             $twigData["projectSliders"][$sliderId]["slides"][$arFields["ID"]]["img"]["alt"] = "alt";
//             // mpr($arFields, false);
//             if ($arFields["PROPERTIES"]["DESCRIPTION"]["VALUE"]) {
//                 foreach ($arFields["PROPERTIES"]["DESCRIPTION"]["VALUE"] as $key => $value) {
//                     $twigData["projectSliders"][$sliderId]["slides"][$arFields["ID"]]["description"][$key]["id"] = "finishing-tab-".$sliderId."-".$key;
//                     $twigData["projectSliders"][$sliderId]["slides"][$arFields["ID"]]["description"][$key]["title"] = $arFields["PROPERTIES"]["DESCRIPTION"]["DESCRIPTION"][$key];
//                     $twigData["projectSliders"][$sliderId]["slides"][$arFields["ID"]]["description"][$key]["text"] = htmlspecialcharsBack($value["TEXT"]);
//                 }
//             }
//         }
//     }
// }

// mpr($twigData["projectSliders"], false);

$arResult["TEMPLATE_DATA"] = $twigData;