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

// advantages
$twigData["aboutDescription"]["title"] = $arParams["BLOCK_TITLE"];

$arSelect = Array("NAME", "PREVIEW_TEXT");
$arFilter = Array("IBLOCK_ID" => CONCEPTS_IBLOCK, "ACTIVE" => "Y");
$res = CIBlockElement::GetList(Array("SORT"=>"ASC"), $arFilter, false, Array("nPageSize"=>$arParams["PAGE_SIZE"]), $arSelect);
while($ob = $res->GetNextElement())
{
    $arFields = $ob->GetFields();
    // $advantages[] = $arFields;
    $twigData["aboutDescription"]["list"][$key]["text"] = $arFields["PREVIEW_TEXT"];
}
foreach ($advantages as $key => $value) {
    // $twigData["aboutDescription"]["list"][$key]["title"] = $value["NAME"];
    // $twigData["aboutDescription"]["list"][$key]["text"] = $value["PREVIEW_TEXT"];
}

$arResult["TEMPLATE_DATA"] = $twigData;