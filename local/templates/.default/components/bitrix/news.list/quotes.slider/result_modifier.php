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
		"text" => $arItem["PREVIEW_TEXT"],
		//"text" => mb_substr(strip_tags($arItem["DETAIL_TEXT"]),0,120).'...',
		"more_text" => [
			"text" => $arItem["DETAIL_TEXT"],
			//"text" => mb_substr(strip_tags($arItem["DETAIL_TEXT"]),0,120).'...',
			"link" => [
				"before" => "Подробнее",
				"after" => "Скрыть"				
			]
		],
		"icon" => [
			"name" => "64/quote",
			"size" => "large"
		],		
		"link" => [
			"href" => "javascript:void(0);",
			"text" => "Подробнее"
		],		
		"bottom" => [
			"text" => $arItem["NAME"],
			"desc" => $arItem["PROPERTIES"]["POSITION"]["VALUE"],
			"role" => $arItem["PROPERTIES"]["ORG"]["VALUE"],
		]
	];
	
	if ($arItem["PREVIEW_PICTURE"]["SRC"]) {
		$arTwigItem["image"] = [
			"src" => $arItem["PREVIEW_PICTURE"]["SRC"],
			"alt" => $arItem["NAME"],
			"disable_lazy" => true			
		];
	}
				
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