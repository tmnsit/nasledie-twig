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
$twigData["commerceHouse"]["title"] = ($project["PROPERTIES"]["COMMERCE_TITLE"]["VALUE"]) ? $project["PROPERTIES"]["COMMERCE_TITLE"]["VALUE"] : "Коммерческая недвижимость" ;
$twigData["commerceHouse"]["text"][0] = ($project["PROPERTIES"]["COMMERCE_TEXT"]["VALUE"]["TEXT"]) ? htmlspecialcharsBack($project["PROPERTIES"]["COMMERCE_TEXT"]["VALUE"]["TEXT"]) : "";

$twigData["commerceHouse"]["img"]["src"] = CFile::ResizeImageGet($project["PROPERTIES"]["COMMERCE_IMG"]["VALUE"], array('width'=>950, 'height'=>535), BX_RESIZE_IMAGE_EXACT, true)["src"];
$twigData["commerceHouse"]["img"]["alt"] = $project["PROPERTIES"]["COMMERCE_TITLE"]["VALUE"];

if ($project["PROPERTIES"]["COMMERCE_PROPS"]["VALUE"]) {
    foreach ($project["PROPERTIES"]["COMMERCE_PROPS"]["VALUE"] as $key => $value) {
        $twigData["commerceHouse"]["list"][] = $value;
    }
}
if ($project["PROPERTIES"]["COMMERCE_LINK"]["VALUE"]) {
    $twigData["commerceHouse"]["button"]["theme"] = "blue";
    $twigData["commerceHouse"]["button"]["text"] = "Узнать подробнее";
    $twigData["commerceHouse"]["button"]["href"] = $project["PROPERTIES"]["COMMERCE_LINK"]["VALUE"];
}

$arResult["TEMPLATE_DATA"] = $twigData;
