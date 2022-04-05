<?php

/**
 * @global CMain $APPLICATION
 * @var array    $arParams
 * @var array    $arResult
 */

use Bitrix\Main\Application;
use EuroCement\Local\Helper;
use Uplab\Core\Data\FormResultModifier;


defined("B_PROLOG_INCLUDED") && B_PROLOG_INCLUDED === true || die();


FormResultModifier::prepareForm($arResult);

$arSuccessMessage = explode("\n", strip_tags($arResult["FORM_DESCRIPTION"]));

$arResult["TEMPLATE_DATA"] = [
	"modal" => [
		"id" => $arResult["arForm"]["VARNAME"],
		"heading" => $arResult["arForm"]["NAME"],
		"form"          => [
			"name" => "modal-form-1",
			"header" => $arResult["~FORM_HEADER"],
			"attrs"   => 'data-action="submitForm"',
			"action" => POST_FORM_ACTION_URI,
			"method" => "POST",
			"fields_group" => [],
			"bottom" => [
				"fields" => [],
				"buttons" => []
			]
		]
	],
];

$fields        = &$arResult["TEMPLATE_DATA"]["modal"]["form"]["fields_group"];
$bottom_fields = &$arResult["TEMPLATE_DATA"]["modal"]["form"]["bottom"]["fields"];
$buttons       = &$arResult["TEMPLATE_DATA"]["modal"]["form"]["bottom"]["buttons"];


$request = Application::getInstance()->getContext()->getRequest();

$options = [];

foreach($arResult["QUESTIONS"]["THEME"]["STRUCTURE"] as $opt) {
	$options[] = [
		"value" => $opt["VALUE"],
		"text"  => $opt["MESSAGE"]
	];
}


$fields[] = [
	"select"      => true,
	"placeholder" => $arResult["QUESTIONS"]["THEME"]["~CAPTION"],
	"name"        => $arResult["QUESTIONS"]["THEME"]["NAME"],
	"required"    => $arResult["QUESTIONS"]["THEME"]["REQUIRED"] == "Y",
	"options"     => $options
];
			
$fields[] = [
	"input"       => true,
	"type"        => "text",
	"placeholder" => $arResult["QUESTIONS"]["NAME"]["~CAPTION"],
	"name"        => $arResult["QUESTIONS"]["NAME"]["NAME"],
	"required"    => $arResult["QUESTIONS"]["NAME"]["REQUIRED"] == "Y",
];		
$fields[] = [
	"input"       => true,
	"type"        => "email",
	"placeholder" => $arResult["QUESTIONS"]["EMAIL"]["~CAPTION"],
	"name"        => $arResult["QUESTIONS"]["EMAIL"]["NAME"],
	"required"    => $arResult["QUESTIONS"]["EMAIL"]["REQUIRED"] == "Y",
];
$fields[] = [
	"textarea"    => true,
	"placeholder" => $arResult["QUESTIONS"]["COMMENT"]["~CAPTION"],
	"name"        => $arResult["QUESTIONS"]["COMMENT"]["NAME"],
	"required"    => $arResult["QUESTIONS"]["COMMENT"]["REQUIRED"] == "Y",
];


$bottom_fields[] = [
	"checkbox" => true,
	"name"     => $arResult["QUESTIONS"]["POLICY"]["NAME"],
	"text"     => $arResult["QUESTIONS"]["POLICY"]["CAPTION"],
	"required" => $arResult["QUESTIONS"]["POLICY"]["REQUIRED"] == "Y",
	"checked"  => false,
	"value"    => $arResult["QUESTIONS"]["POLICY"]["VALUE"],	
];

$buttons[] = [
	"type"   => "submit",
	"text"   => $arResult["arForm"]["BUTTON"],
];

$arResult["TEMPLATE_DATA"]["modal_success"] = [
	"heading" => $arSuccessMessage[0],
	"id"      => "modal_succes_question",
	"class"   =>"modal--message",
	"text"    => $arSuccessMessage[1]
];
