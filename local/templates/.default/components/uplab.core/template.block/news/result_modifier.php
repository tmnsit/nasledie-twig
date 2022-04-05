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

$twigData["newsHeader"]["title"] = $arParams["BLOCK_TITLE"];
$twigData["newsHeader"]["more"]["title"] = $arParams["TEXT_MORE"];
$twigData["newsHeader"]["more"]["href"] = $arParams["LINK_MORE"];
$twigData["isMain"] = ($arParams["PAGE"] == "/") ? true : false ;

$arSelect = Array("IBLOCK_ID", "ID", "NAME", "PREVIEW_TEXT", "PREVIEW_TEXT", "DATE_ACTIVE_FROM", "DETAIL_PAGE_URL");
$arFilter = Array("IBLOCK_ID" => NEWS_IBLOCK, "ACTIVE" => "Y");
$res = CIBlockElement::GetList(Array("DATE_ACTIVE_FROM"=>"DESC"), $arFilter, false, Array("nPageSize"=>$arParams["PAGE_SIZE"]), $arSelect);
while($ob = $res->GetNextElement())
{
    $arFields = $ob->GetFields();
    $news[] = $arFields;
}

foreach ($news as $key => $value) {
    $twigData["news"]["list"][$key]["title"] = $value["NAME"];
    $twigData["news"]["list"][$key]["text"] = TruncateText($value["PREVIEW_TEXT"], 130);
    $twigData["news"]["list"][$key]["href"] = $value["DETAIL_PAGE_URL"];
    $twigData["news"]["list"][$key]["date"] = FormatDate("d F Y", MakeTimeStamp($value["DATE_ACTIVE_FROM"]));
}

$arResult["TEMPLATE_DATA"] = $twigData;