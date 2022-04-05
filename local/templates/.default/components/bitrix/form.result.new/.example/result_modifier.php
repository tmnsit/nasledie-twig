<?
use Uplab\Core\Data\FormResultModifier;


defined("B_PROLOG_INCLUDED") && B_PROLOG_INCLUDED === true || die();
/**
 * @global CMain $APPLICATION
 * @var array    $arParams
 * @var array    $arResult
 */


$uniqueId = $arParams["UNIQUE_ID"] ?: randString("8", "abcdefghijklnmopqrstuvwxyz");
$arResult["TEMPLATE_DATA"]["uniqueId"] = $uniqueId;


/**
 * Смотри описание класса
 * @see FormResultModifier
 */
FormResultModifier::prepareForm($arResult);


if ($_REQUEST["{$uniqueId}Privacy"] == "Y") {
	$arResult["TEMPLATE_DATA"]["privacyChecked"] = true;
}


$arResult["~FORM_HEADER"] .= "<input type=\"hidden\" name=\"uniqueId\" value=\"$uniqueId\">";


// d($arParams, __FILE__);
// d($arResult, __FILE__);