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
$arColors = [
	"#242C32", "#E3350F", "#F28610", "#F7B670", "#242C32", "#E3350F", "#F28610", "#F7B670", "#242C32", "#E3350F", "#F28610", "#F7B670"
];
$arItems = [];

$rnd = $this->randString();

$elementEdit = CIBlock::GetArrayByID($arParams['IBLOCK_ID'], 'ELEMENT_EDIT');
$elementDelete = CIBlock::GetArrayByID($arParams['IBLOCK_ID'], 'ELEMENT_DELETE');
	
foreach($arResult["ITEMS"] as $arItem) {

	$entryId = $arItem['ID'] . $rnd;
	$this->AddEditAction($entryId, $arItem['EDIT_LINK'], $elementEdit);
	$this->AddDeleteAction($entryId, $arItem['DELETE_LINK'], $elementDelete);
	
	$arDiapasons = [];
	
	foreach($arItem["PROPERTIES"]["DIAPASONS"]["VALUE"] as $sKey => $iNumber) {
		$arDiapasons[] = [
			"label" => $arItem["PROPERTIES"]["DIAPASONS"]["DESCRIPTION"][$sKey],
			"value" => $iNumber,
			"text" => $iNumber."%",
			"color" => $arColors[$sKey]			
		];
	}
	
	$arTwigItem = [
		"attr" => " id=\"" . $this->GetEditAreaId($entryId) . "\" ",
		"columns" => true,
		"heading" => $arItem["NAME"],
		"data" => $arDiapasons
	];
	
	
	$arItems[] = $arTwigItem;
}

if (empty($arSection)) {
	$arSection = CIBlockSection::GetList(Array($by=>$order), ["CODE" => $arParams["PARENT_SECTION_CODE"], "IBLOCK_ID" => $arParams["IBLOCK_ID"]], false, ["ID","NAME","UF_*"])->Fetch();
}


$twigData = [
	"diagram_bar_layout" => [
		"items" => $arItems,			
	]	
];

$arResult["TEMPLATE_DATA"] = $twigData;
