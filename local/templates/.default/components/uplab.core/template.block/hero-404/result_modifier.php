<?
use Bitrix\Main\Application;
use EuroCement\Local\Helper;
use Uplab\Core\Components\TemplateBlock;
use EuroCement\Local\Config;


defined("B_PROLOG_INCLUDED") && B_PROLOG_INCLUDED === true || die();	

$insConfig = Config::getInstance();
$btn = $insConfig->getLink("404_btn");
$image = $insConfig->getFileWithAlt("404_img");
$twigData = [
	"title" => $insConfig->getTextValue("404_title"),
	"intro" => [
		"heading" => $insConfig->getTextValue("404_title"),
		"text" => $insConfig->getTextValue("404_text"),
		"color" => "ice",
		"image" => $image,
		"actions" => [
			[
				"type" => "button",
				"href" => $btn["href"],
				"text" => $btn["text"],
				"title" => $btn["text"],
				"theme" => "border-dark",
				"attr" => " data-some-additional-attributes='' "
			]
		]
	]
];

	$logo_white = $insConfig->getFileWithAlt("logo_white");
	$logo_color = $insConfig->getFileWithAlt("logo_color");
	$btn_contacts = $insConfig->getLink("link_contacts");
	
	
	$content = [
		"logo" => [
			"src" => $logo_color["src"],
			"alter_src" => $logo_white["src"],
			"href" => "/",
			"alt" => $logo_color["alt"]		
		],
		"link_list" => [
			[
				"main" => true,
				"href" => "mailto:".$insConfig->getTextValue("email"),
				"text" => $insConfig->getTextValue("email")
			],
			$btn_contacts,
			[
				"href" => "#",
				"text" => "!"
			]		
		],	
	];
	
	$twigData["menu"]["content"] = $content;
	
$arResult["TEMPLATE_DATA"] = $twigData;