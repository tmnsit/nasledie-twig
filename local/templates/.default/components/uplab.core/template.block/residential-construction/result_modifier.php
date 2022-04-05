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

$twigData["residentialConstruction"]["title"] = $arParams["BLOCK_TITLE"];

$arSelect = Array("IBLOCK_ID", "ID", "NAME", "PREVIEW_TEXT", "PREVIEW_PICTURE", "DETAIL_PAGE_URL", "PROPERTY_*");
$arFilter = Array("IBLOCK_ID" => PROJECTS_IBLOCK, "ACTIVE" => "Y", "PROPERTY_TYPE_VALUE" => ["Жилое строительство"]);
$res = CIBlockElement::GetList(Array("SORT"=>"ASC"), $arFilter, false, false, $arSelect);
while($ob = $res->GetNextElement())
{
    $arFields = $ob->GetFields();
    $arFields["PROPERTIES"] = $ob->GetProperties();
    $arFields["RES_PREVIEW_PICTURE"] = CFile::ResizeImageGet($arFields["PREVIEW_PICTURE"], array("width"=>460, "height"=>644), BX_RESIZE_IMAGE_EXACT, true)["src"];
    $arResidentialConstruction[] = $arFields;
}

foreach ($arResidentialConstruction as $key => $value) {
    $twigData["residentialConstruction"]["list"][$key]["title"] = $value["NAME"];
    $twigData["residentialConstruction"]["list"][$key]["category"] = $value["NAME"];
    $twigData["residentialConstruction"]["list"][$key]["img"]["src"] = $value["RES_PREVIEW_PICTURE"];
    $twigData["residentialConstruction"]["list"][$key]["img"]["alt"] = $value["NAME"];
    $twigData["residentialConstruction"]["list"][$key]["price"] = ($value["PROPERTIES"]["MIN_PRICE"]["VALUE"]) ? "от ".number_format($value["PROPERTIES"]["MIN_PRICE"]["VALUE"], 0, ",", " ")." ₽" : "" ;
    $twigData["residentialConstruction"]["list"][$key]["city"] = $value["PROPERTIES"]["CITY"]["VALUE"];

    if ($value["PROPERTIES"]["YELLOW_NAMEPLATE"]["VALUE"]) {
        foreach ($value["PROPERTIES"]["YELLOW_NAMEPLATE"]["VALUE"] as $id) {
            $nameplate = \Bitrix\Iblock\ElementTable::getById($id);
            $name = $nameplate->fetchObject()->getName();
            $twigData["residentialConstruction"]["list"][$key]["label"][] = $name;
        }
    }
    if ($value["PROPERTIES"]["WHITE_NAMEPLATE"]["VALUE"]) {
        foreach ($value["PROPERTIES"]["WHITE_NAMEPLATE"]["VALUE"] as $id) {
            $nameplate = \Bitrix\Iblock\ElementTable::getById($id);
            $name = $nameplate->fetchObject()->getName();
            $twigData["residentialConstruction"]["list"][$key]["tags"][] = $name;
        }
    }

    if ($value["CODE"] == "zhk-kvartal-leta") {
        $twigData["project"]["list"][$key]["button"]["external"] = true;

        $twigData["residentialConstruction"]["list"][$key]["button"]["href"] = $value["DETAIL_PAGE_URL"];
        $twigData["residentialConstruction"]["list"][$key]["button"]["text"] = $arParams["BTN_TEXT_DETAIL"];
        $twigData["residentialConstruction"]["list"][$key]["button"]["theme"] = $arParams["BTN_CLASS"];
        if ($value["PROPERTIES"]["LINK_EXT"]["VALUE"]) {
            $twigData["residentialConstruction"]["list"][$key]["button"]["href"] = $value["PROPERTIES"]["LINK_EXT"]["VALUE"];
            $twigData["residentialConstruction"]["list"][$key]["button"]["attr"] = "target='_blank'";
        }
    }
}

$arResult["TEMPLATE_DATA"] = $twigData;