<?
use Bitrix\Main\Application;
use EuroCement\Local\Helper;
use Uplab\Core\Components\TemplateBlock;
//use EuroCement\Local\Config;

defined("B_PROLOG_INCLUDED") && B_PROLOG_INCLUDED === true || die();
/**
 * @global CMain      $APPLICATION
 * @var array         $arParams
 * @var array         $arResult
 * @var TemplateBlock $component
 */

//$config = Config::getInstance();

$arSlider = [];

$rnd = $this->randString();

$elementEdit = CIBlock::GetArrayByID($arParams['IBLOCK_ID'], 'ELEMENT_EDIT');
$elementDelete = CIBlock::GetArrayByID($arParams['IBLOCK_ID'], 'ELEMENT_DELETE');
	
foreach($arResult["ITEMS"] as $arItem) {

	$entryId = $arItem['ID'] . $rnd;
	$this->AddEditAction($entryId, $arItem['EDIT_LINK'], $elementEdit);
	$this->AddDeleteAction($entryId, $arItem['DELETE_LINK'], $elementDelete);
		
	$arTwigItem = [
		"attr" => " id=\"" . $this->GetEditAreaId($entryId) . "\" ",
		"text" => $arItem["PROPERTIES"]["ANOUNCE"]["VALUE"],
		//"text" => mb_substr(strip_tags($arItem["DETAIL_TEXT"]),0,120).'...',
		//"more_text" => [
			//"text" => $arItem["PROPERTIES"]["ANOUNCE"]["VALUE"],
			//"text" => mb_substr(strip_tags($arItem["DETAIL_TEXT"]),0,120).'...',
			/*"link" => [
				"before" => "Подробнее",
				"after" => "Скрыть"				
			]*/
		//],
		"icon" => [
			"name" => "64/quote",
			"size" => "large"
		],		
		"href" => $arItem["DETAIL_PAGE_URL"],
		"image" => [
			"src" => ($arItem["PROPERTIES"]["SQUARE_PHOTO"]["VALUE"]?CFile::GetPath($arItem["PROPERTIES"]["SQUARE_PHOTO"]["VALUE"]):$arItem["PREVIEW_PICTURE"]["SRC"]),
			"alt" => $arItem["NAME"],
			"disable_lazy" => true
		],
		"link" => [
			"href" => $arItem["DETAIL_PAGE_URL"],
			"text" => "Подробнее"
		],
		"bottom" => [
			"text" => $arItem["PROPERTIES"]["NAME"]["VALUE"],
			"desc" => $arItem["PROPERTIES"]["POSITION"]["VALUE"],
			"role" => $arItem["PROPERTIES"]["NAME_ORG"]["VALUE"],
		]
	];
	
				
	$arItems[] = $arTwigItem;
}


//$entryId = $config->setEditLink($this, ["main_profession_title", "main_profession_btn"]);
//$btn = $config->getLink("main_profession_btn");
$twigData = [
	"history_slider" => [
		"heading" => $arParams["HEADING_TITLE"],
		//"attr" => " id=\"" . $this->GetEditAreaId($entryId) . "\" ",
		"items" => $arItems,	
	]
];

$arResult["TEMPLATE_DATA"] = $twigData;