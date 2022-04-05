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

$arSelect = Array("NAME", "PREVIEW_TEXT", "ID", "IBLOCK_ID", "PROPERTY_TITLE_EXTRA");
$arFilter = Array("IBLOCK_ID" => PAYMENT_IBLOCK, "ACTIVE" => "Y");
$res = CIBlockElement::GetList(Array("SORT" => "ASC"), $arFilter, false, false, $arSelect);
while ($ob = $res->GetNextElement()) {
    $arFields = $ob->GetFields();
    $twigData["paymentDescription"]["list"][$arFields["ID"]]["id"] = "item-".$arFields["ID"];
    $twigData["paymentDescription"]["list"][$arFields["ID"]]["title"] = $arFields["PROPERTY_TITLE_EXTRA_VALUE"];
    $twigData["paymentDescription"]["list"][$arFields["ID"]]["text"] = $arFields["PREVIEW_TEXT"];
}


$arResult["TEMPLATE_DATA"] = $twigData;
