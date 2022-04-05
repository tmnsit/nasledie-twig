<?

use Bitrix\Main\Application;
use ProjectName\Local\Helper;
use Uplab\Core\Components\TemplateBlock;
use ProjectName\Local\Config;

defined("B_PROLOG_INCLUDED") && B_PROLOG_INCLUDED === true || die();
/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 * @var TemplateBlock $component
 */

$project = $arParams["PROJECT"];
$twigData["isLayout"] = false;
$twigData["paymentDescription"]["title"] = ($project["PROPERTIES"]["PAYMENT_TITLE"]["VALUE"]) ? $project["PROPERTIES"]["PAYMENT_TITLE"]["VALUE"] : "Способы покупки" ;
$twigData["paymentDescription"]["text"] = ($project["PROPERTIES"]["PAYMENT_TEXT"]["VALUE"]["TEXT"]) ? $project["PROPERTIES"]["PAYMENT_TEXT"]["VALUE"]["TEXT"] : "Квартира подготовлена к финишному ремонту. Стены выровнены, на полу ровная песчано-цементная стяжка, сделана разводка электричества, установлены розетки и выключатели.";

$arSelect = Array("NAME", "PREVIEW_TEXT", "ID", "IBLOCK_ID", "PROPERTY_TITLE_EXTRA", "DETAIL_PAGE_URL", "PREVIEW_PICTURE");
$arFilter = Array("IBLOCK_ID" => PAYMENT_IBLOCK, "ACTIVE" => "Y");
$res = CIBlockElement::GetList(Array("SORT" => "ASC"), $arFilter, false, false, $arSelect);
while ($ob = $res->GetNextElement()) {
    $arFields = $ob->GetFields();
    $twigData["paymentDescription"]["list"][$arFields["ID"]]["title"] = $arFields["NAME"];
    $twigData["paymentDescription"]["list"][$arFields["ID"]]["img"]["src"] = CFile::ResizeImageGet($arFields["PREVIEW_PICTURE"], array('width'=>1043, 'height'=>500), BX_RESIZE_IMAGE_EXACT, true)["src"];
    $twigData["paymentDescription"]["list"][$arFields["ID"]]["img"]["alt"] = $arFields["NAME"];
    // $twigData["paymentDescription"]["list"][$arFields["ID"]]["href"] = $arFields["DETAIL_PAGE_URL"];
    $twigData["paymentDescription"]["list"][$arFields["ID"]]["href"] = "/payment/#item-".$arFields["ID"];
}


$arResult["TEMPLATE_DATA"] = $twigData;
