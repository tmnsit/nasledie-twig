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

$arSection = [];

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
		"href" => $arItem["PROPERTIES"]["LINK"]["VALUE"],
		"heading" => $arItem["NAME"],
		"list" => explode("\n", $arItem["PREVIEW_TEXT"])
	];
	
	if ($arItem["PROPERTIES"]["IMG"]["VALUE"]) {
		$arSliderItem["icon"] = [
			"name" => CFile::GetPath($arItem["PROPERTIES"]["IMG"]["VALUE"]),
			"size" => "large"
		];
	}
	
	$arSlider[] = $arSliderItem;
}


$twigData = [
	"feature_list" => [
		"items" => $arSlider,			
	]
];



$arResult["TEMPLATE_DATA"] = $twigData;
