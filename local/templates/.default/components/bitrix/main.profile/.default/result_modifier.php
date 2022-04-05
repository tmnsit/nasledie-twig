<?
use Bitrix\Main\Localization\Loc;


defined("B_PROLOG_INCLUDED") && B_PROLOG_INCLUDED === true || die();
/**
 * @global CMain $APPLICATION
 * @var array    $arParams
 * @var array    $arResult
 */


Loc::loadMessages(__DIR__ . "/template.php");


$prepareErrorMessages = function ($srcMessage, $isError, $formMessages) {
	if (!empty($srcMessage)) {
		$arMessages = [];
		$explodedMessages = preg_split("~(<br\s*/?>|[\r\n]+)~", $srcMessage);
		foreach ($explodedMessages as $message) {
			if (empty(trim($message))) continue;

			$arMessages [] = [
				"text" => $message,
				"type" => $isError ? "error" : "ok",
			];
		}

		$formMessages = array_merge(
			(array)$formMessages,
			$arMessages
		);
	}

	return $formMessages;
};
$formMessages = call_user_func(
	$prepareErrorMessages,
	$arResult["strProfileError"],
	$isError = true,
	$formMessages
);
if ($arResult['DATA_SAVED'] == 'Y') {
	$formMessages = call_user_func(
		$prepareErrorMessages,
		GetMessage('PROFILE_DATA_SAVED'),
		$isError = false,
		$formMessages
	);
}
$formMessages = array_filter($formMessages);


$form = [
	"action"        => $arResult["FORM_TARGET"],
	"attr"          => "enctype=\"multipart/form-data\"",
	"form_head"     => implode("\n", [
		$arResult["BX_SESSION_CHECK"],
		"<input type=\"hidden\" name=\"lang\" value=\"" . LANG . "\"/>",
		"<input type=\"hidden\" name=\"ID\" value={$arResult["ID"]}\"/>",
	]),
	"sections"      => [
		"reg"      => GetMessage("REG_SHOW_HIDE"),
		"personal" => GetMessage("USER_SHOW_HIDE"),
		"work"     => GetMessage("USER_WORK_INFO"),
		// "user_properties" => strlen(trim($arParams["USER_PROPERTY_NAME"])) > 0
		// 	? $arParams["USER_PROPERTY_NAME"]
		// 	: GetMessage("USER_TYPE_EDIT_TAB"),
	],
	"password_info" => $arResult["GROUP_POLICY"]["PASSWORD_REQUIREMENTS"],
	"submit"        => [
		"input" => true,
		"name"  => "save",
		"type"  => "submit",
		"value" => (($arResult["ID"] > 0) ? GetMessage("MAIN_SAVE") : GetMessage("MAIN_ADD")),
	],

	"fields" => [
		[
			"input"   => true,
			"name"    => "NAME",
			"label"   => GetMessage("NAME"),
			"value"   => $arResult["arUser"]["NAME"],
			"section" => "reg",
		],
		[
			"input"   => true,
			"name"    => "LAST_NAME",
			"label"   => GetMessage("LAST_NAME"),
			"value"   => $arResult["arUser"]["LAST_NAME"],
			"section" => "reg",
		],
		[
			"input"   => true,
			"name"    => "SECOND_NAME",
			"label"   => GetMessage("SECOND_NAME"),
			"value"   => $arResult["arUser"]["SECOND_NAME"],
			"section" => "reg",
		],
		[
			"input"   => true,
			"name"    => "SECOND_NAME",
			"label"   => GetMessage("SECOND_NAME"),
			"value"   => $arResult["arUser"]["SECOND_NAME"],
			"section" => "reg",
		],
		[
			"input"   => true,
			"name"    => "LOGIN",
			"label"   => GetMessage("LOGIN") . "*",
			"value"   => $arResult["arUser"]["LOGIN"],
			"section" => "reg",
		],
		[
			"input"   => true,
			"name"    => "EMAIL",
			"label"   => GetMessage("EMAIL") . ($arResult["EMAIL_REQUIRED"] ? "*" : ""),
			"value"   => $arResult["arUser"]["LOGIN"],
			"section" => "reg",
		],
		[
			"input"   => true,
			"name"    => "PHONE",
			"label"   => GetMessage("main_profile_phone_number") . ($arResult["PHONE_REQUIRED"] ? "*" : ""),
			"value"   => $arResult["arUser"]["PHONE_NUMBER"],
			"section" => "reg",
		],
		$arResult['CAN_EDIT_PASSWORD'] ? [
			"input"     => true,
			"label"     => GetMessage('NEW_PASSWORD_REQ'),
			"name"      => "NEW_PASSWORD",
			"value"     => "",
			"maxlength" => 50,
		] : null,
		$arResult['CAN_EDIT_PASSWORD'] ? [
			"input"     => true,
			"label"     => GetMessage('NEW_PASSWORD_CONFIRM'),
			"name"      => "NEW_PASSWORD_CONFIRM",
			"value"     => "",
			"maxlength" => 50,
		] : null,


		[
			"input" => true,
			"label" => GetMessage('USER_PROFESSION'),
			"name"  => "PERSONAL_PROFESSION",
			"value" => $arResult["arUser"]["PERSONAL_PROFESSION"],
		],
		// [
		// 	"label" => GetMessage('USER_COUNTRY'),
		// 	"type"  => "select",
		// 	"html"  => $arResult["COUNTRY_SELECT"],
		// ],
		[
			"input" => true,
			"label" => GetMessage('USER_STATE'),
			"name"  => "PERSONAL_STATE",
			"value" => $arResult["arUser"]["PERSONAL_STATE"],
		],
		[
			"input" => true,
			"label" => GetMessage('USER_CITY'),
			"name"  => "PERSONAL_CITY",
			"value" => $arResult["arUser"]["PERSONAL_CITY"],
		],
		[
			"input" => true,
			"label" => GetMessage('USER_COMPANY'),
			"name"  => "WORK_COMPANY",
			"value" => $arResult["arUser"]["WORK_COMPANY"],
		],
		[
			"input" => true,
			"label" => GetMessage('USER_WWW'),
			"name"  => "WORK_WWW",
			"value" => $arResult["arUser"]["WORK_WWW"],
		],
		[
			"input" => true,
			"label" => GetMessage('USER_DEPARTMENT'),
			"name"  => "WORK_DEPARTMENT",
			"value" => $arResult["arUser"]["WORK_DEPARTMENT"],
		],
		[
			"input" => true,
			"label" => GetMessage('USER_POSITION'),
			"name"  => "WORK_POSITION",
			"value" => $arResult["arUser"]["WORK_POSITION"],
		],
		[
			"input" => true,
			"label" => GetMessage("USER_WORK_PROFILE"),
			"name"  => "WORK_PROFILE",
			"value" => $arResult["arUser"]["WORK_PROFILE"],
		],
	],
];


$arResult["TEMPLATE_DATA"]["form"] = $form;