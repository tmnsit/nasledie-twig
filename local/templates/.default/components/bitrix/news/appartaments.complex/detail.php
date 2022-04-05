<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
?>


<?
$params = [
    "DISPLAY_DATE" => $arParams["DISPLAY_DATE"],
    "DISPLAY_NAME" => $arParams["DISPLAY_NAME"],
    "DISPLAY_PICTURE" => $arParams["DISPLAY_PICTURE"],
    "DISPLAY_PREVIEW_TEXT" => $arParams["DISPLAY_PREVIEW_TEXT"],
    "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
    "IBLOCK_ID" => $arParams["IBLOCK_ID"],
    "FIELD_CODE" => $arParams["DETAIL_FIELD_CODE"],
    "PROPERTY_CODE" => $arParams["DETAIL_PROPERTY_CODE"],
    "DETAIL_URL" => $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["detail"],
    "SECTION_URL" => $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["section"],
    "META_KEYWORDS" => $arParams["META_KEYWORDS"],
    "META_DESCRIPTION" => $arParams["META_DESCRIPTION"],
    "BROWSER_TITLE" => $arParams["BROWSER_TITLE"],
    "SET_CANONICAL_URL" => $arParams["DETAIL_SET_CANONICAL_URL"],
    "DISPLAY_PANEL" => $arParams["DISPLAY_PANEL"],
    "SET_LAST_MODIFIED" => $arParams["SET_LAST_MODIFIED"],
    "SET_TITLE" => $arParams["SET_TITLE"],
    "MESSAGE_404" => $arParams["MESSAGE_404"],
    "SET_STATUS_404" => $arParams["SET_STATUS_404"],
    "SHOW_404" => $arParams["SHOW_404"],
    "FILE_404" => $arParams["FILE_404"],
    "INCLUDE_IBLOCK_INTO_CHAIN" => $arParams["INCLUDE_IBLOCK_INTO_CHAIN"],
    "ADD_SECTIONS_CHAIN" => $arParams["ADD_SECTIONS_CHAIN"],
    "ACTIVE_DATE_FORMAT" => $arParams["DETAIL_ACTIVE_DATE_FORMAT"],
    "CACHE_TYPE" => $arParams["CACHE_TYPE"],
    "CACHE_TIME" => $arParams["CACHE_TIME"],
    "CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
    "USE_PERMISSIONS" => $arParams["USE_PERMISSIONS"],
    "GROUP_PERMISSIONS" => $arParams["GROUP_PERMISSIONS"],
    "DISPLAY_TOP_PAGER" => $arParams["DETAIL_DISPLAY_TOP_PAGER"],
    "DISPLAY_BOTTOM_PAGER" => $arParams["DETAIL_DISPLAY_BOTTOM_PAGER"],
    "PAGER_TITLE" => $arParams["DETAIL_PAGER_TITLE"],
    "PAGER_SHOW_ALWAYS" => "N",
    "PAGER_TEMPLATE" => $arParams["DETAIL_PAGER_TEMPLATE"],
    "PAGER_SHOW_ALL" => $arParams["DETAIL_PAGER_SHOW_ALL"],
    "CHECK_DATES" => $arParams["CHECK_DATES"],
    "ELEMENT_ID" => $arResult["VARIABLES"]["ELEMENT_ID"],
    "ELEMENT_CODE" => $arResult["VARIABLES"]["ELEMENT_CODE"],
    "SECTION_ID" => $arResult["VARIABLES"]["SECTION_ID"],
    "SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
    "IBLOCK_URL" => $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["news"],
    "USE_SHARE" => $arParams["USE_SHARE"],
    "SHARE_HIDE" => $arParams["SHARE_HIDE"],
    "SHARE_TEMPLATE" => $arParams["SHARE_TEMPLATE"],
    "SHARE_HANDLERS" => $arParams["SHARE_HANDLERS"],
    "SHARE_SHORTEN_URL_LOGIN" => $arParams["SHARE_SHORTEN_URL_LOGIN"],
    "SHARE_SHORTEN_URL_KEY" => $arParams["SHARE_SHORTEN_URL_KEY"],
    "ADD_ELEMENT_CHAIN" => (isset($arParams["ADD_ELEMENT_CHAIN"]) ? $arParams["ADD_ELEMENT_CHAIN"] : ''),
    'STRICT_SECTION_CHECK' => (isset($arParams['STRICT_SECTION_CHECK']) ? $arParams['STRICT_SECTION_CHECK'] : ''),
    "ANCOR_LINK_LIST" => ($arParams["ANCOR_LINK_LIST"] ? $arParams["ANCOR_LINK_LIST"] : 'Вернуться к списку'),
    "ICON_DETAIL" => $arParams["ICON_DETAIL"],
    "HIDE_SHARE" => $arParams["HIDE_SHARE"],
    "BACK_LINK" => $arResult['FOLDER'],
];

