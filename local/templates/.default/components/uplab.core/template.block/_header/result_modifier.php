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

$config = Config::getInstance();

$btn_resume = $config->getLink("bar_form_resume");
$btn_faq = $config->getLink("bar_form_faq");

$entryId = $config->setEditLink($this, ["bar_form_resume", "bar_form_faq"]);

$twigData = [
	"menu" => [
		"bar" => [
			"attr" => " id=\"" . $this->GetEditAreaId($entryId) . "\" ",
			"hamburger" => [
				"text" => "Меню",
				"close_text" => "Закрыть"
			],
			"main_button" => [
				"href" => $btn_resume["href"],
				"icon" => [
					"name" => "24/edit"
				],
				"text" => $btn_resume["text"],
				"attr" => "data-modal data-effect='mfp-move-from-right'",
				"toggle_text" => "Закрыть",
			],		
			/*"button_list" => [
				[
					"href" => $btn_faq["href"],
					"icon" => [
						"name" => "24/question"
					],
					"text" => $btn_faq["text"],
					"badge" => [
						"text" => "2"
					],
					"attr" => "data-modal data-effect='mfp-move-from-right'",
					"toggle_text" => "Закрыть",	
				]
			],*/
			"service_block" => [
			]				
		]
	]	
];

$logo_white = $config->getFileWithAlt("logo_white");
$logo_color = $config->getFileWithAlt("logo_color");
$btn_contacts = $config->getLink("link_contacts");


$btn_fb = $config->getLink("soc_fb");
$btn_yt = $config->getLink("soc_yt");
$btn_vk = $config->getLink("soc_vk");
$btn_ok = $config->getLink("soc_ok");


$APPLICATION->IncludeComponent(
	"bitrix:menu",
	"simple",
	Array(
		"ALLOW_MULTI_SELECT" => "N",
		"CHILD_MENU_TYPE" => "right",
		"DELAY" => "N",
		"MAX_LEVEL" => "1",
		"MENU_CACHE_GET_VARS" => array(""),
		"MENU_CACHE_TIME" => "3600",
		"MENU_CACHE_TYPE" => "N",
		"MENU_CACHE_USE_GROUPS" => "Y",
		"ROOT_MENU_TYPE" => "right",
		"USE_EXT" => "N"
	),
	$this->__component
);

$right_menu_items = $arResult['TEMPLATE_DATA']['menuTreeResult'];


$APPLICATION->IncludeComponent(
	"bitrix:menu",
	"universal",
	Array(
		"ALLOW_MULTI_SELECT" => "N",
		"CHILD_MENU_TYPE" => "left",
		"DELAY" => "N",
		"MAX_LEVEL" => "2",
		"MENU_CACHE_GET_VARS" => array(""),
		"MENU_CACHE_TIME" => "3600",
		"MENU_CACHE_TYPE" => "N",
		"MENU_CACHE_USE_GROUPS" => "Y",
		"ROOT_MENU_TYPE" => "top",
		"USE_EXT" => "N"
	),
	$this->__component
);

$primary_nav = $arResult['TEMPLATE_DATA']['menuTreeResult'];



$content = [
	"logo" => [
		"src" => $logo_color["src"],
		"alter_src" => $logo_white["src"],
		"alt" => $logo_color["alt"]		
	],
	"link_list" => [
		[
			"main" => true,
			"href" => "mailto:".$config->getTextValue("email"),
			"text" => $config->getTextValue("email")
		],
		$btn_contacts,
		[
			"href" => "#",
			"text" => "!"
		]		
	],	
	"search" => [
		"link" => $config->getTextValue("search_link") 	
	],
	"secondary_nav" => [
		"heading" => [
			"text" => $config->getTextValue("info_title")
		],
		"items" => $right_menu_items
	],
	"button_major_list" => [
		$config->getLink('main_btn_1'),
		$config->getLink('main_btn_2')
	],
	"primary_nav" => $primary_nav
];

if ($APPLICATION->GetCurDir()!='/') {
	$content["logo"]["href"] = "/";
}

if ($btn_fb["href"] || $btn_yt["href"] || $btn_vk["href"] || $btn_ok["href"]) {
	$content_soc = [];
	if ($btn_fb["href"]) {
		$content_soc[] = [
			"href" => $btn_fb["href"],
			"icon" => "social/fb",
			"name" => "fb",
			"text" => $btn_fb["text"]			
		];
	}
	if ($btn_yt["href"]) {
		$content_soc[] = [
			"href" => $btn_yt["href"],
			"icon" => "social/yt",
			"name" => "yt",
			"text" => $btn_yt["text"]			
		];
	}
	if ($btn_vk["href"]) {
		$content_soc[] = [
			"href" => $btn_vk["href"],
			"icon" => "social/vk",
			"name" => "vk",
			"text" => $btn_vk["text"]			
		];
	}
	if ($btn_ok["href"]) {
		$content_soc[] = [
			"href" => $btn_ok["href"],
			"icon" => "social/ok",
			"name" => "ok",
			"text" => $btn_ok["text"]			
		];
	}
	$content["social"] = $content_soc;
}

$twigData["menu"]["content"] = $content;

$arResult["TEMPLATE_DATA"] = $twigData;
