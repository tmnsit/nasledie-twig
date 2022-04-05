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
$twigData["aboutDescription"]["title"] = "Контакты";


$arSelect = Array("ID", "NAME", "IBLOCK_ID");
$arFilter = Array("IBLOCK_ID" => CONTACTS_IBLOCK, "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y");
$res = CIBlockElement::GetList(Array("SORT" => "ASC"), $arFilter, false, false, $arSelect);
while($ob = $res->GetNextElement())
{
    $arFields = $ob->GetFields();
    $res_prop = CIBlockElement::GetProperty( $arFields['IBLOCK_ID'], $arFields['ID']);
    $pros = [];
    while($prop = $res_prop->GetNext()){
        $pros[$prop['CODE']] = $prop;
    }
    $arFields['PROPS'] = $pros;
    $contacts_list[] = $arFields;
}



foreach ($contacts_list as $key => $contact){

    $twigData['contacts']['list'][$key]['title'] = $contact['NAME'];
    $twigData['contacts']['list'][$key]['address'] = $contact['PROPS']['ADDRESS']['VALUE'];
    $twigData['contacts']['list'][$key]['email'] = $contact['PROPS']['EMAIL']['VALUE'];
    $twigData['contacts']['list'][$key]['href'] = '#callback-form';


    // Телефон и редактирование для ссылки
    if($contact['PROPS']['PHONE']['VALUE']){
        $tel_fix = $contact['PROPS']['PHONE']['VALUE'];
        $tel_fix = str_replace(array('(', ')', ' ', '-'), '', $tel_fix);
        $twigData['contacts']['list'][$key]['tell'] = [
            "link" => $tel_fix,
            "content" => $contact['PROPS']['PHONE']['VALUE']
        ];
    }

    // Добавление кнопки по свойству
    if($contact['PROPS']['SHOW_BUTTON']['VALUE_ENUM'] == "Y"){
        $twigData['contacts']['list'][$key]['button'] = [
            "theme" => "blue-border-transparent",
            "href" => "#callback-form",
            "attr" => "data-fancybox",
            "text" => "Заказать звонок"
        ];
    }

    // Главный отдел первый по сортировки
    if($key == 0){
        $twigData['contacts']['list'][$key]['main'] = true;
    }
}



$arResult["TEMPLATE_DATA"] = $twigData;