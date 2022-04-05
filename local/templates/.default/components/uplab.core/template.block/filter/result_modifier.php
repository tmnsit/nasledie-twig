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

$i = 0;

// project
if (1) {
    // group
    $projectsId = [];
    $arSelect = Array("PROPERTY_profit_project_id");
    $arFilter = Array("IBLOCK_ID"=>PROFITAPPARTAMENTS_IBLOCK, "ACTIVE"=>"Y");
    $res = CIBlockElement::GetList(Array(), $arFilter, ["PROPERTY_profit_project_id"], false, $arSelect);
    while($ob = $res->GetNextElement())
    {
        $arFields = $ob->GetFields();
        $projectsId[] = $arFields["PROPERTY_PROFIT_PROJECT_ID_VALUE"];
    }
    // mpr($projectsId, false);
    // projects
    $projects = [];
    $arSelect = Array("IBLOCK_ID", "ID", "NAME", "PROPERTY_profit_id");
    $arFilter = Array("IBLOCK_ID"=>PROJECTS_IBLOCK, "ACTIVE"=>"Y", "PROPERTY_profit_id" => $projectsId);
    $res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
    while($ob = $res->GetNextElement())
    {
        $arFields = $ob->GetFields();
        $projects[] = $arFields;
    }
    // mpr($projects, false);
    $twigData["filter"]["list"][$i]["id"] = "type-object";
    $twigData["filter"]["list"][$i]["title"] = "Выберите проект";
    $twigData["filter"]["list"][$i]["isSelect"] = true;
    $twigData["filter"]["list"][$i]["options"][0]["option"] = "Выберите проект";
    $twigData["filter"]["list"][$i]["options"][0]["value"] = "";
    foreach ($projects as $key => $value) {
        $twigData["filter"]["list"][$i]["options"][$key+1]["option"] = $value["NAME"];
        $twigData["filter"]["list"][$i]["options"][$key+1]["value"] = $value["PROPERTY_PROFIT_ID_VALUE"];
    }
    $i++;
}

// rooms
if (1) {
    // group
    $rooms = [];
    $arSelect = Array("PROPERTY_profit_property_price");
    $arFilter = Array("IBLOCK_ID"=>PROFITAPPARTAMENTS_IBLOCK, "ACTIVE"=>"Y");
    $res = CIBlockElement::GetList(Array(), $arFilter, ["PROPERTY_profit_rooms"], false, $arSelect);
    while($ob = $res->GetNextElement())
    {
        $arFields = $ob->GetFields();
        $rooms[] = $arFields["PROPERTY_PROFIT_ROOMS_VALUE"];
    }
    // rooms
    $twigData["filter"]["list"][$i]["title"] = "Выберите количество комнат";
    foreach ($rooms as $key => $value) {
        $twigData["filter"]["list"][$i]["checkboxs"][$key]["id"] = $value."-room";
        if ($value == "0") {
            $twigData["filter"]["list"][$i]["checkboxs"][$key]["text"] =  "Ст.";
        } else {
            $twigData["filter"]["list"][$i]["checkboxs"][$key]["text"] =  $value." к.";
        }
    }
    $i++;
}

// price
$minPrice = 0;
$arSelect = Array("IBLOCK_ID", "ID", "NAME", "PROPERTY_profit_property_price");
$arFilter = Array("IBLOCK_ID"=>PROFITAPPARTAMENTS_IBLOCK, "ACTIVE"=>"Y");
$res = CIBlockElement::GetList(Array("PROPERTY_profit_property_price" => "ASC"), $arFilter, false, Array("nPageSize"=>1), $arSelect);
while($ob = $res->GetNextElement())
{
    $arFields = $ob->GetFields();
    $minPrice = intval($arFields["PROPERTY_PROFIT_PROPERTY_PRICE_VALUE"]) / 1000000;
}
$maxPrice = 0;
$arSelect = Array("IBLOCK_ID", "ID", "NAME", "PROPERTY_profit_property_price");
$arFilter = Array("IBLOCK_ID"=>PROFITAPPARTAMENTS_IBLOCK, "ACTIVE"=>"Y");
$res = CIBlockElement::GetList(Array("PROPERTY_profit_property_price" => "DESC"), $arFilter, false, Array("nPageSize"=>1), $arSelect);
while($ob = $res->GetNextElement())
{
    $arFields = $ob->GetFields();
    $maxPrice = intval($arFields["PROPERTY_PROFIT_PROPERTY_PRICE_VALUE"]) / 1000000;
}
if ($minPrice && $maxPrice) {
    $twigData["filter"]["list"][$i]["title"] = "Желаемая стоимость, млн ₽";
    $twigData["filter"]["list"][$i]["id"] = "price-filter";
    $twigData["filter"]["list"][$i]["isSlider"] = true;
    $twigData["filter"]["list"][$i]["min"] = $minPrice;
    $twigData["filter"]["list"][$i]["max"] = $maxPrice;
    $i++;
}

// square
if (1) {
    $minSquare = 0;
    $arSelect = Array("PROPERTY_profit_area_living");
    $arFilter = Array("IBLOCK_ID"=>PROFITAPPARTAMENTS_IBLOCK, "ACTIVE"=>"Y");
    $res = CIBlockElement::GetList(Array("PROPERTY_profit_area_living" => "ASC"), $arFilter, false, Array("nPageSize"=>1), $arSelect);
    while($ob = $res->GetNextElement())
    {
        $arFields = $ob->GetFields();
        $minSquare = $arFields["PROPERTY_PROFIT_AREA_LIVING_VALUE"];
    }
    // mpr($minSquare, false);
    $maxSquare = 0;
    $arSelect = Array("PROPERTY_profit_area_living");
    $arFilter = Array("IBLOCK_ID"=>PROFITAPPARTAMENTS_IBLOCK, "ACTIVE"=>"Y");
    $res = CIBlockElement::GetList(Array("PROPERTY_profit_area_living" => "DESC"), $arFilter, false, Array("nPageSize"=>1), $arSelect);
    while($ob = $res->GetNextElement())
    {
        $arFields = $ob->GetFields();
        $maxSquare = $arFields["PROPERTY_PROFIT_AREA_LIVING_VALUE"];
    }
    // mpr($maxSquare, false);
    if ($minSquare && $maxSquare) {
        $twigData["filter"]["list"][$i]["title"] = "Желаемая площадь, м<sup>2</sup>";
        $twigData["filter"]["list"][$i]["id"] = "square-filter";
        $twigData["filter"]["list"][$i]["isSlider"] = true;
        $twigData["filter"]["list"][$i]["min"] = $minSquare;
        $twigData["filter"]["list"][$i]["max"] = $maxSquare;
        $i++;
    }
    $i++;
}

$arSelect = ["*", "PROPERTY_*"];
$arFilter = [
    "IBLOCK_ID"=>PROFITAPPARTAMENTS_IBLOCK, 
    "ACTIVE"=>"Y",
    "PROPERTY_profit_status" => "AVAILABLE"
];
// post filter merge
if (!empty($postFilter)) {
    $arFilter = array_merge($arFilter, $postFilter);
}

// mpr($arFilter, false);

$res_count = CIBlockElement::GetList(Array(), $arFilter, Array(), false, Array());
// btn show
$twigData["filter"]["button"]["href"] = "/appartaments/?";
$twigData["filter"]["button"]["theme"] = "black";
$twigData["filter"]["button"]["text"] = "Показать ".$res_count;

$arResult["TEMPLATE_DATA"] = $twigData;