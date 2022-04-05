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

// $res = CIBlock::GetProperties(PROFITAPPARTAMENTS_IBLOCK, Array(), Array());
// while($res_arr = $res->Fetch()) {
//     $arFilterProps[] = $res_arr["NAME"];
// }

// mpr($arFilterProps, false);
// mpr($arParams["FILTER_PROPS"], false);

// post
$postData = $arParams["POST"];
$postFilter = [];
// title
$twigData["filterVertical"]["title"] = "Фильтр по параметрам";
// filter btn mobile
$twigData["catalog"]["buttonFilter"]["theme"] = "opacity-blue";
$twigData["catalog"]["buttonFilter"]["text"] = "Фильтр по параметрам";
$twigData["catalog"]["buttonFilter"]["href"] = "#catalog-filter";
$twigData["catalog"]["buttonFilter"]["icon"] = "svg/filter-icon";
$twigData["catalog"]["buttonFilter"]["attr"] = "data-fancybox";
// filter btn more mobile
$twigData["catalog"]["buttonMore"]["theme"] = "blue";
$twigData["catalog"]["buttonMore"]["text"] = "Показать ешё";

// filter props
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
    $twigData["filterVertical"]["list"][$i]["id"] = "project";
    $twigData["filterVertical"]["list"][$i]["title"] = "Выберите проект";
    $twigData["filterVertical"]["list"][$i]["isSelect"] = true;
    $twigData["filterVertical"]["list"][$i]["options"][0]["option"] = "Выберите проект";
    $twigData["filterVertical"]["list"][$i]["options"][0]["value"] = "";
    foreach ($projects as $key => $value) {
        $twigData["filterVertical"]["list"][$i]["options"][$key+1]["option"] = $value["NAME"];
        $twigData["filterVertical"]["list"][$i]["options"][$key+1]["value"] = $value["PROPERTY_PROFIT_ID_VALUE"];
    }
    // post filter project
    if ($postData["project"]) {
        foreach ($projects as $key => $value) {
            if ($value["NAME"] == $postData["project"]) {
                $postFilter["PROPERTY_profit_project_id"] = $value["PROPERTY_PROFIT_ID_VALUE"];
            }
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
    $twigData["filterVertical"]["list"][$i]["title"] = "Желаемая стоимость, млн ₽";
    $twigData["filterVertical"]["list"][$i]["id"] = "price-filter";
    $twigData["filterVertical"]["list"][$i]["isSlider"] = true;
    $twigData["filterVertical"]["list"][$i]["min"] = $minPrice;
    $twigData["filterVertical"]["list"][$i]["max"] = $maxPrice;
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
        $twigData["filterVertical"]["list"][$i]["title"] = "Желаемая площадь, м<sup>2</sup>";
        $twigData["filterVertical"]["list"][$i]["id"] = "square-filter";
        $twigData["filterVertical"]["list"][$i]["isSlider"] = true;
        $twigData["filterVertical"]["list"][$i]["min"] = $minSquare;
        $twigData["filterVertical"]["list"][$i]["max"] = $maxSquare;
        $i++;
    }
    $i++;
}
if ($postData["price-filter-min"] && $postData["price-filter-max"] && $postData["square-filter-min"] && $postData["square-filter-max"]) {
    $postFilter = [
        "LOGIC" => "AND",
        ">=PROPERTY_profit_property_price" => intval($postData["price-filter-min"]) * 1000000,
        "<=PROPERTY_profit_property_price" => intval($postData["price-filter-max"]) * 1000000,
        ">=PROPERTY_profit_area_living" => intval($postData["square-filter-min"]),
        "<=PROPERTY_profit_area_living" => intval($postData["square-filter-max"]),
    ];
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
    $twigData["filterVertical"]["list"][$i]["title"] = "Количество комнат";
    foreach ($rooms as $key => $value) {
        $twigData["filterVertical"]["list"][$i]["checkboxs"][$key]["id"] = $value."-room";
        if ($value == "0") {
            $twigData["filterVertical"]["list"][$i]["checkboxs"][$key]["text"] =  "Ст.";
        } else {
            $twigData["filterVertical"]["list"][$i]["checkboxs"][$key]["text"] =  $value." к.";
        }
    }
    // post rooms
    foreach ($postData as $key => $value) {
        if (strstr($key, "-room", true)) {
            $postFilter["?PROPERTY_profit_rooms"] .= strstr($key, "-room", true). " || ";
        }
    }
    $i++;
}

