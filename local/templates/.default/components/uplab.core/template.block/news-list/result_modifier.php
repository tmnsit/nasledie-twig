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

$arSelect = Array("IBLOCK_ID", "ID", "NAME", "DATE_ACTIVE_FROM", "PREVIEW_PICTURE", "DETAIL_PAGE_URL");
$arFilter = Array("IBLOCK_ID" => NEWS_IBLOCK, "ACTIVE" => "Y");
$res = CIBlockElement::GetList(Array("DATE_ACTIVE_FROM"=>"DESC"), $arFilter, false, Array("nPageSize"=>$arParams["PAGE_SIZE"]), $arSelect);
while($ob = $res->GetNextElement())
{
    $arFields = $ob->GetFields();
    $news[] = $arFields;
}

foreach ($news as $key => $value) {
    $twigData["news"]["list"][$key]["title"] = $value["NAME"];
    $twigData["news"]["list"][$key]["img"]["src"] = CFile::ResizeImageGet($value["PREVIEW_PICTURE"], array("width"=>447, "height"=>447), BX_RESIZE_IMAGE_EXACT, true)["src"];
    $twigData["news"]["list"][$key]["img"]["alt"] = $value["NAME"];
    $twigData["news"]["list"][$key]["href"] = $value["DETAIL_PAGE_URL"];
    $twigData["news"]["list"][$key]["date"] = FormatDate("d F Y", MakeTimeStamp($value["DATE_ACTIVE_FROM"]));
}

$arResult["TEMPLATE_DATA"] = $twigData;