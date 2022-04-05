<?
use Uplab\Core\Components\TemplateBlock;


defined("B_PROLOG_INCLUDED") && B_PROLOG_INCLUDED === true || die();
/**
 * @global CMain $APPLICATION
 * @var array    $arParams
 * @var array    $arCurrentValues
 * @var array    $arResult
 */


CBitrixComponent::includeComponentClass("uplab.core:template.block");


$arParams = [
	"IMG_SRC" => [
		"NAME"              => 'Путь к файлу',
		"TYPE"              => "FILE",
		"COLS"              => 30,
		"FD_TARGET"         => "F",
		"FD_EXT"            => 'jpg,jpeg,gif,png,svg',
		"FD_UPLOAD"         => true,
		"FD_USE_MEDIALIB"   => true,
		"FD_MEDIALIB_TYPES" => ['image'],
		'REFRESH'           => 'Y',
	],
	"IMG_ALT" => ["NAME" => "ALT изображения"],

	"HEADING" => ["NAME" => "Заголовок"],
	"PHONE"   => ["NAME" => "Номер телефона"],
	"TEXT"    => [
		"NAME"   => "Текст",
		"TYPE"   => "VISUAL_EDITOR",
		'PARENT' => 'DATA_SOURCE',
	],
];


// Множественная группа свойств.
// При заполнении одного из элементов, появляется следующий
TemplateBlock::addDynamicParameters($arParams, $arCurrentValues, [
	"CODE" => "SLIDE",
	"NAME" => "Слайд",
], [
	"HEADING" => ["NAME" => "Заголовок"],
	"IMG_SRC"   => [
		"NAME"              => "Изображение",
		"TYPE"              => "FILE",
		"COLS"              => 30,
		"FD_TARGET"         => "F",
		"FD_EXT"            => "jpg,jpeg,gif,png,svg",
		"FD_UPLOAD"         => true,
		"FD_USE_MEDIALIB"   => true,
		"FD_MEDIALIB_TYPES" => ["image"],
	],
	"IMG_ALT" => ["NAME" => "ALT изображения"],
	"NUMBER"  => ["NAME" => "Число (значение)"],
	"TYPE"    => [
		"NAME"   => "Тип отображения",
		"TYPE"   => "LIST",
		"VALUES" => ["Значение 1", "Значение 2"],
	],
]);


// TODO: Указать вместо __MODULE_NAMESPACE__ корректный путь к неймспейсу проекта
__MODULE_NAMESPACE__\Helper::addUtilityClassesToParams($arParams);
__MODULE_NAMESPACE__\Helper::addActionsToParams($arParams, $arCurrentValues);


$arTemplateParameters = TemplateBlock::initParameters($arParams);