if (1) {
    // extra
    // $extra = [];
    // studio
    // $arSelect = Array("IBLOCK_ID", "ID", "PROPERTY_profit_is_studio");
    // $arFilter = Array("IBLOCK_ID"=>PROFITAPPARTAMENTS_IBLOCK, "ACTIVE"=>"Y", "PROPERTY_profit_is_studio" => "true");
    // $res = CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageSize"=>1), $arSelect);
    // while($ob = $res->GetNextElement())
    // {
    //     $arFields = $ob->GetFields();
    //     $arFields["PROPERTIES"] = $ob->GetProperties();
    //     // $studio = $arFields;
    //     // if ($arFields["PROPERTIES"]["PROPERTY_profit_is_studio"]["CODE"]) {
    //     //     # code...
    //     // }
    //     $twigData["filterVertical"]["list"][$i][$arFields["PROPERTIES"]["profit_is_studio"]["ID"]]["id"] = $arFields["PROPERTIES"]["profit_is_studio"]["CODE"];
    //     $twigData["filterVertical"]["list"][$i][$arFields["PROPERTIES"]["profit_is_studio"]["ID"]]["text"] = $arFields["PROPERTIES"]["profit_is_studio"]["NAME"];
        
    // }
    // // mpr($extra["checkboxs"], false);

    // if (!empty($twigData["filterVertical"]["list"])) {
    //     $extra[$i]["checkboxs"]["title"] = "Доп. характеристики";
    // }

    // "title": "Доп. характеристики",
    // "checkboxs": [
    //     {
    //         "id": "finishing-filter",
    //         "text": "С отделкой"
    //     },
    //     {
    //         "id": "evro-filter",
    //         "text": "Евро"
    //     },
    //     {
    //         "id": "sale-filter",
    //         "text": "Со скидкой"
    //     }
    // ]
    // $i++;
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

// filter btn count
$res_count = CIBlockElement::GetList(Array(), $arFilter, Array(), false, Array());
$twigData["filterVertical"]["button"]["text"] = "Показать ".$res_count;
$twigData["filterVertical"]["button"]["theme"] = "blue";
$twigData["filterVertical"]["button"]["type"] = "submit";

// flats
$flats = [];
$res = CIBlockElement::GetList(Array("PROPERTY_profit_property_price" => "ASC"), $arFilter, false, Array("nPageSize" => $arParams["PAGE_SIZE"], "iNumPage" => $arParams["PAGE_NUM"]), $arSelect);
while($ob = $res->GetNextElement())
{
    $arFields = $ob->GetFields();
    $arFields["RES_PICTURE"] = CFile::ResizeImageGet($arFields['DETAIL_PICTURE'], array('width'=>1000, 'height'=>1000), BX_RESIZE_IMAGE_PROPORTIONAL, true)["src"];
    
    $arFields["PROPERTIES"] = $ob->GetProperties();
    $flats[] = $arFields;
}
// mpr($flats, false);

foreach ($flats as $key => $value) {
    $twigData["catalog"]["list"][$value["ID"]]["id"] = $value["ID"];
    $twigData["catalog"]["list"][$value["ID"]]["href"] = $value["DETAIL_PAGE_URL"];
    $twigData["catalog"]["list"][$value["ID"]]["img"]["src"] = $value["RES_PICTURE"];
    $twigData["catalog"]["list"][$value["ID"]]["numberOfRooms"] = $value["PROPERTIES"]["profit_rooms"]["VALUE"]."к.";
    $twigData["catalog"]["list"][$value["ID"]]["price"] = $value["PROPERTIES"]["profit_property_price"]["VALUE"];
    $twigData["catalog"]["list"][$value["ID"]]["isFavorite"] = false;
    $twigData["catalog"]["list"][$value["ID"]]["rooms"] = $value["PROPERTIES"]["profit_rooms"]["VALUE"]."-комнатная";
    $twigData["catalog"]["list"][$value["ID"]]["square"] = $value["PROPERTIES"]["profit_property_area"]["VALUE"]." м<sup>2</sup>";
    $twigData["catalog"]["list"][$value["ID"]]["price"] = "от ".number_format($value["PROPERTIES"]["profit_property_price"]["VALUE"], 0, ",", " ")." ₽";
    $arFloor = getMaxfloorInHouse($value["PROPERTIES"]["profit_house_id"]["VALUE"]);
    $twigData["catalog"]["list"][$value["ID"]]["floor"] = "Этаж ".$arFloor["MIN_FLOOR"]." из ".$arFloor["MAX_FLOOR"];
    $twigData["catalog"]["list"][$value["ID"]]["date"] = "Сдача 1кв. 2022 года";
    // $twigData["catalog"]["list"][$value["ID"]]["credit"] = "в ипотеку от 18 324 ₽/мес.";
    $twigData["catalog"]["list"][$value["ID"]]["button"]["theme"] = "blue";
    $twigData["catalog"]["list"][$value["ID"]]["button"]["text"] = "Подробнее";
}

$arResult["TEMPLATE_DATA"] = $twigData;