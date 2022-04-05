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
			"alt" => "Роборука",
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
		"heading" => $arItem["~NAME"],
		"actions" => [
			[
				"href" => $arItem["PROPERTIES"]["BTN"]["DESCRIPTION"],
				"text" => $arItem["PROPERTIES"]["BTN"]["VALUE"]
			]
		],		
	];
	
	foreach($arItem["PROPERTIES"]["LABELS"]["VALUE"] as $key => $sLabel) {
		$suffix = '';
		if (strpos($sLabel, "+")) {
			$suffix = '+';
			$sLabel = str_replace("+", "", $sLabel);
		}
		
		
		$arSliderItem["factor_list"][] = 
			[
				"heading_color" => "white",
				"separator" => " ",
				"heading" => $sLabel,
				"suffix" => $suffix,
				"text" => $arItem["PROPERTIES"]["LABELS"]["DESCRIPTION"][$key]
			];
	}
	
	$arSlider[] = $arSliderItem;
}


$entryId = $insConfig->setEditLink($this, ["main_btn_1", "main_btn_2"]);

$twigData = [
	"hero" => [
		"heading" => "",
		"overlay" => true,

		"slider" => $arSlider,
		"button_group" => [
			"attr" => " id=\"" . $this->GetEditAreaId($entryId) . "\" ",
			"layout" => "2",
			"items" => [			
					$insConfig->getLink('main_btn_1'),
					$insConfig->getLink('main_btn_2')
				]
		],
		"btn_down_scroll" => [
			"title" => ""
		]				
	],
	"search_bar" => [
		"form" => [
			"action" => "/search/",
			"method" => "GET",
			"input" => [
				"name" => "q",
				"placeholder" => "Поиск по сайту"
			]
		]
	]
];


$logo_white = $insConfig->getFileWithAlt("logo_white");
$logo_color = $insConfig->getFileWithAlt("logo_color");
$btn_contacts = $insConfig->getLink("link_contacts");


$content = [
	"logo" => [
		"src" => $logo_color["src"],
		"alter_src" => $logo_white["src"],
		"alt" => $logo_color["alt"]		
	],
	"link_list" => [
		[
			"main" => true,
			"href" => "mailto:".$insConfig->getTextValue("email"),
			"text" => $insConfig->getTextValue("email")
		],
		$btn_contacts,
		[
			"href" => "#",
			"text" => "!"
		]		
	],	
];


if ($APPLICATION->GetCurDir()!='/') {
	$content["logo"]["href"] = "/";
}
$twigData["menu"]["content"] = $content;

$arResult["TEMPLATE_DATA"] = $twigData;
