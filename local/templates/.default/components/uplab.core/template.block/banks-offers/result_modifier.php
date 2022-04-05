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

$twigData["banksOffers"]["title"] = $arParams["BLOCK_TITLE"];
$twigData["banksOffers"]["button"]["text"] = $arParams["TEXT_BTN"];
$twigData["banksOffers"]["button"]["href"] = $arParams["LINK_BTN"];
$twigData["banksOffers"]["button"]["theme"] = "blue";

$arSelect = Array("IBLOCK_ID", "ID", "NAME", "PREVIEW_PICTURE", "PROPERTY_SUM", "PROPERTY_PERIOD", "PROPERTY_RATE");
$arFilter = Array("IBLOCK_ID" => BANKS_IBLOCK, "ACTIVE" => "Y");
$res = CIBlockElement::GetList(Array("DATE_ACTIVE_FROM"=>"DESC"), $arFilter, false, false, $arSelect);
while($ob = $res->GetNextElement())
{
    $arFields = $ob->GetFields();
    $arFields["RES_PREVIEW_PICTURE"] = CFile::ResizeImageGet($arFields["PREVIEW_PICTURE"], array("width"=>276, "height"=>36), BX_RESIZE_IMAGE_PROPORTIONAL, true)["src"];
    $banks[] = $arFields;
}

foreach ($banks as $key => $value) {
    $twigData["banksOffers"]["banks"][$key]["img"]["src"] = $value["RES_PREVIEW_PICTURE"];
    $twigData["banksOffers"]["banks"][$key]["img"]["alt"] = $value["NAME"];
    $twigData["banksOffers"]["banks"][$key]["payment"] = "от ".$value["PROPERTY_SUM_VALUE"]."%";
    $twigData["banksOffers"]["banks"][$key]["year"] = "до ".$value["PROPERTY_PERIOD_VALUE"]." лет";
    $twigData["banksOffers"]["banks"][$key]["bet"] = "от ".$value["PROPERTY_RATE_VALUE"]."%";
}

$arResult["TEMPLATE_DATA"] = $twigData;