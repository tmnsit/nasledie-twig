<?
define("NO_KEEP_STATISTIC", true);
define("NO_AGENT_CHECK", true);
define('PUBLIC_AJAX_MODE', true);
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
$_SESSION["SESS_SHOW_INCLUDE_TIME_EXEC"]="N";
$APPLICATION->ShowIncludeStat = false;


if (CModule::IncludeModule("iblock"))
{


    $arSelect = Array("ID", "NAME", 'IBLOCK_ID');
    $arFilter = Array("IBLOCK_ID" => CONTACTS_IBLOCK, "ACTIVE_DATE" => "Y", "ACTIVE" => "Y");
    $res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
    $elements = [];
    while ($ob = $res->GetNextElement()) {
        $arFields = $ob->GetFields();
        $db_props = CIBlockElement::GetProperty($arFields['IBLOCK_ID'], $arFields['ID']);
        $PROPS = [];
        while ($ar_props = $db_props->Fetch()) {
            $PROPS[$ar_props['CODE']] = $ar_props;
        }
        $arFields['PROPS'] = $PROPS;
        $elements[] = $arFields;
    }
}

$coordinates = [];
foreach ($elements as $keyContact => $itemContact){
    if($itemContact['PROPS']['COORDINATES']['VALUE']){
        if($itemContact['PROPS']['ICON_MAP']['VALUE']){
            $icon_map_src = CFile::GetPath($itemContact['PROPS']['ICON_MAP']['VALUE']);
            $itemContact['PROPS']['ICON_MAP']['SRC'] = $icon_map_src;
        }
        $coordinates[] = $itemContact;
    }
}


if(count($coordinates)){
    echo json_encode($coordinates);
}else{
    echo json_encode(['error' => 'Нет элемнтов'], 204);
}


require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");
