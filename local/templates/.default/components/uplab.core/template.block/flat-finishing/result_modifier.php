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

$deb_el = CIBlockElement::GetList(["SORT" => "ASC"], ["IBLOCK_ID" => FISHING_IBLOCK, "ID" => $arParams['FISHING_ID']], false, false)->Fetch();
//GALLERY_FISHING
$db_props = CIBlockElement::GetProperty(FISHING_IBLOCK, $arParams['FISHING_ID']);
while ($prop = $db_props->GetNext())
{
    if($prop['VALUE']){
        $props[$prop['CODE']][] = $prop['VALUE'];
    }
}

$twigData['flatFinishing'] = [

    "title" => "отделка",
    "text" => $deb_el['DETAIL_TEXT'],
];


// Получение галереи отделки
foreach ($props['GALLERY_FISHING'] as $key => $gallery_id)
{
    $twigData['flatFinishing']['gallery'][$key]['img'] = [
        "src" => CFile::GetPath($gallery_id),
        "alt" => 'img'
    ];
}



$arResult["TEMPLATE_DATA"] = $twigData;

