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
$twigData["projectPlan"]["title"] = ($project["PROPERTIES"]["FLAT_TITLE"]["VALUE"]) ? $project["PROPERTIES"]["FLAT_TITLE"]["VALUE"] : "Варианты планировок" ;

$rooms = [];
$twigData["projectPlan"]["filter"]["buttons"][0]["theme"] = "blue-border-transparent";
$twigData["projectPlan"]["filter"]["buttons"][0]["text"] = "Все планировки";
$twigData["projectPlan"]["filter"]["buttons"][0]["attr"] = "data-rooms='все'";
$i=1;
$arSelect = Array("PROPERTY_profit_rooms");
$arFilter = Array("IBLOCK_ID"=>PROFITAPPARTAMENTS_IBLOCK, "ACTIVE"=>"Y");
$res = CIBlockElement::GetList(Array(), $arFilter, ["PROPERTY_profit_rooms"], false, $arSelect);
while($ob = $res->GetNextElement())
{
    $arFields = $ob->GetFields();
    if (intval($arFields["CNT"]) > 0) {
        $twigData["projectPlan"]["filter"]["buttons"][$i]["theme"] = "blue-border-transparent";
        $twigData["projectPlan"]["filter"]["buttons"][$i]["text"] = $arFields["PROPERTY_PROFIT_ROOMS_VALUE"]." комнатные";
        $twigData["projectPlan"]["filter"]["buttons"][$i]["attr"] = "data-rooms='".$arFields["PROPERTY_PROFIT_ROOMS_VALUE"]."-комнатные'";
        $i++;
    }
    $rooms[$arFields["PROPERTY_PROFIT_ROOMS_VALUE"]] = $arFields;
    
}
// mpr($rooms, false);

if ($arParams["ACTIVE_TAB"] == "" || !$arParams["ACTIVE_TAB"]) {
    $countRoom = 3;
    foreach ($rooms as $keyRoom => $valueRoom) {
        $arSelect = Array("*", "PROPERTY_*");
        $arFilter = Array("IBLOCK_ID"=>PROFITAPPARTAMENTS_IBLOCK, "ACTIVE"=>"Y", "PROPERTY_profit_rooms"=>$valueRoom["PROPERTY_PROFIT_ROOMS_VALUE"]);
        $res = CIBlockElement::GetList(Array("PROPERTY_profit_property_price" => "ASC"), $arFilter, false, Array("nPageSize"=>$countRoom), $arSelect);
        while($ob = $res->GetNextElement())
        {
            $arFields = $ob->GetFields();
            $arFields["PROPERTIES"] = $ob->GetProperties();
            $arFields["RES_PICTURE"] = CFile::ResizeImageGet($arFields['DETAIL_PICTURE'], array('width'=>1000, 'height'=>1000), BX_RESIZE_IMAGE_PROPORTIONAL, true)["src"];
            $flats[] = $arFields;
        }
    }
} else {
    $countRoom = 9;
    $activeTab = preg_replace("/[^0-9]/", '', $arParams["ACTIVE_TAB"]);
    $arSelect = Array("*", "PROPERTY_*");
    $arFilter = Array("IBLOCK_ID"=>PROFITAPPARTAMENTS_IBLOCK, "ACTIVE"=>"Y", "PROPERTY_profit_rooms"=>$activeTab);
    $res = CIBlockElement::GetList(Array("PROPERTY_profit_property_price" => "ASC"), $arFilter, false, Array("nPageSize"=>$countRoom), $arSelect);
    while($ob = $res->GetNextElement())
    {
        $arFields = $ob->GetFields();
        $arFields["PROPERTIES"] = $ob->GetProperties();
        $arFields["RES_PICTURE"] = CFile::ResizeImageGet($arFields['DETAIL_PICTURE'], array('width'=>1000, 'height'=>1000), BX_RESIZE_IMAGE_PROPORTIONAL, true)["src"];
        $flats[] = $arFields;
    }
}
// mpr($flats, false);

foreach ($flats as $key => $value) {
    $twigData["projectPlan"]["list"][$value["ID"]]["id"] = $value["ID"];
    $twigData["projectPlan"]["list"][$value["ID"]]["href"] = $value["DETAIL_PAGE_URL"];
    $twigData["projectPlan"]["list"][$value["ID"]]["img"]["src"] = $value["RES_PICTURE"];
    $twigData["projectPlan"]["list"][$value["ID"]]["numberOfRooms"] = $value["PROPERTIES"]["profit_rooms"]["VALUE"]."к.";
    $twigData["projectPlan"]["list"][$value["ID"]]["price"] = $value["PROPERTIES"]["profit_property_price"]["VALUE"];
    $twigData["projectPlan"]["list"][$value["ID"]]["isFavorite"] = false;
    $twigData["projectPlan"]["list"][$value["ID"]]["rooms"] = $value["PROPERTIES"]["profit_rooms"]["VALUE"]."-комнатная";
    $twigData["projectPlan"]["list"][$value["ID"]]["square"] = $value["PROPERTIES"]["profit_property_area"]["VALUE"]." м<sup>2</sup>";
    $twigData["projectPlan"]["list"][$value["ID"]]["price"] = "от ".number_format($value["PROPERTIES"]["profit_property_price"]["VALUE"], 0, ",", " ")." ₽";
    $arFloor = getMaxfloorInHouse($value["PROPERTIES"]["profit_house_id"]["VALUE"]);
    $twigData["projectPlan"]["list"][$value["ID"]]["floor"] = "Этаж ".$arFloor["MIN_FLOOR"]." из ".$arFloor["MAX_FLOOR"];
    $twigData["projectPlan"]["list"][$value["ID"]]["date"] = "Сдача 1кв. 2022 года";
    $twigData["projectPlan"]["list"][$value["ID"]]["credit"] = "в ипотеку от 18 324 ₽/мес.";
    $twigData["projectPlan"]["list"][$value["ID"]]["button"]["theme"] = "blue";
    $twigData["projectPlan"]["list"][$value["ID"]]["button"]["text"] = "Подробнее";
}

if ($project["PROPERTIES"]["ADV_BANNER"]["VALUE"]) {
    $arSelect = Array("NAME", "DETAIL_TEXT", "DETAIL_PICTURE");
    $arFilter = Array("IBLOCK_ID"=>BANNER_IBLOCK, "ACTIVE"=>"Y", "ID" => $project["PROPERTIES"]["ADV_BANNER"]["VALUE"]);
    $res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
    while($ob = $res->GetNextElement())
    {
        $arFields = $ob->GetFields();
        $arFields["RES_PICTURE"] = CFile::ResizeImageGet($arFields['DETAIL_PICTURE'], array('width'=>1000, 'height'=>1000), BX_RESIZE_IMAGE_PROPORTIONAL, true)["src"];
        $twigData["projectBanner"]["title"] = htmlspecialcharsBack($arFields["NAME"]);
        $twigData["projectBanner"]["text"] = htmlspecialcharsBack($arFields["DETAIL_TEXT"]);
        $twigData["projectBanner"]["img"]["src"] = $arFields["RES_PICTURE"];
    }
}

$arResult["TEMPLATE_DATA"] = $twigData;