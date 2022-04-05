<?
use Bitrix\Main\Application;


defined("B_PROLOG_INCLUDED") && B_PROLOG_INCLUDED === true || die();
/**
 * @global CMain      $APPLICATION
 * @var array         $arParams
 * @var array         $arResult
 * @var TemplateBlock $component
 */

$twigData = [
	"story_media"=> [
		"image"=> [
			"src"=>CFile::GetPath($arResult["ITEM"]["PROPERTIES"]["IMG_DESKTOP"]["VALUE"][0]),
			"srcset"=> [
				[
					"scale"=>"2",
					"src"=>CFile::GetPath($arResult["ITEM"]["PROPERTIES"]["IMG_DESKTOP"]["VALUE"][1]?$arResult["ITEM"]["PROPERTIES"]["IMG_DESKTOP"]["VALUE"][1]:$arResult["ITEM"]["PROPERTIES"]["IMG_DESKTOP"]["VALUE"][0])
				]
			],
			"tab"=> [
				"srcset"=> [
					[
						"scale"=>"1",
						"src"=>CFile::GetPath($arResult["ITEM"]["PROPERTIES"]["IMG_TAB"]["VALUE"][0]),
					],
					[
						"scale"=>"2",
						"src"=>CFile::GetPath($arResult["ITEM"]["PROPERTIES"]["IMG_TAB"]["VALUE"][1]?$arResult["ITEM"]["PROPERTIES"]["IMG_TAB"]["VALUE"][1]:$arResult["ITEM"]["PROPERTIES"]["IMG_TAB"]["VALUE"][0])
					]
				]
			],
			"mob"=> [
				"srcset"=> [
					[
						"scale"=>"1",
						"src"=>CFile::GetPath($arResult["ITEM"]["PROPERTIES"]["IMG_MOB"]["VALUE"][0]),
					],
					[
						"scale"=>"2",
						"src"=>CFile::GetPath($arResult["ITEM"]["PROPERTIES"]["IMG_MOB"]["VALUE"][1]?$arResult["ITEM"]["PROPERTIES"]["IMG_MOB"]["VALUE"][1]:$arResult["ITEM"]["PROPERTIES"]["IMG_MOB"]["VALUE"][0])
					]
				]
			],
			"alt"=>$arResult["ITEM"]["NAME"]
		],
		"heading"=>$arResult["ITEM"]["NAME"],
		"text"=>$arResult["ITEM"]["PROPERTIES"]["DATE"]["VALUE"]
	]
];
$arResult["TEMPLATE_DATA"] = $twigData;