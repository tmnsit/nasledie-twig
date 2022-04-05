<?
use Bitrix\Main\Application;
use EuroCement\Local\Helper;
use Uplab\Core\Components\TemplateBlock;

defined("B_PROLOG_INCLUDED") && B_PROLOG_INCLUDED === true || die();
/**
 * @global CMain      $APPLICATION
 * @var array         $arParams
 * @var array         $arResult
 * @var TemplateBlock $component
 */

$rnd = $this->randString();

$elementEdit = CIBlock::GetArrayByID($arParams['IBLOCK_ID'], 'ELEMENT_EDIT');
$elementDelete = CIBlock::GetArrayByID($arParams['IBLOCK_ID'], 'ELEMENT_DELETE');
// mpr($arResult["ITEMS"], false);

foreach($arResult["ITEMS"] as $key => $value) {
    $twigData["projects"]['list'][$key]["title"] = $value["NAME"];
    $text = ($value["PREVIEW_TEXT"]) ? $value["PREVIEW_TEXT"] : $value["DETAIL_TEXT"];
    $twigData["projects"]['list'][$key]["text"] =  TruncateText($text, 360);
    $twigData["projects"]['list'][$key]["href"] = $value["DETAIL_PAGE_URL"];
    $twigData["projects"]['list'][$key]["img"]['src'] = $value["PREVIEW_PICTURE"]['SRC'];
//    $twigData["news"]["list"][$key]["date"] = FormatDate("d F Y", MakeTimeStamp($value["DATE_ACTIVE_FROM"]));

    if ($value["DETAIL_PAGE_URL"]) {
        $twigData["projects"]["list"][$key]["button"]["href"] = $value["DETAIL_PAGE_URL"];
        $twigData["projects"]["list"][$key]["button"]["text"] = "Узнать подробнее";
        $twigData["projects"]["list"][$key]["button"]["theme"] = "blue";
    }
}

$arResult["TEMPLATE_DATA"] = $twigData;
