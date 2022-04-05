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

$logoHeader = \Bitrix\Main\Config\Option::get("nasledie.config", "logo_header");
$twigData["header"]["logo"]["src"] = CFile::ResizeImageGet($logoHeader, array('width'=>420, 'height'=>420), BX_RESIZE_IMAGE_PROPORTIONAL, true)["src"];

$logoHeaderMobile = \Bitrix\Main\Config\Option::get("nasledie.config", "logo_header_mobile");
$twigData["header"]["logoMobile"]["src"] = CFile::ResizeImageGet($logoHeaderMobile, array('width'=>270, 'height'=>270), BX_RESIZE_IMAGE_PROPORTIONAL, true)["src"];
$twigData["header"]["logoMobile"]["alt"] = "logo";

$APPLICATION->IncludeComponent(
	"bitrix:menu",
	"main",
	Array(
		"ALLOW_MULTI_SELECT" => "N",
		"CHILD_MENU_TYPE" => "top.sub",
		"DELAY" => "N",
		"MAX_LEVEL" => "2",
		"MENU_CACHE_GET_VARS" => array(""),
		"MENU_CACHE_TIME" => "3600",
		"MENU_CACHE_TYPE" => "Y",
		"MENU_CACHE_USE_GROUPS" => "Y",
		"ROOT_MENU_TYPE" => "top",
		"USE_EXT" => "N"
	),
	$this->__component
);

$i = 0;
$j = 0;
foreach ($arResult["TEMPLATE_DATA"]["menuTreeResult"] as $key_nav => $value_nav) {
    $twigData["nav"][$i]["title"] = $value_nav["TEXT"];
    $twigData["nav"][$i]["href"] = $value_nav["LINK"];
	if (!empty($value_nav["CHILD"])) {
		foreach ($value_nav["CHILD"] as $key_sub_nav => $value_sub_nav) {
			$twigData["nav"][$i]["submenu"][$j]["title"] = $value_sub_nav["TEXT"];
			if (strstr($value_sub_nav["LINK"], "#")) {
				$twigData["nav"][$i]["submenu"][$j]["href"] = $value_nav["LINK"].$value_sub_nav["LINK"];
			} else {
				$twigData["nav"][$i]["submenu"][$j]["href"] = $value_sub_nav["LINK"];
			}
			$j++;
		}
	}
	$i++;
	$j=0;
}

// $twigData["location"] = "Тюмень";
$phone = \Bitrix\Main\Config\Option::get("nasledie.config", "header_phone");
$twigData["tel"] = [
    "href" => preg_replace("/[^0-9]/", '', $phone),
    "content" => $phone,
];
$twigData["workTime"] = \Bitrix\Main\Config\Option::get("nasledie.config", "timetable");

$arResult["TEMPLATE_DATA"] = $twigData;