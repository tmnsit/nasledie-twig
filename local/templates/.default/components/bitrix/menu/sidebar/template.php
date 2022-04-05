<?
use Uplab\Core\Data\StringUtils;
use Uplab\Core\Helper;


defined("B_PROLOG_INCLUDED") && B_PROLOG_INCLUDED === true || die();
/**
 * @global CMain $APPLICATION
 * @var array    $arParams
 * @var array    $arResult
 */


/**
 * @param $item
 *
 * @return array
 */
$changeKeys = function ($item) {
	$item = array_intersect_key($item, array_flip([
		"TEXT",
		"LINK",
		"HREF",
		"SELECTED",
		"IS_PARENT",
		"ICON",
		"TARGET",
	]));

	$newItem = [];
	foreach ($item as $key => $value) {
		$newItem[StringUtils::convertUnderScoreToCamelCase($key)] = $value;
	}

	return $newItem;
};

$isDomains = $arParams["USE_DOMAIN_IN_URLS"] == "Y";

$arMenu = [];
$prevLevel = 0;
// var_dump($arResult);
foreach ($arResult as $item) {
	$item["text"] = $item["TEXT"];
	$item["href"] = $item["PARAMS"]["URL"] ?: $item["LINK"];
	$item["SELECTED"] = $item["LINK"] == $arParams["CUR_PAGE"];
	$item["HREF"] = $item["LINK"];

	if ($item["PARAMS"]["ICON"]) {
		$item["ICON"] = $item["PARAMS"]["ICON"];
	}

	if ($item["PARAMS"]["TARGET"]) {
		$item["TARGET"] = $item["PARAMS"]["TARGET"];
	}

	if ($isDomains) {
		$item["LINK"] = Helper::makeDomainUrl($item["LINK"]);
	}

	if ($item["DEPTH_LEVEL"] == 1 || empty($rootItem)) {
		unset($rootItem);
		$rootItem = call_user_func($changeKeys, $item);
		$arMenu[] = &$rootItem;
	} else {
		$rootItem["subMenu"][] = call_user_func($changeKeys, $item);
		// d($item, "subItem");
	}
	$prevLevel = $item["DEPTH_LEVEL"];
}


$parentComponent = $this->__component->__parent;
$parentComponent->arResult["TEMPLATE_DATA"]["menuTreeResult"] = $arMenu;
