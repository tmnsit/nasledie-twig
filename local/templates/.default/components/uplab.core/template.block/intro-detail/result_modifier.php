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

$elementID = $arParams["EXTRA_NAV_ITEM_ID"];
if($arParams["EXTRA_NAV_ITEM_CODE"]){
    $elementID = CIBlockFindTools::GetElementID('', $arParams["EXTRA_NAV_ITEM_CODE"], '', '', []);
}

// breadcrumb
if ($elementID) {
    $nameplate = \Bitrix\Iblock\ElementTable::getById($elementID);
    $name = $nameplate->fetchObject()->getName();
    $APPLICATION->AddChainItem($name);
    $APPLICATION->SetTitle($name);
}

$twigData["breadcrumb"] = $APPLICATION->GetNavChain(
    $path = false,
    $NumFrom = 0, 
    $NavChainPath = false,
    $IncludeOnce=true,
    $ShowIcons = true
);

// banner
$arResult["BANNER_CODE"] = str_replace("/", "", $arParams["BANNER_CODE"]);
$arSelect = Array("IBLOCK_ID", "ID", "NAME", "CODE", "PREVIEW_PICTURE");
$arFilter = Array("IBLOCK_ID" => BANNER_IBLOCK, "ACTIVE" => "Y", "CODE" => $arResult["BANNER_CODE"]);
$res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
while($ob = $res->GetNextElement())
{
    $arFields = $ob->GetFields();
    $arFields["PREVIEW_PICTURE_SRC"] = CFile::ResizeImageGet($arFields["PREVIEW_PICTURE"], array('width'=>1740, 'height'=>980), BX_RESIZE_IMAGE_EXACT, true)["src"];
    $arFields["PROPERTIES"] = $ob->GetProperties();
    $banner = $arFields;
}

$twigData["introDetail"]["title"] = $APPLICATION->GetTitle();
$twigData["introDetail"]["img"]["src"] = ($banner["PREVIEW_PICTURE_SRC"]) ? $banner["PREVIEW_PICTURE_SRC"] : "/local/templates/.default/components/uplab.core/template.block/intro-detail/image/default.jpg" ;
$twigData["introDetail"]["img"]["alt"] = $banner["NAME"];
if (!empty($banner["PROPERTIES"]["TEXT"]["VALUE"])) {
    foreach ($banner["PROPERTIES"]["TEXT"]["VALUE"] as $text) {
        $twigData["introDetail"]["text"][] = $text["TEXT"];
    }
}

$arResult["TEMPLATE_DATA"] = $twigData;