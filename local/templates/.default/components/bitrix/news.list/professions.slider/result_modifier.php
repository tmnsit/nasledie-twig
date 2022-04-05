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

$config = Config::getInstance();

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
		"href" => $arItem["DETAIL_PAGE_URL"],
		"image" => [
			"src" => $arItem["PREVIEW_PICTURE"]["SRC"],
			"alt" => $arItem["NAME"]
		],
		"heading" => $arItem["NAME"]
	];
	
	
	$arItems[] = $arTwigItem;
}


$entryId = $config->setEditLink($this, ["main_profession_title", "main_profession_btn"]);
$btn = $config->getLink("main_profession_btn");
$twigData = [
	"slider_cards_layout" => [
		"attr" => " id=\"" . $this->GetEditAreaId($entryId) . "\" ",
		//"heading" => $config->getTextValue("main_profession_title"),
		"card_name" => "^card-profession",
		"cards" => $arItems,
		/*"buttons" => [
			[
				"theme" => "border-dark",
				"hover" => "white",
				"href" => $btn["href"],
				"text" => $btn["text"]
			]
		]	*/	
	]
];

if($arParams["HIDE_LIST_BUTTON_MAIN"]!="Y") {
	$twigData["slider_cards_layout"]["buttons"][] = [
		"theme" => "border-dark",
		"hover" => "white",
		"href" => $btn["href"],
		"text" => $btn["text"]		
	];	
}

if($arParams["HIDE_LIST_TITLE_MAIN"]!="Y") {
	$twigData["slider_cards_layout"]["heading"] = $config->getTextValue("main_profession_title");
}
$arResult["TEMPLATE_DATA"] = $twigData;