<?php
$arSelect = Array("ID", "NAME");
$arFilter = Array("IBLOCK_ID" => OBJECTTYPE_IBLOCK, "ACTIVE" => "Y");
$res = CIBlockElement::GetList(Array("SORT"=>"ASC"), $arFilter, false, false, $arSelect);
while($ob = $res->GetNextElement())
{
    $arFields = $ob->GetFields();
    $arHandlers["HANDLERS"][$arFields["ID"]] = $arFields["NAME"];
}

$arTemplateParameters = [
    "BLOCK_TITLE" => [
        "NAME" => "Заголовок блока",
		"TYPE" => "STRING",
		"DEFAULT" =>"",
    ],
    "BTN_TEXT_DETAIL" => [
        "NAME" => "Текст кнопки детального просмотра",
		"TYPE" => "STRING",
		"DEFAULT" =>"",
    ],
    "BTN_CLASS" => [
        "NAME" => "Css класс кнопки",
		"TYPE" => "STRING",
		"DEFAULT" =>"",
    ],
    "TAB_TYPES" => [
        "NAME" => "Выберите табы",
        "TYPE" => "LIST",
        "MULTIPLE" => "Y",
        "VALUES" => $arHandlers["HANDLERS"],
        "DEFAULT" => [],
    ],
];