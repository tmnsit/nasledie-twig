<?php
if ($arResult["VARIABLES"]["ELEMENT_CODE"]) {
    $arSelect = Array("*", "PROPERTY_*");
    $arFilter = Array("IBLOCK_ID" => PROJECTS_IBLOCK, "CODE" => $arResult["VARIABLES"]["ELEMENT_CODE"], "ACTIVE" => "Y");
    $res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
    while($ob = $res->GetNextElement())
    {
        $arFields = $ob->GetFields();
        $arFields["PROPERTIES"] = $ob->GetProperties();
        $arResult["PROJECT"] = $arFields;
    }
    // mpr($arResult, false);
}