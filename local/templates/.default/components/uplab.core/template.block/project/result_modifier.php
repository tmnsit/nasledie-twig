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

// \Bitrix\Main\Loader::includeModule('iblock');
// mpr('d7', false);
// $iblock = \Bitrix\Iblock\Iblock::wakeUp(PROJECTS_IBLOCK);
// $elements = \Bitrix\Iblock\ElementTable::getList([

/*
$elements = \Bitrix\Iblock\Elements\ElementProjectsTable::getList([
	'select' => [
        "IBLOCK_ID", "ID", "NAME", "PREVIEW_PICTURE",
        "CITY",
        "YELLOW_NAMEPLATE.ELEMENT",
        "WHITE_NAMEPLATE.ELEMENT",
        "MIN_PRICE",
    ],
	'filter' => [
        // "IBLOCK_ID" => PROJECTS_IBLOCK,
        // "ID" => 7,
        // "27" => "Да",
	],
])->fetchCollection();
*/

/*
foreach($elements as $element)
{
    mpr($element->getName(), false);
    $twigData["project"]["list"][$key]["title"] = $element->getName();
    mpr($element->getPreviewPicture(), false); // CFile::ResizeImageGet();
    mpr(CFile::ResizeImageGet($element->getPreviewPicture(), array('width'=>150, 'height'=>150), BX_RESIZE_IMAGE_PROPORTIONAL, true), false);

    if (is_object($element->getCity())) {
        mpr($element->getCity()->getValue(), false);
    }
    if (is_object($element->getMinPrice())) {
        mpr($element->getMinPrice()->getValue(), false);
    }
    foreach($element->getYellowNameplate()->getAll() as $value)
    {
        if (is_object($value)) {
            mpr($value->getElement()->getName(), false);
        }
    }
    foreach($element->getWhiteNameplate()->getAll() as $value)
    {
        if (is_object($value)) {
            mpr($value->getElement()->getName(), false);
        }
    }
}
*/

$twigData["project"]["title"] = $arParams["BLOCK_TITLE"];

$arSelect = Array("IBLOCK_ID", "ID", "NAME", "PREVIEW_TEXT", "PREVIEW_PICTURE", "DETAIL_PAGE_URL", "CODE", "PROPERTY_*");
$arFilter = Array("IBLOCK_ID" => PROJECTS_IBLOCK, "ACTIVE" => "Y", "PROPERTY_TYPE_VALUE" => ["Жилое строительство"], "PROPERTY_SHOW_MAIN_VALUE" => "Да");
$res = CIBlockElement::GetList(Array("SORT"=>"ASC"), $arFilter, false, Array("nPageSize"=>$arParams["PAGE_SIZE"]), $arSelect);
while($ob = $res->GetNextElement())
{
    $arFields = $ob->GetFields();
    $arFields["RES_PREVIEW_PICTURE"] = CFile::ResizeImageGet($arFields["PREVIEW_PICTURE"], array("width"=>685, "height"=>404), BX_RESIZE_IMAGE_PROPORTIONAL, true);
    $arFields["PROPERTIES"] = $ob->GetProperties();
    $projects[] = $arFields;
}
foreach ($projects as $key => $value) {
    $twigData["project"]["list"][$key]["title"] = $value["NAME"];
    $twigData["project"]["list"][$key]["text"] = $value["PREVIEW_TEXT"];
    $twigData["project"]["list"][$key]["img"]["src"] = $value["RES_PREVIEW_PICTURE"]["src"];
    $twigData["project"]["list"][$key]["img"]["alt"] = $value["NAME"];
    $twigData["project"]["list"][$key]["price"] = ($value["PROPERTIES"]["MIN_PRICE"]["VALUE"]) ? "от ".(str_replace(".", ",", $value["PROPERTIES"]["MIN_PRICE"]["VALUE"] / 1000000))." млн. ₽" : "" ;
    $twigData["project"]["list"][$key]["city"] = $value["PROPERTIES"]["CITY"]["VALUE"];

    if ($value["PROPERTIES"]["YELLOW_NAMEPLATE"]["VALUE"]) {
        foreach ($value["PROPERTIES"]["YELLOW_NAMEPLATE"]["VALUE"] as $id) {
            $nameplate = \Bitrix\Iblock\ElementTable::getById($id);
            $name = $nameplate->fetchObject()->getName();
            $twigData["project"]["list"][$key]["class"][] = $name;
        }
    }
    if ($value["PROPERTIES"]["WHITE_NAMEPLATE"]["VALUE"]) {
        foreach ($value["PROPERTIES"]["WHITE_NAMEPLATE"]["VALUE"] as $id) {
            $nameplate = \Bitrix\Iblock\ElementTable::getById($id);
            $name = $nameplate->fetchObject()->getName();
            $twigData["project"]["list"][$key]["tag"][] = $name;
        }
    }

    // btn
    if ($value["CODE"] == "zhk-kvartal-leta") {
        $twigData["project"]["list"][$key]["button"]["external"] = true;

        $twigData["project"]["list"][$key]["button"]["href"] = $value["DETAIL_PAGE_URL"];
        $twigData["project"]["list"][$key]["button"]["theme"] = "blue";
        $twigData["project"]["list"][$key]["button"]["text"] = "Выбрать квартиру";
        if ($value["PROPERTIES"]["LINK_EXT"]["VALUE"]) {
            $twigData["project"]["list"][$key]["button"]["href"] = $value["PROPERTIES"]["LINK_EXT"]["VALUE"];
        }
    }
}

$arResult["TEMPLATE_DATA"] = $twigData;