if ($arResult["VARIABLES"]['ELEMENT_ID']) {
    $params["EXTRA_NAV_ITEM_ID"] = $arResult["VARIABLES"]['ELEMENT_ID'];
}
if ($arResult["VARIABLES"]['ELEMENT_CODE']) {
    $params["EXTRA_NAV_ITEM_CODE"] = $arResult["VARIABLES"]['ELEMENT_CODE'];
}

?>

<div class="container">
    <? $ElementID = $APPLICATION->IncludeComponent(
        "bitrix:news.detail",
        "",
        $params,
        $component
    ); ?>
</div>


<?
$res_el = CIBlockElement::GetList([], ["IBLOCK_ID" => $arParams['IBLOCK_ID'], "ID" => $ElementID], false,false,["ID", "NAME", "IBLOCK_ID"])->GetNextElement();
$element = $res_el->GetFields();
$element['PROPS'] = $res_el->GetProperties();
$res_project = CIBlockElement::GetList(["SORT" => "ASC"], ['IBLOCK_ID' => PROJECTS_IBLOCK, "PROPERTY_profit_id" => $element['PROPS']['profit_project_id']['VALUE'] ], false, false)->GetNextElement();
$project = $res_project->GetFields();
$project['PROPERTIES'] = $res_project->GetProperties();



global $arrFilterMore; 
$arrFilterMore = [
    // Кол-во комнат
        ['=PROPERTY_profit_rooms' => $element['PROPS']['profit_rooms']['VALUE']],
    // Кол-во комнат
    // Площадь
        ['>PROPERTY_profit_property_area' => $element['PROPS']['profit_area_living']['VALUE'] - 5],
        ['<PROPERTY_profit_property_area' => $element['PROPS']['profit_area_living']['VALUE'] + 5],
    // Площадь
    // Стоимость +- 500000
        ['>PROPERTY_profit_property_price' => $element['PROPS']['profit_property_price']['VALUE'] - 500000],
        ['<PROPERTY_profit_property_price' => $element['PROPS']['profit_property_price']['VALUE'] + 500000],
    // Стоимость
        ['=PROPERTY_profit_house_id' => $element['PROPS']['profit_house_id']['VALUE']],
];


?>


