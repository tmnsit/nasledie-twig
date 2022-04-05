<?
use Bitrix\Main\Application;


defined("B_PROLOG_INCLUDED") && B_PROLOG_INCLUDED === true || die();
/**
 * @global CMain      $APPLICATION
 * @var array         $arParams
 * @var array         $arResult
 * @var TemplateBlock $component
 */

$arElement = CIBlockElement::GetByID($arResult["ITEM"]["ID"])->Fetch();
$arLink = explode("?v=", $arResult["ITEM"]["PROPERTIES"]["VIDEO"]["VALUE"]);
$twigData = [
	"story_media"=> [
		"video" => [
			"provider" => "youtube",
			"src" => $arLink[count($arLink)-1],
			"poster" => CFile::GetPath($arElement["PREVIEW_PICTURE"]),
			"description" => $arResult["ITEM"]["NAME"]
		],
		"heading"=>$arResult["ITEM"]["NAME"],
		"text"=>$arResult["ITEM"]["PROPERTIES"]["DATE"]["VALUE"]
	]
];
$arResult["TEMPLATE_DATA"] = $twigData;