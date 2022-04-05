<?
use Bitrix\Main\Application;
use EuroCement\Local\Helper;
use Uplab\Core\Components\TemplateBlock;


defined("B_PROLOG_INCLUDED") && B_PROLOG_INCLUDED === true || die();
/**
 * @global CMain      $APPLICATION
 * @var array         $arParams
 * @var array         $arResult
 * @var TemplateBlock $component
 */

if (strpos($arResult["PROPERTIES"]["BTN"]["DESCRIPTION"], "[modal]")!==false) {
	$link = str_replace("[modal]", "", $arResult["PROPERTIES"]["BTN"]["DESCRIPTION"]);
	$attr = 'data-anchors-link data-modal data-effect="mfp-move-from-right"';
} else {
	$attr = '';
	$link = $arResult["PROPERTIES"]["BTN"]["DESCRIPTION"];
}

$banner = [
	"title" => $arResult["NAME"],
	"text" => $arResult["PREVIEW_TEXT"],
	"button" => [
		"attr"  => $attr,
		"theme" => "border-white",
		"hover" => "white",
		"text" =>  $arResult["PROPERTIES"]["BTN"]["VALUE"],
		"href" => $link
	],
	"image" => [
		"src" =>  $arResult["PREVIEW_PICTURE"]["SRC"],
		"alt" =>  $arResult["NAME"],
		"lazy" => true
	],
	"overlay" => true	
];

$arResult["TEMPLATE_DATA"] = [
	"action_banner" => $banner
];
