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

$insConfig = Config::getInstance();

$arSlider = [];

$rnd = $this->randString();

$elementEdit = CIBlock::GetArrayByID($arParams['IBLOCK_ID'], 'ELEMENT_EDIT');
$elementDelete = CIBlock::GetArrayByID($arParams['IBLOCK_ID'], 'ELEMENT_DELETE');

foreach($arResult["ITEMS"] as $arItem) {


	$entryId = $arItem['ID'] . $rnd;
	$this->AddEditAction($entryId, $arItem['EDIT_LINK'], $elementEdit);
	$this->AddDeleteAction($entryId, $arItem['DELETE_LINK'], $elementDelete);
		
	$arSliderItem = [
		"attr" => " id=\"" . $this->GetEditAreaId($entryId) . "\" ",
		"image" => [
			"src" => CFile::GetPath($arItem["PROPERTIES"]["IMG_DESKTOP"]["VALUE"]),
			"srcset" => [
				[
					"scale" => "2",
					"src" => CFile::GetPath($arItem["PROPERTIES"]["IMG_DESKTOP"]["VALUE"])
				]
			],
			"alt" => "",
			"mob" => [
				"srcset" => [
					[
						"scale" => "1",
						"src" => CFile::GetPath($arItem["PROPERTIES"]["IMG_MOB"]["VALUE"])
					],
					[
						"scale" => "2",
						"src" => CFile::GetPath($arItem["PROPERTIES"]["IMG_MOB"]["VALUE"])
					]
				]
			],
			"tab" => [
				"srcset" => [
					[
						"scale" => "1",
						"src" => CFile::GetPath($arItem["PROPERTIES"]["IMG_TAB"]["VALUE"])
					],
					[
						"scale" => "2",
						"src" => CFile::GetPath($arItem["PROPERTIES"]["IMG_TAB"]["VALUE"])
					]
				]
			]
		],
		"text" => $arItem["~NAME"],
		"date" => $arItem["PROPERTIES"]["LABELS"]["VALUE"][0],		
	];
	
	
	$arSlider[] = $arSliderItem;
}

$twigData = [
	"gallery_slider" => [
		"items" => $arSlider,			
	]	
];

$arResult["TEMPLATE_DATA"] = $twigData;
