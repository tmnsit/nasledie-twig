<?
use Bitrix\Main\Application;


defined("B_PROLOG_INCLUDED") && B_PROLOG_INCLUDED === true || die();
/**
 * @global CMain      $APPLICATION
 * @var array         $arParams
 * @var array         $arResult
 * @var TemplateBlock $component
 */

$arItems = [];
foreach($arResult["ITEM"]["PROPERTIES"]["PHOTOS"]["VALUE"] as $key => $iValue) {
	
	$arRescription = explode("|", $arResult["ITEM"]["PROPERTIES"]["PHOTOS"]["DESCRIPTION"][$key]);
	
	$arPhoto = [
		"image" => [
			"src" => CFile::GetPath($iValue),
			"alt" => $arRescription[0]
		],
		"text" => $arRescription[0]
	];
	if ($arRescription[1]) {
		$arPhoto["date"] = $arRescription[1];
	}
	$arItems[] = $arPhoto;
}

$twigData = [
	"gallery_slider"=> [
		"items"=> $arItems
	]
];





$arResult["TEMPLATE_DATA"] = $twigData;