<div class="container">
    <div class="layout">
        <div class="layout__sidebar">
            <div class="layout__sidebar-wrapper">
                <?$APPLICATION->IncludeComponent("uplab.core:template.block", "sidebar", Array(
                    "CACHE_FOR_PAGE" => "N",	// Добавить адрес страницы в кеш
                    "CACHE_TIME" => "3600000",	// Время кеширования (сек.)
                    "CACHE_TYPE" => "A",	// Тип кеширования
                    "DELAY" => "N",	// Отложенное выполнение компонента,
                ),
                    false
                );?>
            </div>
        </div>
        <div class="layout__content">
            <?$APPLICATION->IncludeComponent(
                "uplab.core:template.block",
                "flat-advantages",
                Array(
                    "PROJECT" => $project,
                    "CACHE_FOR_PAGE" => "N",
                    "CACHE_TIME" => "3600000",
                    "CACHE_TYPE" => "A",
                    "DELAY" => "N",
                )
            );?>

            <?/*
            <?$APPLICATION->IncludeComponent("uplab.core:template.block", "flat-finishing", Array(
                "CACHE_FOR_PAGE" => "N",	// Добавить адрес страницы в кеш
                "CACHE_TIME" => "3600000",	// Время кеширования (сек.)
                "CACHE_TYPE" => "A",	// Тип кеширования
                "DELAY" => "N",	// Отложенное выполнение компонента,
                "FISHING_ID" => $project['PROPERTIES']['FISHING']['VALUE']
            ),
                false
            );?>
            */?>

            <?$APPLICATION->IncludeComponent("uplab.core:template.block", "flat-map", Array(
                "CACHE_FOR_PAGE" => "N",	// Добавить адрес страницы в кеш
                "CACHE_TIME" => "3600000",	// Время кеширования (сек.)
                "CACHE_TYPE" => "A",	// Тип кеширования
                "DELAY" => "N",	// Отложенное выполнение компонента,
            ),
                false
            );?>

            <?$APPLICATION->IncludeComponent("uplab.core:template.block", "payment-description", Array(
                "CACHE_FOR_PAGE" => "N",	// Добавить адрес страницы в кеш
                "CACHE_TIME" => "3600000",	// Время кеширования (сек.)
                "CACHE_TYPE" => "A",	// Тип кеширования
                "DELAY" => "N",	// Отложенное выполнение компонента,
            ),
                false
            );?>

            <?$APPLICATION->IncludeComponent("bitrix:news.list","more-rooms",Array(
                    "DISPLAY_DATE" => "Y",
                    "DISPLAY_NAME" => "Y",
                    "DISPLAY_PICTURE" => "Y",
                    "DISPLAY_PREVIEW_TEXT" => "Y",
                    "AJAX_MODE" => "N",
                    "IBLOCK_TYPE" => "property",
                    "IBLOCK_ID" => PROFITAPPARTAMENTS_IBLOCK,
                    "NEWS_COUNT" => "3",
                    "SORT_BY1" => "ACTIVE_FROM",
                    "SORT_ORDER1" => "DESC",
                    "SORT_BY2" => "SORT",
                    "SORT_ORDER2" => "ASC",
                    "FILTER_NAME" => "arrFilterMore",
                    "FIELD_CODE" => Array("DETAIL_PICTURE"),
                    "PROPERTY_CODE" => Array(
                            "profit_id",
                            "profit_number",
                            "profit_rooms",
                            "profit_property_price",
                            "profit_area_living",
                            "profit_floor_id",
                            "profit_house_id",
                            "profit_project_id",
                            "profit_floor_number"
                    ),
                    "CHECK_DATES" => "Y",
                    "DETAIL_URL" => "",
                    "PREVIEW_TRUNCATE_LEN" => "",
                    "ACTIVE_DATE_FORMAT" => "d.m.Y",
                    "SET_TITLE" => "Y",
                    "SET_BROWSER_TITLE" => "Y",
                    "SET_META_KEYWORDS" => "Y",
                    "SET_META_DESCRIPTION" => "Y",
                    "SET_LAST_MODIFIED" => "Y",
                    "INCLUDE_IBLOCK_INTO_CHAIN" => "Y",
                    "ADD_SECTIONS_CHAIN" => "Y",
                    "HIDE_LINK_WHEN_NO_DETAIL" => "Y",
                    "PARENT_SECTION" => "",
                    "PARENT_SECTION_CODE" => "",
                    "INCLUDE_SUBSECTIONS" => "Y",
                    "CACHE_TYPE" => "A",
                    "CACHE_TIME" => "3600",
                    "CACHE_FILTER" => "Y",
                    "CACHE_GROUPS" => "N",
                    "DISPLAY_TOP_PAGER" => "N",
                    "DISPLAY_BOTTOM_PAGER" => "N",
                    "PAGER_TITLE" => "Новости",
                    "PAGER_SHOW_ALWAYS" => "N",
                    "PAGER_TEMPLATE" => "",
                    "PAGER_DESC_NUMBERING" => "N",
                    "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
                    "PAGER_SHOW_ALL" => "N",
                    "PAGER_BASE_LINK_ENABLE" => "N",
                    "SET_STATUS_404" => "Y",
                    "SHOW_404" => "Y",
                    "MESSAGE_404" => "",
                    "PAGER_BASE_LINK" => "",
                    "PAGER_PARAMS_NAME" => "",
                    "AJAX_OPTION_JUMP" => "N",
                    "AJAX_OPTION_STYLE" => "N",
                    "AJAX_OPTION_HISTORY" => "N",
                    "AJAX_OPTION_ADDITIONAL" => ""
                )
            );?>
        </div>
    </div>
</div>


