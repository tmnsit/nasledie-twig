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

$twigData["about"]["title"] = $arParams["BLOCK_TITLE"];
$twigData["about"]["button"]["text"] = $arParams["TEXT_BTN"];
$twigData["about"]["button"]["href"] = $arParams["LINK_BTN"];
$twigData["about"]["button"]["theme"] = "blue";
// $twigData["about"]["button"]["fancybox"] = false;

$arSelect = Array("IBLOCK_ID", "ID", "NAME", "PREVIEW_TEXT", "PREVIEW_PICTURE");
$arFilter = Array("IBLOCK_ID" => BLOCKS_IBLOCK, "ID" => "8", "ACTIVE" => "Y");
$res = CIBlockElement::GetList(Array("DATE_ACTIVE_FROM"=>"DESC"), $arFilter, false, false, $arSelect);
while($ob = $res->GetNextElement())
{
    $arFields = $ob->GetFields();
    $arFields["PROPERTIES"] = $ob->GetProperties();

    $twigData["about"]["text"][0] = $arFields["PREVIEW_TEXT"];
    $twigData["about"]["img"]["src"] = CFile::ResizeImageGet($arFields["PREVIEW_PICTURE"], array("width"=>685, "height"=>500), BX_RESIZE_IMAGE_PROPORTIONAL, true)["src"];
    $twigData["about"]["img"]["description"] = CFile::GetFileArray($arFields["PREVIEW_PICTURE"])["DESCRIPTION"];

    if (!empty($arFields["PROPERTIES"]["NUMBERS"]["VALUE"])) {
        foreach ($arFields["PROPERTIES"]["NUMBERS"]["VALUE"] as $key_num => $value_num) {
            $twigData["about"]["item"][$key_num]["title"] = htmlspecialcharsBack($value_num);
            $twigData["about"]["item"][$key_num]["text"] = htmlspecialcharsBack($arFields["PROPERTIES"]["NUMBERS"]["DESCRIPTION"][$key_num]);
        }
    }
}

$arResult["TEMPLATE_DATA"] = $twigData;