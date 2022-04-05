<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("TITLE", "Условия покупки");
$APPLICATION->SetTitle("Условия покупки");

?>

<?$APPLICATION->IncludeComponent(
    "bitrix:news",
    "payment.complex",
    array(
        "ADD_ELEMENT_CHAIN" => "Y",
        "ADD_SECTIONS_CHAIN" => "Y",
        "AJAX_MODE" => "N",
        "AJAX_OPTION_ADDITIONAL" => "",
        "AJAX_OPTION_HISTORY" => "N",
        "AJAX_OPTION_JUMP" => "N",
        "AJAX_OPTION_STYLE" => "N",
        "BROWSER_TITLE" => "NAME",
        "CACHE_FILTER" => "N",
        "CACHE_GROUPS" => "Y",
        "CACHE_TIME" => "36000000",
        "CACHE_TYPE" => "A",
        "CHECK_DATES" => "Y",
        "DETAIL_ACTIVE_DATE_FORMAT" => "d.m.Y",
        "DETAIL_DISPLAY_BOTTOM_PAGER" => "N",
        "DETAIL_DISPLAY_TOP_PAGER" => "N",
        "DETAIL_FIELD_CODE" => array(),
        "DETAIL_PAGER_SHOW_ALL" => "Y",
        "DETAIL_PAGER_TEMPLATE" => "",
        "DETAIL_PAGER_TITLE" => "",
        "DETAIL_PROPERTY_CODE" => array(),
        "DETAIL_SET_CANONICAL_URL" => "N",
        "DISPLAY_BOTTOM_PAGER" => "N",
        "DISPLAY_DATE" => "Y",
        "DISPLAY_NAME" => "Y",
        "DISPLAY_PICTURE" => "Y",
        "DISPLAY_PREVIEW_TEXT" => "Y",
        "DISPLAY_TOP_PAGER" => "N",
        "HIDE_LINK_WHEN_NO_DETAIL" => "N",
        "IBLOCK_ID" => PAYMENT_IBLOCK,
        "IBLOCK_TYPE" => "content",
        "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
        "LIST_ACTIVE_DATE_FORMAT" => "",
        "LIST_FIELD_CODE" => array(),
        "LIST_PROPERTY_CODE" => array(),
        "MESSAGE_404" => "",
        "META_DESCRIPTION" => "-",
        "META_KEYWORDS" => "-",
        "NEWS_COUNT" => "9",
        "PAGER_BASE_LINK_ENABLE" => "N",
        "PAGER_DESC_NUMBERING" => "N",
        "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
        "PAGER_SHOW_ALL" => "N",
        "PAGER_SHOW_ALWAYS" => "N",
        "PAGER_TEMPLATE" => ".default",
        "PAGER_TITLE" => "Оплата",
        "PREVIEW_TRUNCATE_LEN" => "",
        "SEF_FOLDER" => "/payment/",
        "SEF_MODE" => "Y",
        "SET_LAST_MODIFIED" => "N",
        "SET_STATUS_404" => "Y",
        "SET_TITLE" => "N",
        "SHOW_404" => "N",
        "SORT_BY1" => "ACTIVE_FROM",
        "SORT_BY2" => "SORT",
        "SORT_ORDER1" => "DESC",
        "SORT_ORDER2" => "ASC",
        "STRICT_SECTION_CHECK" => "N",
        "USE_CATEGORIES" => "N",
        "USE_FILTER" => "N",
        "USE_PERMISSIONS" => "N",
        "USE_RATING" => "N",
        "USE_REVIEW" => "N",
        "USE_RSS" => "N",
        "USE_SEARCH" => "N",
        "USE_SHARE" => "N",
        "COMPONENT_TEMPLATE" => "payment.complex",
        "BANNER_CODE" => "",
        "SHOW_TOP" => "N",
        "SHOW_PROFESSIONS" => "N",
        "SHOW_HISTORIES" => "N",
        "ANCOR_LINK_LIST" => "",
        "SEF_URL_TEMPLATES" => array(
            "news" => "",
            "section" => "",
            "detail" => "#ELEMENT_CODE#/",
        )
    ),
    false
);?>


<?$APPLICATION->IncludeComponent("uplab.core:template.block", "payment-credit", Array(
    "CACHE_FOR_PAGE" => "N",	// Добавить адрес страницы в кеш
    "CACHE_TIME" => "3600000",	// Время кеширования (сек.)
    "CACHE_TYPE" => "A",	// Тип кеширования
    "DELAY" => "N",	// Отложенное выполнение компонента,
    "BANNER_CODE" => $APPLICATION->GetCurDir(),
),
    false
);?>

<?$APPLICATION->IncludeComponent("uplab.core:template.block", "payment-description-text", Array(
        "CACHE_FOR_PAGE" => "N",	// Добавить адрес страницы в кеш
        "CACHE_TIME" => "3600000",	// Время кеширования (сек.)
        "CACHE_TYPE" => "A",	// Тип кеширования
        "DELAY" => "N",	// Отложенное выполнение компонента,
    )
);?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>