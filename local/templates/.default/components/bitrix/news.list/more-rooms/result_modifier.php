<?
use Bitrix\Main\Application;
use EuroCement\Local\Helper;
use Uplab\Core\Components\TemplateBlock;
use EuroCement\Local\Config;

defined("B_PROLOG_INCLUDED") && B_PROLOG_INCLUDED === true || die();
/**
 * @global CMain      $APPLICATION
 * @var array         $arParams
 * @var array         $arResult
 * @var TemplateBlock $component
 */


$twigData['moreRooms']['title'] = "Похожие квартиры";
$twigData['moreRooms']['button'] = [
    "href" => '/appartaments/',
    "text" => 'Показать еще'
];

$min_max_floor = getMaxfloorInHouse($arResult['ITEMS'][0]['DISPLAY_PROPERTIES']['profit_house_id']['VALUE']);

foreach ($arResult['ITEMS'] as $key => $ITEM)
{
    $db_house = CIBlockElement::GetList(['SORT' => "ASC"], ["IBLOCK_ID" => PROFITHOUSES_IBLOCK, "PROPERTY_profit_id" => $ITEM['DISPLAY_PROPERTIES']['profit_house_id']['VALUE']], false, false, ["*"]);
    if($res_house = $db_house->GetNextElement()){$arHouse = $res_house->GetFields(); $arHouse['PROPS'] = $res_house->GetProperties();}


    $itemList[] = [
        "img" => ["src" => $ITEM['DETAIL_PICTURE']['SRC']],
        "href" => $ITEM["DETAIL_PAGE_URL"],
        "numberOfRooms" => $ITEM['DISPLAY_PROPERTIES']['profit_rooms']['VALUE']."к.",
        "isFavorite" => false,
        "rooms"     => $ITEM['DISPLAY_PROPERTIES']['profit_rooms']['VALUE']."-комнатная",
        "square"    => $ITEM['DISPLAY_PROPERTIES']['profit_area_living']['VALUE'] . " м<sup>2</sup>",
        "price"     =>"от ". number_format($ITEM['DISPLAY_PROPERTIES']['profit_property_price']['VALUE'], 0, ',', ' ') ." ₽",
        "credit"    => "в ипотеку от 18 324 ₽/мес.",
        "floor"     => "Этаж ". $ITEM['DISPLAY_PROPERTIES']['profit_floor_number']['VALUE'] ." из " . $min_max_floor['MAX_FLOOR'],
        "date"      => $arHouse['PROPS']['profit_endstage']['VALUE'],
        "id"        => "",
        "button"    => [
                "theme" => "blue",
                "text"  => "Подробнее"
        ]
    ];
}


$twigData['moreRooms']['list'] = $itemList;
$arResult["TEMPLATE_DATA"] = $twigData;
