<?
use Bitrix\Main\Application;
use Uplab\Core\Components\TemplateBlock;
use Uplab\Core\Helper;


defined("B_PROLOG_INCLUDED") && B_PROLOG_INCLUDED === true || die();
/**
 * @global CMain      $APPLICATION
 * @var array         $arParams
 * @var array         $arResult
 * @var TemplateBlock $component
 */


// TODO: Указать вместо __MODULE_NAMESPACE__ корректный путь к неймспейсу проекта


$img = [];
if (($f = $arParams["IMG_SRC"]) && ($f = Application::getDocumentRoot() . $f) && file_exists($f)) {
	$img = [
		"src" => Helper::resizeImageFile($f, [
			"width"  => 800,
			"height" => 800,
			"method" => BX_RESIZE_IMAGE_PROPORTIONAL_ALT,
		]),
		"alt" => $arParams["~IMG_ALT"],
	];
}


$phone = [];
if ($v = $arParams["PHONE"]) {
	$phone = [
		"text" => $v,
		"href" => "tel:" . \Uplab\Core\Data\StringUtils::clearPhone($v),
	];
}


$slider = [];
$arSlider = TemplateBlock::parseDynamicGroupFromParams("SLIDE", $arParams, $arResult);
foreach ($arSlider as $arSlide) {
	$slider[] = [
		"heading" => $arSlide["HEADING"],
		"img"     => [
			"src" => $arSlide["IMAGE"],
			"alt" => $arSlide["IMAGE_ALT"],
		],
		"number"  => $arSlide["NUMBER"],
	];
}


$arResult["TEMPLATE_DATA"] = [
	"class"          => __MODULE_NAMESPACE__\Helper::getUtilityClassesFromParams($arParams, $arResult),
	"component_data" => [
		"heading" => $arParams["~HEADING"],
		"text"    => $arParams["~TEXT"],
		"img"     => $img,
		"phone"   => $phone,
	],
	"actions"        => __MODULE_NAMESPACE__\Helper::getActionsFromParams($arParams, $arResult),
];

