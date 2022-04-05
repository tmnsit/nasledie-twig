<?
use Bitrix\Main\Application;
use EuroCement\Local\Helper;
use Uplab\Core\Components\TemplateBlock;
use EuroCement\Local\Config;

defined("B_PROLOG_INCLUDED") && B_PROLOG_INCLUDED === true || die();
/**
 * @global CMain      $APPLICATION
 * @var array         $arParams
 * @var array         $arResult
 * @var TemplateBlock $component
*/

$twigData["news"][0]["title"] = "Условия покупки квартир в ЖК «Квартал лета»";
$twigData["logo"]["src"] = "/local/templates/.default/frontend/dist/tmp/logo-black.png";

$arResult["TEMPLATE_DATA"] = $twigData;