<?

use Bitrix\Main\Application;
use EuroCement\Local\Helper;
use Uplab\Core\Components\TemplateBlock;

defined("B_PROLOG_INCLUDED") && B_PROLOG_INCLUDED === true || die();

/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 * @var TemplateBlock $component
 */


$elementID = $arParams["EXTRA_NAV_ITEM_ID"];
if ($arParams["EXTRA_NAV_ITEM_CODE"]) {
    $elementID = CIBlockFindTools::GetElementID('', $arParams["EXTRA_NAV_ITEM_CODE"], '', '', []);
}

// breadcrumb
if ($elementID) {
    $nameplate = \Bitrix\Iblock\ElementTable::getById($elementID);
    $name = $nameplate->fetchObject()->getName();
    $APPLICATION->AddChainItem($name);
    $APPLICATION->SetTitle($name);
}

$twigData["breadcrumb"] = $APPLICATION->GetNavChain(
    $path = false,
    $NumFrom = 0,
    $NavChainPath = false,
    $IncludeOnce = true,
    $ShowIcons = true
);

$twigData["aboutDescription"]["title"] = "Квартиры";




$db_floor = CIBlockElement::GetList(['SORT' => "ASC"], ["IBLOCK_ID" => PROFITFLOORS_IBLOCK, "PROPERTY_profit_house_id" => $arResult['DISPLAY_PROPERTIES']['profit_house_id']['VALUE']], false, false, ['ID', "NAME", "IBLOCK_ID", "PREVIEW_PICTURE", "DETAIL_PICTURE"]);
$min_max_floor = getMaxfloorInHouse($arResult['DISPLAY_PROPERTIES']['profit_house_id']['VALUE']); // Минимальный и максимальный этаж в доме по внешнему id

$db_house = CIBlockElement::GetList(['SORT' => "ASC"], ["IBLOCK_ID" => PROFITHOUSES_IBLOCK, "PROPERTY_profit_id" => $arResult['DISPLAY_PROPERTIES']['profit_house_id']['VALUE']], false, false, ["*"]);

if($res_house = $db_house->GetNextElement()){
    $arHouse = $res_house->GetFields();
    $arHouse['PROPS'] = $res_house->GetProperties();
}

while ($floor = $db_floor->GetNextElement()) {
    $arFields = $floor->GetFields();
    $res_prop = $floor->GetProperties();

    if($arFields['DETAIL_PICTURE'])
    {
        $arFields['DETAIL_PICTURE'] = CFile::GetFileArray($arFields['DETAIL_PICTURE']);
    }

    if($arFields['PREVIEW_PICTURE'])
    {
        $arFields['PREVIEW_PICTURE'] = CFile::GetFileArray($arFields['PREVIEW_PICTURE']);
    }

    $arFields['PROPS'] = $res_prop;
    $arFloors[] = $arFields;
}



