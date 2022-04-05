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
$twigData["flatMap"]["title"] = ($project["PROPERTIES"]["INFRASTRUCTURE_TITLE"]["VALUE"]) ? $project["PROPERTIES"]["INFRASTRUCTURE_TITLE"]["VALUE"] : "Инфраструктура" ;
if ($project["PROPERTIES"]["INFRASTRUCTURE_TEXT"]["VALUE"]) {
    $twigData["flatMap"]["text"][0] = htmlspecialcharsBack($project["PROPERTIES"]["INFRASTRUCTURE_TEXT"]["VALUE"]["TEXT"]);
}
$twigData["flatMap"]["img"]["src"] = CFile::ResizeImageGet($project["PROPERTIES"]["INFRASTRUCTURE_IMG"]["VALUE"], array('width'=>950, 'height'=>535), BX_RESIZE_IMAGE_EXACT, true)["src"];
$twigData["flatMap"]["img"]["alt"] = $project["PROPERTIES"]["INFRASTRUCTURE_TITLE"]["VALUE"];

$arResult["TEMPLATE_DATA"] = $twigData;
