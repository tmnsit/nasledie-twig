<?
defined("B_PROLOG_INCLUDED") && B_PROLOG_INCLUDED === true || die();
/**
 * @global CMain $APPLICATION
 * @var array    $arParams
 * @var array    $arResult
 */


$arItems = [];
foreach ($arResult["ITEMS"] as $item) {
	$this->AddEditAction($item["ID"], $item["EDIT_LINK"]);

	$arItems[] = [
		// Добавить {{ item.attr|raw }} в шаблоне
		"attr" => " id=\"" . $this->GetEditAreaId($item["ID"]) . "\" ",
		"name" => $item["NAME"],
	];
}


$arResult["TEMPLATE_DATA"] = [
	"items" => $arItems,
];