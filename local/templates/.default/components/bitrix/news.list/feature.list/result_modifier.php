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
		"heading" => $arItem["NAME"],
		"content" => [
			"text" => $arItem["PREVIEW_TEXT"]
		]
	];
	
	if ($arItem["PROPERTIES"]["IMG"]["VALUE"]) {
		$arSliderItem["icon"]["name"] = CFile::GetPath($arItem["PROPERTIES"]["IMG"]["VALUE"]);
	}
	if ($arItem["PROPERTIES"]["LINK"]["VALUE"]) {
		$arSliderItem["content"]["link_list"] = [
			[
				"href" => $arItem["PROPERTIES"]["LINK"]["VALUE"],
				"text" => $arItem["PROPERTIES"]["LINK"]["DESCRIPTION"]
			]
		];
	}
	
	$arSlider[] = $arSliderItem;
}

if (empty($arSection)) {
	$arSection = CIBlockSection::GetList(Array($by=>$order), ["CODE" => $arParams["PARENT_SECTION_CODE"], "IBLOCK_ID" => $arParams["IBLOCK_ID"]], false, ["ID","NAME","UF_*"])->Fetch();
}

if ($arSection["UF_NUM_LIST"]) {
	$templateName = "&feature-list-ol";
} else {
	$templateName = "&feature-list";	
}

if ($arSection["UF_SLIDER"]) {
	$templateName = $templateName.'-slider';
}

$twigData = [
	"template_name" => $templateName,
	"feature_list" => [
		"layout" => $arSection["UF_3_COLS"],
		"background_color" => ($arSection["UF_ORANGE"]?"primary":''),
		"items" => $arSlider,			
	]	
];

if ($arSection["UF_SLIDER"]) {
	$twigData["feature_list"]["heading"] = $arSection["NAME"];
}

$arResult["TEMPLATE_DATA"] = $twigData;
