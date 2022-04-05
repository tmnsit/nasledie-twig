<?
use Bitrix\Main\Application;
use EuroCement\Local\Helper;
use Uplab\Core\Components\TemplateBlock;
use Eurocement\Local\Config;

defined("B_PROLOG_INCLUDED") && B_PROLOG_INCLUDED === true || die();
/**
 * @global CMain      $APPLICATION
 * @var array         $arParams
 * @var array         $arResult
 * @var TemplateBlock $component
 */



$config = Config::getInstance();

$arSlider = [];

$rnd = $this->randString();

$elementEdit = CIBlock::GetArrayByID($arParams['IBLOCK_ID'], 'ELEMENT_EDIT');
$elementDelete = CIBlock::GetArrayByID($arParams['IBLOCK_ID'], 'ELEMENT_DELETE');

foreach($arResult["ITEMS"] as $arItem) {
	
	$fullCount = $arItem["PROPERTIES"]["COUNT"]["VALUE"];

	$entryId = $arItem['ID'] . $rnd;
	$this->AddEditAction($entryId, $arItem['EDIT_LINK'], $elementEdit);
	$this->AddDeleteAction($entryId, $arItem['DELETE_LINK'], $elementDelete);
		
	$arSliderItem = [
		"attr" => " id=\"" . $this->GetEditAreaId($entryId) . "\" ",
		"href" => "/vacancy/?UF_SPHERES[".$arItem["ID"]."]=".$arItem["PROPERTIES"]["NAME_SITE"]["VALUE"],
		"heading" => $arItem["PROPERTIES"]["NAME_SITE"]["VALUE"],
		"icon" => [
			"name" => CFile::GetPath($arItem["PROPERTIES"]["IMG"]["VALUE"])
		],
		"notes" => [
			[
				"text" => $fullCount." ".Helper::getNumWord($fullCount, ['вакансия', 'вакансии', 'вакансий'])
			]
		]		
	];
	
	$arSlider[] = $arSliderItem;
}


$code = "title_main_direction";

$entryId = $config->setEditLink($this, [$code]);

$twigData = [
	"slider_directions" => [
		"attr" => " id=\"" . $this->GetEditAreaId($entryId) . "\" ",
		"heading" => $config->getTextValue($code),
		"items" => $arSlider				
	]	
];

$arResult["TEMPLATE_DATA"] = $twigData;
