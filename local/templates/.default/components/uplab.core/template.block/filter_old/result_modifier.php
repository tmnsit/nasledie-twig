<?
use Bitrix\Main\Application;
use EuroCement\Local\Helper;
use Uplab\Core\Components\TemplateBlock;
use EuroCement\Local\Vacancy;
use EuroCement\Local\Sync;
use EuroCement\Local\Config;


defined("B_PROLOG_INCLUDED") && B_PROLOG_INCLUDED === true || die();
/**
 * @global CMain      $APPLICATION
 * @var array         $arParams
 * @var array         $arResult
 * @var TemplateBlock $component
 */


$busineses = Sync::getHandbook(BUNITS_IBLOCK, $custom_name = true);
$cities = Sync::getHandbook(CITIES_IBLOCK);
$directions = Sync::getHandbook(DIRECTIONS_IBLOCK, $custom_name = true);
$employments = Sync::getHandbook(EMPLOYMENTS_IBLOCK);
$expirienses = Sync::getHandbook(EXPIRIENSES_IBLOCK);
$schedules = Sync::getHandbook(SCHEDULES_IBLOCK);

$config = Config::getInstance();
$arTagsList = [];
$arDBWords = $config->getTextListValue("search_keywords");

foreach($arDBWords as $word) {
	$arTagsList[] = [
		"tag" => true,
		"text" => $word["text"],
		"title" => "Подсказка при наведении на ссылку",
		"href" => "/vacancy/?query=".$word["text"],
		"external" => false,
		"disabled" => false,
		"attr" => " data-tag='' "			
	];
}

$twigData = [
	"filter" => [
		"heading" => "Вакансии",
		"attr" => 'action="/vacancy/" method="GET" data-filter-main',
		"search" => [
			"action" => "/vacancy/",
			"field" => [
				"input" => true,
				"type" => "text",
				"placeholder" => "Поиск по вакансиям",
				"name" => "query",
				"attr" => "data-search-box='/ajax/search.php'",
				"autocomplete" => "off",				
			],
			"region" => [
				"select" => true,
				"search" => true,
				"icon" => "location",
				"placeholder" => "Регион",				
				"multiple" => false,
				"name" => "UF_CITY",
				"options" => Helper::prepareItemsFilter($cities)
			],
			"ext_fields" => [
				"action" => [
					"icon" => [
						"name" => "24/close"
					],
					"text" => "Сбросить",
					"title" => "Подсказка при наведении на ссылку",
					"external" => false,
					"disabled" => false,
					"attr" => " data-clear='' "
				],
				"items" => [
					[
						"select" => true,
						"placeholder" => "Направления",	
						"multiple" => true,
						"name" => "UF_SPHERES",
						"options" => Helper::prepareItemsFilter($directions)
					],
					[
						"select" => true,
						"placeholder" => "Предприятия",
						"multiple" => true,
						"name" => "UF_BUNIT",
						"options" => Helper::prepareItemsFilter($busineses)
					]
				]
			],
			"button" => [
				"type" => "submit",
				"icon" => [
					"name" => "24/search"
				],
				"text" => "Найти",
				"theme" => "primary",
				"hover" => "primary"
			],
			"ext_link" => [
				"icon" => [
					"name" => "24/filter"
				],
				"modificator" => "gray",
				"href" => "#filter-popup",
				"text" => "Расширенный фильтр",
				"title" => "Подсказка при наведении на ссылку",
				"external" => false,
				"disabled" => false,
				"attr" => " data-expand-filter='Скрыть фильтр' "
			],
			"filter_popup" => [
				"title" => "Расширенный фильтр"
			],
			"tags" => [
				"items" => $arTagsList
			]
		]
	]
];

$arResult["TEMPLATE_DATA"] = $twigData;