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

$btn_fb = $config->getLink("soc_fb");
$btn_yt = $config->getLink("soc_yt");
$btn_vk = $config->getLink("soc_vk");
$btn_ok = $config->getLink("soc_ok");


$btn_cookie = $config->getLink("btn_cookie");
$btn_made_by = $config->getLink("btn_made_by");


$APPLICATION->IncludeComponent(
	"bitrix:menu",
	"simple",
	Array(
		"ALLOW_MULTI_SELECT" => "N",
		"CHILD_MENU_TYPE" => "footerlinks",
		"DELAY" => "N",
		"MAX_LEVEL" => "1",
		"MENU_CACHE_GET_VARS" => array(""),
		"MENU_CACHE_TIME" => "3600",
		"MENU_CACHE_TYPE" => "N",
		"MENU_CACHE_USE_GROUPS" => "Y",
		"ROOT_MENU_TYPE" => "footerlinks",
		"USE_EXT" => "N"
	),
	$this->__component
);

$footer_links = $arResult['TEMPLATE_DATA']['menuTreeResult'];

$APPLICATION->IncludeComponent(
	"bitrix:menu",
	"simple",
	Array(
		"ALLOW_MULTI_SELECT" => "N",
		"CHILD_MENU_TYPE" => "footer",
		"DELAY" => "N",
		"MAX_LEVEL" => "1",
		"MENU_CACHE_GET_VARS" => array(""),
		"MENU_CACHE_TIME" => "3600",
		"MENU_CACHE_TYPE" => "N",
		"MENU_CACHE_USE_GROUPS" => "Y",
		"ROOT_MENU_TYPE" => "footer",
		"USE_EXT" => "N"
	),
	$this->__component
);

$footer_items = $arResult['TEMPLATE_DATA']['menuTreeResult'];

$APPLICATION->IncludeComponent(
	"bitrix:menu",
	"simple",
	Array(
		"ALLOW_MULTI_SELECT" => "N",
		"CHILD_MENU_TYPE" => "footersub",
		"DELAY" => "N",
		"MAX_LEVEL" => "1",
		"MENU_CACHE_GET_VARS" => array(""),
		"MENU_CACHE_TIME" => "3600",
		"MENU_CACHE_TYPE" => "N",
		"MENU_CACHE_USE_GROUPS" => "Y",
		"ROOT_MENU_TYPE" => "footersub",
		"USE_EXT" => "N"
	),
	$this->__component
);

$footer_subitems = $arResult['TEMPLATE_DATA']['menuTreeResult'];


$twigData = [
	"footer" => [
		"nav" => [
			"items" => $footer_items,
			"sub_items" => $footer_subitems, 
		],
		"contacts" => [
			"phone" => [
				"href" => "tel:".str_replace(" ", "", $config->getTextValue("phone")),
				"text" => $config->getTextValue("phone")
			],
			"email" => [
				"href" => "mailto:".$config->getTextValue("email"),
				"text" => $config->getTextValue("email")
			],
		],
		"copyright" => $config->getTextValue("copy_text"),
		"links" => $footer_links,
		"cookies" => $btn_cookie,
		"made_by" => $btn_made_by,
		"uplab" => $config->getTextValue("copyright")
	]
];

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
	$twigData["footer"]["contacts"]["social"] = $content_soc;
}

$arResult["TEMPLATE_DATA"] = $twigData;