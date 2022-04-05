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

foreach($arResult["ITEMS"] as $key => $value) {
    $twigData["paymentDescription"]['text'] = $arResult['DESCRIPTION'];
    $twigData["paymentDescription"]['list'][$key]["id"] = "item-".$value["ID"];
    $twigData["paymentDescription"]['list'][$key]["title"] = $value["NAME"];
    // $twigData["paymentDescription"]['list'][$key]["href"] = $value["DETAIL_PAGE_URL"];
    $twigData["paymentDescription"]['list'][$key]["img"]['src'] = $value["PREVIEW_PICTURE"]['SRC'];
}

$arResult["TEMPLATE_DATA"] = $twigData;