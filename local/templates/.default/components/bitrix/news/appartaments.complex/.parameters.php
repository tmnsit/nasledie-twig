<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$res = CIBlock::GetProperties(PROFITAPPARTAMENTS_IBLOCK, Array(), Array());
while($res_arr = $res->Fetch()) {
    $arFilterProps[$res_arr["ID"]] = $res_arr["NAME"];
}

$arTemplateParameters = array(
	"BANNER_CODE" => Array(
		"NAME" => "Символьный код баннер на внутренних страницах",
		"TYPE" => "STRING",
		"DEFAULT" =>"",
	),
	"SHOW_TOP" => Array(
		"NAME" => "Выводить топовые блоки (для историй)",
		"TYPE" => "CHECKBOX",
		"MULTIPLE" => "N",
		"VALUE" => "Y",
		"DEFAULT" =>"N",
		"REFRESH"=> "Y",
	),	
	"SHOW_PROFESSIONS" => Array(
		"NAME" => "Показывать профессии",
		"TYPE" => "CHECKBOX",
		"MULTIPLE" => "N",
		"VALUE" => "Y",
		"DEFAULT" =>"N",
		"REFRESH"=> "Y",
	),	
	"SHOW_HISTORIES" => Array(
		"NAME" => "Выводить истории",
		"TYPE" => "CHECKBOX",
		"MULTIPLE" => "N",
		"VALUE" => "Y",
		"DEFAULT" =>"N",
		"REFRESH"=> "Y",
	),
	"ANCOR_LINK_LIST" => Array(
		"NAME" => "Анкор ссылки перехода на список из детальной",
		"TYPE" => "STRING",
		"DEFAULT" =>"",
	),
	"FILTER_PROPS" => Array(
		"PARENT" => "ADDITIONAL_SETTINGS",
		"NAME" => "Свойства для фильтра",
		"TYPE" => "LIST",
		"MULTIPLE" => "Y",
		"VALUES" => $arFilterProps,
		"DEFAULT" => "",
		"ADDITIONAL_VALUES" => "Y",
	),
);
?>