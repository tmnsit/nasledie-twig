<?
define("NO_KEEP_STATISTIC", true);
define("NO_AGENT_CHECK", true);
define('PUBLIC_AJAX_MODE', true);
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

$request = \Bitrix\Main\Application::getInstance()->getContext()->getRequest();

$arSelect = Array("IBLOCK_ID", "ID", "NAME", "PREVIEW_TEXT", "DETAIL_TEXT", "PREVIEW_PICTURE", "DETAIL_PAGE_URL", "PROPERTY_*");
$type = ($request->getPost('type') == "Все проекты") ? "" : $request->getPost('type') ;
$arFilter = Array("IBLOCK_ID" => PROJECTS_IBLOCK, "ACTIVE" => "Y", "PROPERTY_TYPE.NAME" => $type);
$res = CIBlockElement::GetList(Array("SORT"=>"ASC"), $arFilter, false, false, $arSelect);
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
    } else {
        $twigData["projects"]["list"][$key]["button"]["href"] = "#";
    }
    $twigData["projects"]["list"][$key]["button"]["text"] = "Узнать подробнее";
    $twigData["projects"]["list"][$key]["button"]["theme"] = "blue";

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

// echo $type;
echo json_encode($twigData["projects"]["list"]);

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");