$map_coordinates = [];
foreach ($arFloors as $key => $floor) {
    $db_appartaments = CIBlockElement::GetList(['SORT' => "ASC"],
    [
        "IBLOCK_ID" => PROFITAPPARTAMENTS_IBLOCK, 
        "PROPERTY_profit_floor_number" => $floor['PROPS']['profit_number']['VALUE'],
        "PROPERTY_profit_house_id" =>  $floor['PROPS']['profit_house_id']['VALUE']
    ],
        false, ['nPageSize' => '1'] );
    while($appart = $db_appartaments->GetNextElement())
    {
        $arAppart = $appart->GetFields();
    }

    $url_floor = $arAppart['DETAIL_PAGE_URL'];

    mpr($url_floor,false,'js');


    $twigData['introFlat']['house'][$key] = [
        "number" => $floor['PROPS']['profit_number']['VALUE'],
        "id" => $floor['PROPS']['profit_id']['VALUE']
    ];
    if($url_floor){
        $twigData['introFlat']['house'][$key]["href"] = $url_floor;
    }


    if($arResult['DISPLAY_PROPERTIES']['profit_floor_number']['VALUE'] == $floor['PROPS']['profit_number']['VALUE'])
    {
        $twigData['introFlat']['flat'] = [
            "id" => $arResult['DISPLAY_PROPERTIES']['profit_id']['VALUE'],
            "isFavorite" => false,
            "img" => [
                "src" => $arResult['DETAIL_PICTURE']['SRC'],
                "alt" => "img"
            ],
            "buttons" => [
                [
                    "theme" => "blue-border-transparent",
                    "attr" => "data-img-src='". $floor['PREVIEW_PICTURE']['SRC']  ."' data-img-alt='img-2' data-svg='true'",
                    "text" => "На этаже"
                ],
                [
                    "theme" => "blue-border-transparent",
                    "attr" => "data-img-src='".$arResult['DETAIL_PICTURE']['SRC']  ."' data-img-alt='img'",
                    "text" => "Планировка",
                    "active" => true
                ]
            ],
            "info" => [
                "people" => 3,
                "title" => $arResult["DISPLAY_PROPERTIES"]["profit_rooms"]['VALUE'] . "-комнатная",
                "square" => $arResult['DISPLAY_PROPERTIES']['profit_area_living']['VALUE'] . " м<sup>2</sup>",
                "bottomText" => "Бронирование осуществляется на 24 часа. Менеджер свяжеится с вами в течении 1 часа",
                "price" => "от ". number_format($arResult["DISPLAY_PROPERTIES"]["profit_property_price"]["VALUE"], 0, ',', ' ') ." ₽",
                "credit" => "Ипотека 6,5%",
                "info" => [
                    [
                        "title" => "Жилой комплекс",
                        "value" => $arResult['DISPLAY_PROPERTIES']['profit_project_name']['VALUE']
                    ],
                    [
                        "title" => "Этаж",
                        "value" => $arResult['DISPLAY_PROPERTIES']['profit_floor_number']['VALUE'] . " из ". $min_max_floor['MAX_FLOOR']
                    ],
                    [
                        "title" => "Заселение",
                        "value" => $arHouse['PROPS']['profit_endstage']['VALUE']
                    ],
                ],
                "buttons" => [
                    [
                        "theme" => "blue-border-transparent",
                        "text" => "Получить консультацию",
                        "href" => "#callback-form",
                        "attr" => "data-fancybox"
                    ],
                    [
                        "theme" => "blue",
                        "text" => "Забронировать",
                        "href" => "#booking-form",
                        "attr" => "data-fancybox"
                    ]
                ]
            ],
        ];

        $appartaments = json_decode(htmlspecialchars_decode($floor['PROPS']['profit_area']['VALUE']), true);
        $current_appartamnet_coordinat = [];
        foreach ($appartaments as $key => $appartament)
        {
            $arFields['PATH'] = $appartament['coordinates'];
            $d = "M " . round($arFields['PATH'][0]['x'], 0) . " " . round( $arFields['PATH'][0]['y'],0);
            for ($i = 1; $i < count($arFields['PATH']); $i++)
            {
              $d .=  " L " . round($arFields['PATH'][$i]['x'], 0) . " " . round(  $arFields['PATH'][$i]['y'], 0);
            }
            $d .= " z";
            $map_coordinates[] = [
                'd' => $d,
                "id" => $appartament['propertyId']
            ];
            if($appartament['propertyId'] == $arResult['DISPLAY_PROPERTIES']['profit_id']['VALUE'])
            {
                $current_appartamnet_coordinat = $appartament;
                $map_coordinates[$key]['current'] = true;
            }

        }
        $twigData['introFlat']['svg']['coordinates'] = $map_coordinates;
        $twigData['introFlat']['svg']['viewbox'] = [
            "width" => $floor['DETAIL_PICTURE']['WIDTH'],
            "height" => $floor['DETAIL_PICTURE']['HEIGHT'],
        ];
    }

}
if(count($twigData['introFlat']['svg']['coordinates']) != 0)
{

    $summX = 0;
    $summY = 0;
    foreach ($current_appartamnet_coordinat['coordinates'] as $coord)
    {
        $summX += $coord['x'];
        $summY += $coord['y'];
    }


    $twigData['introFlat']['flat']['currentCoordinates']['x'] = round($summX / ($twigData['introFlat']['svg']['viewbox']['width'] * count($current_appartamnet_coordinat['coordinates'])), 4);
    $twigData['introFlat']['flat']['currentCoordinates']['y'] = round($summY / ($twigData['introFlat']['svg']['viewbox']['height'] * count($current_appartamnet_coordinat['coordinates'])), 4);

}





mpr($twigData,false,'js');

$arResult["TEMPLATE_DATA"] = $twigData;

