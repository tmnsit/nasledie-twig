<?
use Bitrix\Main\Application;
use EuroCement\Local\Helper;
use Uplab\Core\Components\TemplateBlock;

defined("B_PROLOG_INCLUDED") && B_PROLOG_INCLUDED === true || die();	

/**
 * @global CMain      $APPLICATION
 * @var array         $arParams
 * @var array         $arResult
 * @var TemplateBlock $component
 */

$twigData["aboutDescription"]["title"] = "Партнеры";

$newsDetail = [
    "title" => $arResult['DISPLAY_PROPERTIES']['TITLE']['VALUE'],
    "pList" => [ $arResult['DETAIL_TEXT'] ],
    "mainImg" => ['src' => $arResult['DETAIL_PICTURE']['SRC']],
];

if($arResult['DISPLAY_PROPERTIES']['BUTTON_TEXT']['VALUE']){
    $newsDetail['button'] = [
        'href' => '#callback-form-accept',
        'text' => $arResult['DISPLAY_PROPERTIES']['BUTTON_TEXT']['VALUE'],
        'theme' => 'blue-border-transparent',
        "attr" => "data-fancybox"
    ];
}

if($arResult['DISPLAY_PROPERTIES']['GALLERY']['VALUE']){
    if(count($arResult['DISPLAY_PROPERTIES']['GALLERY']['VALUE']) > 1){
        foreach ($arResult['DISPLAY_PROPERTIES']['GALLERY']['FILE_VALUE'] as $key => $itemFile){
            $newsDetail['galleryList'][$key]['img']['src'] = $itemFile['SRC'];
        }
    }else{
        $newsDetail['galleryList'][0]['img']['src'] = $arResult['DISPLAY_PROPERTIES']['GALLERY']['FILE_VALUE']['SRC'];
    }
}

if($arResult['DISPLAY_PROPERTIES']['PLAN']['VALUE']){
    $newsDetail['linkDownload'] = $arResult['DISPLAY_PROPERTIES']['PLAN']['VALUE'];
}


if($arParams['BACK_LINK']){
    $newsDetail['backLink'] = $arParams['BACK_LINK'];
}

$twigData['newsDetail'] = $newsDetail;



$arResult["TEMPLATE_DATA"] = $twigData;


