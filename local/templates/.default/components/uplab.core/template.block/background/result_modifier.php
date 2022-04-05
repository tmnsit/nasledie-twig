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

// news
$twigData["aboutDescription"]["title"] = "Новости";

$arSelect = Array("*", "PREVIEW_TEXT");
$arFilter = Array("IBLOCK_ID" => NEWS_IBLOCK, "ACTIVE" => "Y");
$res = CIBlockElement::GetList(Array("DATE_ACTIVE_FROM"=>"DESC"), $arFilter, false, Array("nPageSize"=>$arParams["PAGE_SIZE"]), $arSelect);
while($ob = $res->GetNextElement())
{
    $arFields = $ob->GetFields();
    $news[] = $arFields;
}

// var_dump($news);
foreach ($news as $key => $value) {
    $twigData["news"][$key]["title"] = $value["NAME"];
    $twigData["news"][$key]["text"] = $value["PREVIEW_TEXT"];
    $twigData["news"][$key]["href"] = $value["DETAIL_PAGE_URL"];

    $objDateTime = new DateTime($value["DATE_ACTIVE_FROM"]);
    $twigData["news"][$key]["date"] = $objDateTime->format("d F Y");
}


$twigData = [];
$arResult["TEMPLATE_DATA"] = $twigData;