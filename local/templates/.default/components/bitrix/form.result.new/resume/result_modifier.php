<?php

/**
 * @global CMain $APPLICATION
 * @var array    $arParams
 * @var array    $arResult
 */

use Bitrix\Main\Application;
use EuroCement\Local\Helper;
use Uplab\Core\Data\FormResultModifier;
use EuroCement\Local\Sync;


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
			"attrs"   => 'data-action="submitFormResume" enctype="multipart/form-data"',
			"action" => POST_FORM_ACTION_URI,
			"method" => "POST",
			"fields" => [],
			"fields_group" => [],
			"bottom" => [
				"fields" => [],
				"buttons" => []
			]
		]
	],
];

$hiddenNameFieldVacancy = '<input type="hidden" name="'.$arResult["QUESTIONS"]["VACANCY"]["NAME"].'" data-vacancy-name-form>';
$arResult["TEMPLATE_DATA"]["modal"]["form"]["header"].=$hiddenNameFieldVacancy;

$fields_group  = &$arResult["TEMPLATE_DATA"]["modal"]["form"]["fields_group"];
$fields        = &$arResult["TEMPLATE_DATA"]["modal"]["form"]["fields"];
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
	"input"       => true,
	"type"        => "text",
	"placeholder" => $arResult["QUESTIONS"]["NAME"]["~CAPTION"],
	"name"        => $arResult["QUESTIONS"]["NAME"]["NAME"],
	"required"    => $arResult["QUESTIONS"]["NAME"]["REQUIRED"] == "Y",
];	
		
$fields[] = [
	"input"       => true,
	"type"        => "text",
	"placeholder" => $arResult["QUESTIONS"]["LAST_NAME"]["~CAPTION"],
	"name"        => $arResult["QUESTIONS"]["LAST_NAME"]["NAME"],
	"required"    => $arResult["QUESTIONS"]["LAST_NAME"]["REQUIRED"] == "Y",
];		
$fields[] = [
	"input"       => true,
	"type"        => "email",
	"placeholder" => $arResult["QUESTIONS"]["EMAIL"]["~CAPTION"],
	"name"        => $arResult["QUESTIONS"]["EMAIL"]["NAME"],
	"required"    => $arResult["QUESTIONS"]["EMAIL"]["REQUIRED"] == "Y",
];

$arBUnits = [];

foreach($arResult["QUESTIONS"]["CITY"]["STRUCTURE"] as $arAnswer) {
	$arBUnits[] = [
		"text" => $arAnswer["MESSAGE"],
		"value" => $arAnswer["ID"],
		"attr" => " data-id='".$arAnswer["VALUE"]."'"
	];
}

$fields[] = [
	"select"      => true,
	"multiple"    => true,
	"placeholder" => $arResult["QUESTIONS"]["CITY"]["~CAPTION"],
	"name"        => $arResult["QUESTIONS"]["CITY"]["NAME"],
	"required"    => $arResult["QUESTIONS"]["CITY"]["REQUIRED"] == "Y",
	"options"     => $arBUnits
];
					
$fields_group[] = [
	"input"       => true,
	"tel"         => true,
	"placeholder" => "",
	"name"        => $arResult["QUESTIONS"]["PHONE"]["NAME"],
	"required"    => $arResult["QUESTIONS"]["PHONE"]["REQUIRED"] == "Y",
	
];					
$fields_group[] = [
	"file"        => true,
	"placeholder" => "",
	"text"        => $arResult["QUESTIONS"]["FILE_FIELD"]["~CAPTION"],
	"name"        => $arResult["QUESTIONS"]["FILE_FIELD"]["NAME"],
    "id"          => "id-file",
	"required"    => $arResult["QUESTIONS"]["FILE_FIELD"]["REQUIRED"] == "Y",
];
$fields_group[] = [
	"textarea"    => true,
	"placeholder" => $arResult["QUESTIONS"]["ABOUT"]["~CAPTION"],
	"name"        => $arResult["QUESTIONS"]["ABOUT"]["NAME"],
	"required"    => $arResult["QUESTIONS"]["ABOUT"]["REQUIRED"] == "Y",
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
	"id"      => "modal_succes_resume",
	"class"   =>"modal--message",
	"text"    => $arSuccessMessage[1]
];
