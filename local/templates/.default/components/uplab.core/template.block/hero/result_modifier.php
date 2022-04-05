<?
use Bitrix\Main\Application;
use EuroCement\Local\Helper;
use Uplab\Core\Components\TemplateBlock;
use EuroCement\Local\Config;


defined("B_PROLOG_INCLUDED") && B_PROLOG_INCLUDED === true || die();	

$insConfig = Config::getInstance();

$breadcrumbs = $APPLICATION->GetNavChain(
	false,
	0,
	"/local/templates/.default/chain_template.php",
	true,
	false
);	


$obElement = CIBlockElement::GetList([],["IBLOCK_ID" => HEADERS_IBLOCK, "CODE" => $arParams["BG_CODE"]], false, ["nPageSize" => 1])->GetNextElement();
if ($obElement) {
	$arElementInfo = $obElement->GetFields();
	$arHeaderData = $obElement->GetProperties();
	$btn = [];
	if ($arHeaderData["BTN"]["VALUE"]) {
		$btn = [
			"text" => $arHeaderData["BTN"]["VALUE"],
			"href" => $arHeaderData["BTN"]["DESCRIPTION"],
			"theme" => "border-white",
			"hover" => "white"
		];
	}
	
	$bg = [];
	if ($arHeaderData["IMG_DESKTOP"]["VALUE"][0]) {
		$bg = [
			"src" => CFile::GetPath($arHeaderData["IMG_DESKTOP"]["VALUE"][0]),
			"alt" => $APPLICATION->GetTitle(false),
			"lazy" => true		
		];
				
		if ($arHeaderData["IMG_DESKTOP"]["VALUE"][1]) {
			$bg["srcset"] = [
				[
					"scale" => "2",
					"src" => CFile::GetPath(($arHeaderData["IMG_DESKTOP"]["VALUE"][1])?$arHeaderData["IMG_DESKTOP"]["VALUE"][1]:$arHeaderData["IMG_DESKTOP"]["VALUE"][0])
				]
			];
		}
		if ($arHeaderData["IMG_MOB"]["VALUE"][0]) {
			$bg["mob"]["srcset"][] = [
				"scale" => "1",
				"src" => CFile::GetPath($arHeaderData["IMG_MOB"]["VALUE"][0])
			];
			if ($arHeaderData["IMG_MOB"]["VALUE"][1]) {
				$bg["mob"]["srcset"][] = [
					"scale" => "2",
					"src" => CFile::GetPath($arHeaderData["IMG_MOB"]["VALUE"][1])
				];
			}
		}
		if ($arHeaderData["IMG_TAB"]["VALUE"][0]) {
			$bg["tab"]["srcset"][] = [
				"scale" => "1",
				"src" => CFile::GetPath($arHeaderData["IMG_TAB"]["VALUE"][0])
			];
			if ($arHeaderData["IMG_TAB"]["VALUE"][1]) {
				$bg["tab"]["srcset"][] = [
					"scale" => "2",
					"src" => CFile::GetPath($arHeaderData["IMG_TAB"]["VALUE"][1])
				];
			}
		}
	}
	
	
	$twigData = [
		"hero" => [
			"breadcrumb" => $breadcrumbs,
			"overlay"     => true,
			"heading"     => $APPLICATION->GetTitle(false),
			"text"        => $APPLICATION->GetProperty("subtitle"),
			"actions"     => [],
			"bg"          => []
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
	if (!empty($arHeaderData["BG_COLOR"]["VALUE_XML_ID"]) && $arHeaderData["BG_COLOR"]["VALUE_XML_ID"]!="default") {
		$twigData["hero"]["bg_color"] = $arHeaderData["BG_COLOR"]["VALUE_XML_ID"];
	}
	if ($arHeaderData["STORY_HERO"]["VALUE"] == "Да") {
		$twigData["hero"]["show_story_hero"] = true;
		
		$twigData["hero"]["quote_block"] = [
			"items" => [
				[
					"icon" => [
						"name" => "64/quote",
						"size" => "large"
					],
					"text" => $arElementInfo["PREVIEW_TEXT"],
					"bottom" => [
						"text" => $arHeaderData["INFO_TEXT"]["VALUE"],
						"desc" => $arHeaderData["CONTACTS"]["VALUE"][0]
					]
				]				
			]
		];	
		$twigData["hero"]["image"] = $bg;
		
	} elseif ($arHeaderData["BIG_HERO"]["VALUE"] == "Да") {
		$twigData["hero"]["show_big_hero"] = true;
		$twigData["hero"]["info_text"] = $arHeaderData["INFO_TEXT"]["~VALUE"];
		
		foreach($arHeaderData["CONTACTS"]["VALUE"] as $key => $sVal) {
			$twigData["hero"]["contact_list"][] = [
				"href" => "tel:".str_replace([" ", "(",")","-"], "", $sVal),
				"text" => $sVal,
				"description" => $arHeaderData["CONTACTS"]["DESCRIPTION"][$key]				
			];
		}
		
		$arBtns = [];

		$APPLICATION->IncludeComponent(
			"bitrix:menu",
			"simple-desc",
			Array(
				"ALLOW_MULTI_SELECT" => "N",
				"CHILD_MENU_TYPE" => "lineorange",
				"DELAY" => "N",
				"MAX_LEVEL" => "2",
				"MENU_CACHE_GET_VARS" => array(""),
				"MENU_CACHE_TIME" => "3600",
				"MENU_CACHE_TYPE" => "N",
				"MENU_CACHE_USE_GROUPS" => "Y",
				"ROOT_MENU_TYPE" => "lineorange",
				"USE_EXT" => "N"
			),
			$this->__component
		);
		
		$arBtns = $arResult['TEMPLATE_DATA']['menuTreeResult'];
		
		if ($arBtns) {
			$twigData["hero"]["button_group"] = [
				"layout" => 2,
				"items" => $arBtns	
			];
		}
				
	} else {
		$twigData["hero"]["show_big_hero"] = false;
	}
	
	
	if ($btn) {
		$twigData["hero"]["actions"][] = $btn;
	}
	if ($bg) {
		$twigData["hero"]["bg"] = $bg;
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

}
$arResult["TEMPLATE_DATA"] = $twigData;

