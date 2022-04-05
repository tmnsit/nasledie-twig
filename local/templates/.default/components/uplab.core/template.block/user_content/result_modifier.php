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
$rnd = $this->randString();

$elementEdit = CIBlock::GetArrayByID($arParams['IBLOCK_ID'], 'ELEMENT_EDIT');
$elementDelete = CIBlock::GetArrayByID($arParams['IBLOCK_ID'], 'ELEMENT_DELETE');


$entryId = $insConfig->setEditLink($this, [$arParams["ELEMENT_CODE"]]);

$twigData = [
	"user_content_story" => [
		"attr" =>  " id=\"" . $this->GetEditAreaId($entryId) . "\" ",
		"content" => $insConfig->getTextValue($arParams["ELEMENT_CODE"])
	]
];

$arResult["TEMPLATE_DATA"] = $twigData;
