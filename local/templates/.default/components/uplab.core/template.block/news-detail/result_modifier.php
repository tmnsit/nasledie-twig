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

$twigData["newsDetail"]["text"] = "Возврат к списку новостей";

$arSelect = Array("IBLOCK_ID", "ID", "NAME", "DETAIL_TEXT", "DATE_ACTIVE_FROM", "DETAIL_PICTURE", "LIST_PAGE_URL", "PROPERTY_*");
$arFilter = Array("IBLOCK_ID" => NEWS_IBLOCK, "ACTIVE" => "Y", "ID" => $arParams["ELEMENT_ID"]);
$res = CIBlockElement::GetList(Array("DATE_ACTIVE_FROM"=>"DESC"), $arFilter, false, false, $arSelect);
while($ob = $res->GetNextElement())
{
    $arFields = $ob->GetFields();
    $arFields["PROPERTIES"] = $ob->GetProperties();
    // fileds
    $twigData["newsDetail"]["title"] = $arFields["NAME"];
    $twigData["newsDetail"]["pList"][0] = $arFields["DETAIL_TEXT"];
    $twigData["newsDetail"]["backLink"] = $arFields["LIST_PAGE_URL"];
    // picture
    if (!empty($arFields["DETAIL_PICTURE"])) {
        $twigData["newsDetail"]["mainImg"]["src"] = CFile::ResizeImageGet($arFields["DETAIL_PICTURE"], array("width"=>436, "height"=>573), BX_RESIZE_IMAGE_EXACT, true)["src"];
        $twigData["newsDetail"]["mainImg"]["alt"] = $arFields["NAME"];
    }
    // gallery
    if (!empty($arFields["PROPERTIES"]["GALLERY"]["VALUE"])) {
        foreach ($arFields["PROPERTIES"]["GALLERY"]["VALUE"] as $key_gallery => $value_gallery) {
            $twigData["newsDetail"]["galleryList"][$key_gallery]["img"]["src"] = CFile::ResizeImageGet($value_gallery, array("width"=>570, "height"=>399), BX_RESIZE_IMAGE_EXACT, true)["src"];
            $twigData["newsDetail"]["galleryList"][$key_gallery]["img"]["alt"] = "alt";
        }
    }
    // file
    $pdfId = \Bitrix\Main\Config\Option::get("nasledie.config", "presentation");
    if (!empty($pdfId)) {
        $pdf = CFile::GetFileArray($pdfId);
        $twigData["newsDetail"]["download"]["href"] = $pdf["SRC"];
        $twigData["newsDetail"]["download"]["download"]["name"] = $pdf["ORIGINAL_NAME"];
    }
}
$arResult["TEMPLATE_DATA"] = $twigData;