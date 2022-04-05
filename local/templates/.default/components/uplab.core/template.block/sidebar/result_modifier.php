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

// sidebar
$APPLICATION->IncludeComponent(
	"bitrix:menu",
	"sidebar",
	Array(
		"ALLOW_MULTI_SELECT" => "N",
		"CHILD_MENU_TYPE" => "",
		"DELAY" => "N",
		"MAX_LEVEL" => "1",
		"MENU_CACHE_GET_VARS" => array(""),
		"MENU_CACHE_TIME" => "3600",
		"MENU_CACHE_TYPE" => "N",
		"MENU_CACHE_USE_GROUPS" => "Y",
		"ROOT_MENU_TYPE" => "left",
		"USE_EXT" => "N"
	),
	$this->__component
);

$sidebar_menu_items = $arResult['TEMPLATE_DATA']['menuTreeResult'];
$twigData["sidebar"]["nav"] = $sidebar_menu_items;

// button
$twigData["sidebar"]["buttons"][1]["theme"] = "blue-border-transparent";
$twigData["sidebar"]["buttons"][1]["href"] = "#callback-form-accept";
$twigData["sidebar"]["buttons"][1]["attr"] = "data-fancybox";
$twigData["sidebar"]["buttons"][1]["text"] = "Тендеры компании";

$twigData["sidebar"]["buttons"][0]["theme"] = "blue-border-transparent";
$twigData["sidebar"]["buttons"][0]["href"] = "#callback-form-invite";
$twigData["sidebar"]["buttons"][0]["attr"] = "data-fancybox";
$twigData["sidebar"]["buttons"][0]["text"] = "Пригласить в тендер";

$arResult["TEMPLATE_DATA"] = $twigData;