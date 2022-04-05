<?
use Bitrix\Main\Application;
use ProjectName\Local\Helper;
use Uplab\Core\Components\TemplateBlock;
use ProjectName\Local\Config;

defined("B_PROLOG_INCLUDED") && B_PROLOG_INCLUDED === true || die();
/**
 * @global CMain      $APPLICATION
 * @var array         $arParams
 * @var array         $arResult
 * @var TemplateBlock $component
*/



foreach($arResult['ITEMS'] as $key => $item)
{
    $twigData["projects"]['list'][$key]['title'] = $item['NAME'];
    $twigData["projects"]['list'][$key]['text'] = TruncateText($item['DETAIL_TEXT'], 360);
    $twigData["projects"]['list'][$key]['button'] = [
        'href' => $item['DETAIL_PAGE_URL'],
        'text' => "Узнать подробнее",
        "theme" => "blue"
    ];
    $twigData["projects"]['list'][$key]['img'] = [
        "src" => $item['PREVIEW_PICTURE']['SRC'],
        "alt" => "img"
    ];
    
}


$arResult["TEMPLATE_DATA"] = $twigData;
