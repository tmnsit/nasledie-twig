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

$project = $arParams["PROJECT"];
// mpr($project, false);
$twigData["projectSteps"]["title"] = ($project["PROPERTIES"]["PROGRESS_TITLE"]["VALUE"]) ? $project["PROPERTIES"]["PROGRESS_TITLE"]["VALUE"] : "Ход строительства" ;
if ($project["PROPERTIES"]["PROGRESS_SLIDER"]["VALUE"]) {
    $arSelect = Array("NAME", "ID", "PREVIEW_PICTURE");
    $arFilter = Array("IBLOCK_ID" => PROGRESS_IBLOCK, "IBLOCK_SECTION_ID"=> $project["PROPERTIES"]["PROGRESS_SLIDER"]["VALUE"], "ACTIVE" => "Y");
    $res = CIBlockElement::GetList(Array("active_from"=>"desc"), $arFilter, false, false, $arSelect);
    while($ob = $res->GetNextElement())
    {
        $arFields = $ob->GetFields();
        $twigData["projectSteps"]["list"][$arFields["ID"]]["title"] = $arFields["NAME"];
        $twigData["projectSteps"]["list"][$arFields["ID"]]["date"] = FormatDate("d F Y", MakeTimeStamp($arFields["ACTIVE_FROM"]));
        if ($arFields["PREVIEW_PICTURE"]) {
            $twigData["projectSteps"]["list"][$arFields["ID"]]["img"]["src"] = CFile::ResizeImageGet($arFields["PREVIEW_PICTURE"], array('width'=>328, 'height'=>190), BX_RESIZE_IMAGE_EXACT, true)["src"];
            $twigData["projectSteps"]["list"][$arFields["ID"]]["img"]["alt"] = $arFields["NAME"];
        }
    }
}
// mpr($twigData["projectSteps"], false);

$arResult["TEMPLATE_DATA"] = $twigData;
