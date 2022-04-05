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

$breadcrumbs = $APPLICATION->GetNavChain(
	false,
	0,
	"/local/templates/.default/chain_template.php",
	true,
	false
);	
//$breadcrumbs[count($breadcrumbs)-1]["href"] = $arResult["LIST_PAGE_URL"];

$twigData = [];
$twigData["hero"] = [
	"breadcrumb" => $breadcrumbs,
	"heading" => $arResult["NAME"],
	"backward_link" => [
		"href" => $arResult["LIST_PAGE_URL"],
		"text" => "Вернуться назад",
		"title"  => "Вернуться назад",
		"external" => false
	],
	"image" => [
		"src" => CFile::GetPath($arResult["PROPERTIES"]["IMG_DESKTOP"]["VALUE"][0]),
		"alt" => $arResult["NAME"],
		"srcset" => [
			[
				"scale" => "2",
				"src" => CFile::GetPath(($arResult["PROPERTIES"]["IMG_DESKTOP"]["VALUE"][1]?$arResult["PROPERTIES"]["IMG_DESKTOP"]["VALUE"][1]:$arResult["PROPERTIES"]["IMG_DESKTOP"]["VALUE"][0]))
			]
		],		
		"mob" => [
			"srcset" => [
				[
					"scale" => "1",
					"src" => CFile::GetPath($arResult["PROPERTIES"]["IMG_MOB"]["VALUE"][0])
				],
				[
					"scale" => "2",
					"src" => CFile::GetPath(($arResult["PROPERTIES"]["IMG_MOB"]["VALUE"][1]?$arResult["PROPERTIES"]["IMG_MOB"]["VALUE"][1]:$arResult["PROPERTIES"]["IMG_MOB"]["VALUE"][0]))
				]
			]
		],
		"tab" => [
			"srcset" => [
				[
					"scale" => "1",
					"src" => CFile::GetPath($arResult["PROPERTIES"]["IMG_TAB"]["VALUE"][0])
				],
				[
					"scale" => "2",
					"src" => CFile::GetPath(($arResult["PROPERTIES"]["IMG_TAB"]["VALUE"][1]?$arResult["PROPERTIES"]["IMG_TAB"]["VALUE"][1]:$arResult["PROPERTIES"]["IMG_TAB"]["VALUE"][0]))
				]
			]
		],		
		"lazy"=> false,
	]
];


if ($arResult["PROPERTIES"]["ANOUNCE"]["VALUE"]) {
	$twigData["hero"]["quote_block"] = [
		"items" => [
			[
				"icon" => [
					"name" => "64/".($arParams["ICON_DETAIL"]?$arParams["ICON_DETAIL"]:"quote"),
					"size" => "large"
				],
				"text" => $arResult["PROPERTIES"]["ANOUNCE"]["VALUE"],
				"bottom" => [
					"text" => ($arResult["PROPERTIES"]["POSITION"]["VALUE"]?$arResult["PROPERTIES"]["POSITION"]["VALUE"]:$arResult["DISPLAY_ACTIVE_FROM"]),
					"desc" => ($arResult["PROPERTIES"]["NAME_ORG"]["VALUE"]?$arResult["PROPERTIES"]["NAME_ORG"]["VALUE"]:$arResult["PROPERTIES"]["TAG"]["VALUE"])
				]				
			]
		]
	];
}	

$twigData["user_content_story"] = [
	"dev" => false,
	"content" => $arResult["~DETAIL_TEXT"],
	"footer" => [
		"link" => [
			"href" => $arResult["LIST_PAGE_URL"],
			"text" => $arParams["ANCOR_LINK_LIST"]
		]
	]
];
if ($arParams["HIDE_SHARE"]!="Y") {
	$twigData["unit_share"] = [
		"heading" => "Поделиться",
		"list" => [
			"facebook",
			"vkontakte",
			"odnoklassniki"
		]
	];
}

$logo_white = $insConfig->getFileWithAlt("logo_white");
$logo_color = $insConfig->getFileWithAlt("logo_color");
$btn_contacts = $insConfig->getLink("link_contacts");


$content = [
	"logo" => [
		"src" => $logo_color["src"],
		"alter_src" => $logo_white["src"],
		"href" => "/",
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

$twigData["menu"]["content"] = $content;
	
$arResult["TEMPLATE_DATA"] = $twigData;
