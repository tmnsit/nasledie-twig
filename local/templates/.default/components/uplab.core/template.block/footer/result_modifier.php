<?
use Bitrix\Main\Application;
use ProjectName\Local\Helper;
use Uplab\Core\Components\TemplateBlock;
use ProjectName\Local\Config;

defined("B_PROLOG_INCLUDED") && B_PROLOG_INCLUDED === true || die();
/**
 * @global CMain      $APPLICATION
 * @var array         $arParams
 * @var array         $arResult
 * @var TemplateBlock $component
*/

$logoHeader = \Bitrix\Main\Config\Option::get("nasledie.config", "logo_footer");
$twigData["footer"]["logo"]["src"] = CFile::ResizeImageGet($logoHeader, array('width'=>285, 'height'=>285), BX_RESIZE_IMAGE_PROPORTIONAL, true)["src"];

$twigData["footer"]["logo"]["alt"] = "logo";
$twigData["footer"]["form"]["title"] = "Остались вопросы?";
$twigData["footer"]["form"]["text"] = "Оставьте свои контактные данные и мы перезвоним";
$twigData["footer"]["form"]["id"] = "footer-form";


$twigData["footer"]["button"]["type"] = "submit";
$twigData["footer"]["button"]["theme"] = "border-white";
$twigData["footer"]["button"]["text"] = "Оставить заявку";

$APPLICATION->IncludeComponent(
	"bitrix:menu",
	"main",
	Array(
		"ALLOW_MULTI_SELECT" => "N",
		"CHILD_MENU_TYPE" => "",
		"DELAY" => "N",
		"MAX_LEVEL" => "1",
		"MENU_CACHE_GET_VARS" => array(""),
		"MENU_CACHE_TIME" => "3600",
		"MENU_CACHE_TYPE" => "N",
		"MENU_CACHE_USE_GROUPS" => "Y",
		"ROOT_MENU_TYPE" => "top",
		"USE_EXT" => "N"
	),
	$this->__component
);

foreach ($arResult["TEMPLATE_DATA"]["menuTreeResult"] as $key_nav => $value_nav) {
    $twigData["nav"][$key_nav]["title"] = $value_nav["TEXT"];
    $twigData["nav"][$key_nav]["href"] = $value_nav["LINK"];
}

$phone = \Bitrix\Main\Config\Option::get("nasledie.config", "footer_phone");
$twigData["telRealization"]["href"] = preg_replace("/[^0-9]/", '', $phone);
$twigData["telRealization"]["content"] = $phone;
$twigData["address"]["text"] = \Bitrix\Main\Config\Option::get("nasledie.config", "footer_address");
$twigData["email"] = \Bitrix\Main\Config\Option::get("nasledie.config", "footer_email");

// персональные данные
$twigData["footer"]["form"]["personal"]["href"] = \Bitrix\Main\Config\Option::get("nasledie.config", "personal_data_link");
// пользовательское соглашение
$twigData["userAgreement"]["link"] = \Bitrix\Main\Config\Option::get("nasledie.config", "arragment_link");

// mobile btn form
$twigData["footer"]["buttonPopup"]["href"] = "#callback-form";
$twigData["footer"]["buttonPopup"]["theme"] = "white";
$twigData["footer"]["buttonPopup"]["text"] = "Оставить заявку";
$twigData["footer"]["buttonPopup"]["attr"] = "data-fancybox";

$arResult["TEMPLATE_DATA"] = $twigData;